<?php

namespace App;

use App\Traits\ScopeByKitchen;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Section
 *
 * @property integer $id
 * @property string $name
 * @property integer $menu_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $kitchen_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dish[] $dishes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Menu[] $menus
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereMenuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section whereKitchenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Section unscopedAll()
 * @mixin \Eloquent
 */
class Section extends Model
{
    use ScopeByKitchen;

    public function dishes()
    {
        return $this->belongsToMany(Dish::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
}
