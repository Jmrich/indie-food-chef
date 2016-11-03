<?php

namespace App;

use App\Traits\Billable;
use App\Traits\Userable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Customer
 *
 * @property integer $id
 * @property string $stripe_id
 * @property string $card_id
 * @property string $card_brand
 * @property string $card_last_four
 * @property string $billing_zip
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Address[] $addresses
 * @property-read \App\Bag $bag
 * @property-read \App\Chef $chef
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PaymentMethod[] $paymentMethods
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Charge[] $charges
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereStripeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereCardId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereCardBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereCardLastFour($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereBillingZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Customer extends Model
{
    use Userable, Billable;

    protected $with = ['user'];

    /**
     * Get all of the users addresses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    /**
     * Get the user current bag
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bag()
    {
        return $this->hasOne(Bag::class);
    }

    /**
     * Get the chef
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function chef()
    {
        return $this->hasOne(Chef::class);
    }

    /**
     * Get the user orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get user payment methods
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    /**
     * Get charges
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function charges()
    {
        return $this->hasMany(Charge::class);
    }
}
