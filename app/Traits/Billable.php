<?php

namespace App\Traits;

use App\Ifc;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;
use Stripe\Stripe;
use Stripe\Token as StripeToken;
use Stripe\Charge as StripeCharge;
use Stripe\Refund as StripeRefund;
use Stripe\Customer as StripeCustomer;

trait Billable
{
    /**
     * The Stripe API key.
     *
     * @var string
     */
    protected static $stripeKey;

    /**
     * Charge the customer for the given amount.
     *
     * @param  int $amount
     * @param $connected_account
     * @param  array $options
     * @return StripeCharge
     * @throws \Exception
     */
    public function charge($amount, $connected_account, array $options = [])
    {
        if (! $this->stripe_id) {
            throw new \Exception('Stripe id not set');
        }

        $options = array_merge([
            'currency' => $this->preferredCurrency(),
            'capture' => false,
            'amount' => $amount,
            'source' => $this->createTokenFromPlatformKey($connected_account),
            'application_fee' => $this->calculateApplicationFee($amount)
        ], $options);

        return StripeCharge::create($options, [
            'api_key' => $this->getStripeKey(),
            'stripe_account' => $connected_account->stripe_id
        ]);
    }

    /**
     * Refund a customer for a charge.
     *
     * @param string $charge_id
     * @param Model $connected_account
     * @param  array $options
     * @return StripeCharge
     */
    public function refund($charge_id, $connected_account, array $options = [])
    {
        $charge = StripeCharge::retrieve($charge_id, [
            'stripe_account' => $connected_account->stripe_id,
            'api_key' => $this->getStripeKey()
        ]);

        if (! array_key_exists('amount', $options) && $this->stripe_id) {
            $options['amount'] = $charge->amount;
        }

        return $charge->refunds->create($options);
    }

    /**
     * Determines if the customer currently has a card on file.
     *
     * @return bool
     */
    public function hasCardOnFile()
    {
        return (bool) $this->card_brand;
    }

    /**
     * Update customer's credit card.
     *
     * @param  string  $token
     * @return void
     */
    public function updateCard($token)
    {
        $customer = $this->asStripeCustomer();

        $token = StripeToken::retrieve($token, ['api_key' => $this->getStripeKey()]);

        // If the given token already has the card as their default source, we can just
        // bail out of the method now. We don't need to keep adding the same card to
        // the user's account each time we go through this particular method call.
        if ($token->card->id === $customer->default_source) {
            return;
        }

        $card = $customer->sources->create(['source' => $token]);

        $customer->default_source = $card->id;

        $customer->save();

        // Next, we will get the default source for this user so we can update the last
        // four digits and the card brand on this user record in the database, which
        // is convenient when displaying on the front-end when updating the cards.
        $source = $customer->default_source
            ? $customer->sources->retrieve($customer->default_source)
            : null;

        $this->fillCardDetails($source);

        $this->save();
    }

    /**
     * Synchronises the customer's card from Stripe back into the database.
     *
     * @return $this
     */
    public function updateCardFromStripe()
    {
        $customer = $this->asStripeCustomer();

        $defaultCard = null;

        foreach ($customer->sources->data as $card) {
            if ($card->id === $customer->default_source) {
                $defaultCard = $card;
                break;
            }
        }

        if ($defaultCard) {
            $this->fillCardDetails($defaultCard)->save();
        } else {
            $this->forceFill([
                'card_brand' => null,
                'card_last_four' => null,
            ])->save();
        }

        return $this;
    }

    /**
     * Fills the user's properties with the source from Stripe.
     *
     * @param \Stripe\Card|null  $card
     * @return $this
     */
    protected function fillCardDetails($card)
    {
        if ($card) {
            $this->card_brand = $card->brand;
            $this->card_last_four = $card->last4;
        }

        return $this;
    }

    /**
     * Apply a coupon to the billable entity.
     *
     * @param  string  $coupon
     * @return void
     */
    public function applyCoupon($coupon)
    {
        $customer = $this->asStripeCustomer();

        $customer->coupon = $coupon;

        $customer->save();
    }

    /**
     * Determine if the entity has a Stripe customer ID.
     *
     * @return bool
     */
    public function hasStripeId()
    {
        return ! is_null($this->stripe_id);
    }

    /**
     * Create a Stripe customer for the given user.
     *
     * @param  string  $token
     * @param  array  $options
     * @return StripeCustomer
     */
    public function createAsStripeCustomer($token, array $options = [])
    {
        $options = array_key_exists('email', $options)
            ? $options : array_merge($options, ['email' => $this->email]);

        // Here we will create the customer instance on Stripe and store the ID of the
        // user from Stripe. This ID will correspond with the Stripe user instances
        // and allow us to retrieve users from Stripe later when we need to work.
        $customer = StripeCustomer::create(
            $options, $this->getStripeKey()
        );

        $this->stripe_id = $customer->id;

        $this->save();

        // Next we will add the credit card to the user's account on Stripe using this
        // token that was provided to this method. This will allow us to bill users
        // when they subscribe to plans or we need to do one-off charges on them.
        if (! is_null($token)) {
            $this->updateCard($token);
        }

        return $customer;
    }

    /**
     * Get the Stripe customer for the user.
     *
     * @return \Stripe\Customer
     */
    public function asStripeCustomer()
    {
        return StripeCustomer::retrieve($this->stripe_id, $this->getStripeKey());
    }

    /**
     * Get the Stripe supported currency used by the entity.
     *
     * @return string
     */
    public function preferredCurrency()
    {
        return 'usd';
    }

    /**
     * Get the tax percentage to apply to the subscription.
     *
     * @return int
     */
    public function taxPercentage()
    {
        return 0;
    }

    /**
     * Get the Stripe API key.
     *
     * @return string
     */
    public static function getStripeKey()
    {
        if (static::$stripeKey) {
            return static::$stripeKey;
        }

        if ($key = getenv('STRIPE_SECRET')) {
            return $key;
        }

        return config('services.stripe.secret');
    }

    /**
     * Set the Stripe API key.
     *
     * @param  string  $key
     * @return void
     */
    public static function setStripeKey($key)
    {
        static::$stripeKey = $key;
    }

    /**
     * Create a token to use with the connected account
     *
     * @param $connected_account
     * @return StripeToken
     */
    protected function createTokenFromPlatformKey($connected_account)
    {
        //Stripe::setApiKey($this->getStripeKey());

        return StripeToken::create([
            'customer' => $this->stripe_id,
            'card' => $this->getDefaultSource()
        ], [
            'api_key' => $this->getStripeKey(),
            'stripe_account' => $connected_account->stripe_id
        ]);
    }

    /**
     * Get default payment source
     *
     * @return string
     */
    public function getDefaultSource()
    {
        $customer = $this->asStripeCustomer();

        return $customer->default_source;
    }

    public function calculateApplicationFee($amount)
    {
        $money = new Money((int) $amount, new Currency('USD'));

        $money = $money->multiply(Ifc::$commission);

        $money = $money->divide(100);

        return $money->getAmount();
        //return bcdiv(bcmul($amount, 10, 4), 100, 4);
    }

    public function processCapturedCharge($charge_id, $connected_account)
    {
        $charge = StripeCharge::retrieve($charge_id, [
            'stripe_account' => $connected_account->stripe_id,
            'api_key' => $this->getStripeKey()
        ]);

        return $charge->capture();
    }
}