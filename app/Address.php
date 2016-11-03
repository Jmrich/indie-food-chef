<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Address
 *
 * @property integer $id
 * @property string $place_id
 * @property float $lat
 * @property float $lng
 * @property string $formatted_address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Chef[] $chef
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Kitchen[] $kitchens
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Customer[] $customer
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address wherePlaceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereLng($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereFormattedAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Address whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    public function chef()
    {
        return $this->belongsToMany(Chef::class);
    }

    public function kitchens()
    {
        return $this->belongsToMany(Kitchen::class);
    }

    public function customer()
    {
        return $this->belongsToMany(Customer::class);
    }
}
