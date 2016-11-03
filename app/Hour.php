<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Hour
 *
 * @property integer $id
 * @property boolean $day_of_week
 * @property string $open
 * @property string $closed
 * @property integer $kitchen_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Kitchen $kitchen
 * @method static \Illuminate\Database\Query\Builder|\App\Hour whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Hour whereDayOfWeek($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Hour whereOpen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Hour whereClosed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Hour whereKitchenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Hour whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Hour whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Hour extends Model
{
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
}
