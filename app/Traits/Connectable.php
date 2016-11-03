<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 8/26/16
 * Time: 12:24 PM
 */

namespace App\Traits;


use Stripe\Account as StripeAccount;

trait Connectable
{
    /**
     * The Stripe API key.
     *
     * @var string
     */
    protected static $stripeKey;

    public function createStripeAccount()
    {
        if (! $this->getEmail()) {
            throw new \Exception('Email is required');
        }

        $account = StripeAccount::create([
            "country" => "US",
            "managed" => false,
            "email" => $this->getEmail()
        ], ['api_key' => $this->getStripeKey()]);

        $this->updateModel($account);
    }

    /**
     * Update the model with the stripe account details
     *
     * @param StripeAccount $account
     */
    public function updateModel($account)
    {
        $this->forceFill([
            'stripe_id' => $account->id,
            'stripe_secret_key' => $account->keys['secret'],
            'stripe_public_key' => $account->keys['publishable']
        ])->save();
    }

    /**
     * Get the email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
}