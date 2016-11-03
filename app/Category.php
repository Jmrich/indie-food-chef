<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dish[] $dishes
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    /**
     * Get the dishes that the category has
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dishes()
    {
        return $this->belongsToMany(Dish::class);
    }
}
