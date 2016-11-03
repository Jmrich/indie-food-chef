<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 9/13/16
 * Time: 12:39 PM
 */

namespace App\Traits;


trait QueryScope
{
    /**
     * Scope query by kitchen
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByKitchen($query)
    {
        return $query->where('kitchen_id', getKitchen()->id);
    }
}