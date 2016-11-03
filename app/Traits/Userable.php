<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 7/30/16
 * Time: 8:45 AM
 */

namespace App\Traits;


use App\User;

trait Userable
{
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}