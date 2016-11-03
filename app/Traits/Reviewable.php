<?php
/**
 * Created by PhpStorm.
 * User: jmrichardsonjr
 * Date: 7/30/16
 * Time: 10:10 AM
 */

namespace App\Traits;


use App\Review;

trait Reviewable
{
    public function reviews()
    {
        return $this->morphToMany(Review::class, 'reviewable');
    }
}