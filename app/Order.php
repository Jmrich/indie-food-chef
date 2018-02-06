<?php

namespace App;

use App\Traits\QueryScope;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @property integer $id
 * @property integer $kitchen_id
 * @property integer $customer_id
 * @property string $charge_id
 * @property integer $subtotal
 * @property integer $tax
 * @property integer $total
 * @property boolean $is_complete
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Kitchen $kitchen
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dish[] $dishes
 * @property-read \App\Charge $charge
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereKitchenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereChargeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereSubtotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereTax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereIsComplete($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use QueryScope;

    protected $with = ['dishes'];

    /**
     * Get the kitchen
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    /**
     * Get the dishes for the order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dishes()
    {
        return $this->belongsToMany(Dish::class)->withPivot('quantity', 'notes');
    }

    public function charge()
    {
        return $this->hasOne(Charge::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope query by kitchen
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotCancelled($query)
    {
        return $query->where('is_cancelled', 0);
    }
}
