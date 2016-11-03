<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Review
 *
 * @property integer $id
 * @property string $review
 * @property integer $stars
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereReview($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereStars($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Review whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    /**
     * Get all of the dishes that are assigned this review.
     */
    public function dishes()
    {
        return $this->morphedByMany(Dish::class, 'reviewable');
    }

    /**
     * Get all of the kitchens that are assigned this review.
     */
    public function kitchens()
    {
        return $this->morphedByMany(Kitchen::class, 'reviewable');
    }
}
