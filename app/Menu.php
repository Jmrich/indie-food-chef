<?php

namespace App;

use App\Traits\QueryScope;
use App\Traits\ScopeByKitchen;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Menu
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property boolean $is_active
 * @property boolean $is_archived
 * @property integer $kitchen_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dish[] $dishes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Section[] $sections
 * @property-read \App\Kitchen $kitchen
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereIsActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereIsArchived($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereKitchenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu unscopedAll()
 * @mixin \Eloquent
 */
class Menu extends Model
{
    use QueryScope;

    /**
     * Get all the dishes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dishes()
    {
        return $this->belongsToMany(Dish::class)
            ->withPivot(['start_date', 'end_date', 'starting_quantity', 'quantity_remaining']);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }

    /**
     * Get the kitchen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kitchen()
    {
        return $this->hasOne(Kitchen::class);
    }

    /**
     * Get the total cost of all dishes on the menu
     *
     * @return integer
     */
    public function totalMenuCost()
    {
        if ($this->withCount('dishes')->get()->dishes_count == 0) {
            return 0;
        }

        return $this->dishes->map(function ($dish) {
            return $dish->price;
        })->sum();
    }
}
