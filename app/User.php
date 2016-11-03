<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $userable_id
 * @property string $userable_type
 * @property string $stripe_id
 * @property string $card_brand
 * @property string $card_last_four
 * @property string $billing_zip
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|Chef|Customer $userable
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Review[] $reviews
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStripeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCardBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCardLastFour($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereBillingZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //protected $with = ['userable'];

    /**
     * Get all of the owning userable models
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function userable()
    {
        return $this->morphTo();
    }

    /**
     * Get the reviews
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function ownsOrder($order)
    {
        return $this->userable->id == $order->customer_id;
    }
}
