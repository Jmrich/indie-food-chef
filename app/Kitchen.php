<?php

namespace App;

use App\Traits\Connectable;
use App\Traits\Reviewable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Kitchen
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $slug
 * @property string $food_category
 * @property string $stripe_id
 * @property string $stripe_public_key
 * @property string $stripe_secret_key
 * @property boolean $is_active
 * @property boolean $delivers
 * @property integer $chef_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Address[] $address
 * @property-read \App\Chef $chef
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dish[] $dishes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Menu[] $menus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Hour[] $hours
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Review[] $reviews
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereFoodCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereStripeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereStripePublicKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereStripeSecretKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereDelivers($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereChefId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Kitchen whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Kitchen extends Model
{
    use Reviewable, Connectable;

    protected $with = ['hours', 'addresses'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the kitchens address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function addresses()
    {
        return $this->hasMany(KitchenAddress::class);
    }

    /**
     * Get the chef
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chef()
    {
        return $this->belongsTo(Chef::class);
    }

    /**
     * Get the dishes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }

    /**
     * Get the menus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * Get the orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the business hours
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hours()
    {
        return $this->hasMany(Hour::class);
    }

    /**
     * Get the active menu for the kitchen
     *
     * @return Menu
     */
    public function currentMenu()
    {
        return $this->menus()->where('is_active', 1)->first();
    }

    public static function findByLocation($lat, $lng, $distance = 5)
    {
        $miles = 3959;

        $km = 6371;

        $select_statement = "select * , ( ? * acos( cos( radians(?) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( lat ) ) ) ) AS distance from kitchens HAVING distance < ? ORDER BY distance";

        return static::hydrateRaw($select_statement, [$miles, $lat, $lng, $lat, $distance]);
    }
}
