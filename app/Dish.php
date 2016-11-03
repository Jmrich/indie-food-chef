<?php

namespace App;

use App\Traits\QueryScope;
use App\Traits\Reviewable;
use App\Traits\ScopeByKitchen;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Dish
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $price
 * @property integer $extra_cost
 * @property boolean $is_archived
 * @property integer $kitchen_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Menu[] $menus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dish[] $sides
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Section[] $sections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Review[] $reviews
 * @method static \Illuminate\Database\Query\Builder|\App\Dish whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dish whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dish whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dish wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dish whereExtraCost($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dish whereIsArchived($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dish whereKitchenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dish whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dish whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dish extends Model
{
    use Reviewable, QueryScope;

    protected $with = ['sides'];

    protected $fillable = ['name', 'description', 'price', 'extra_cost', 'is_archived'];

    /**
     * Get the dishes menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

    /**
     * Get sides
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sides()
    {
        return $this->belongsToMany(Dish::class, 'dish_side_dish', 'dish_id', 'side_dish_id');
    }

    /**
     * Get the orders the dish belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * Get the categories the dish belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }
}
