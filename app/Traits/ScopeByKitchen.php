<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 9/5/16
 * Time: 4:18 PM
 */

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait ScopeByKitchen
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('kitchen', function (Builder $builder) {
            //static::kitchenGuard();

            $builder->where('kitchen_id', getChef()->kitchen->id);
        });
    }

    public function scopeUnscopedAll($query)
    {
        return $query->withoutGlobalScope('kitchen');
    }

    protected static function kitchenGuard()
    {
        if (! userIsAChef()) {
            throw new \Exception('User must be authenticated and a chef');
        }
    }
}