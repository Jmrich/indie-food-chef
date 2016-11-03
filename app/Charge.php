<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Charge
 *
 * @property string $id
 * @property integer $amount
 * @property integer $amount_refunded
 * @property boolean $captured
 * @property string $application_fee
 * @property integer $customer_id
 * @property string $source_id
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Order $order
 * @property-read \App\Customer $customer
 * @property-read \App\ApplicationFee $applicationFees
 * @method static \Illuminate\Database\Query\Builder|\App\Charge whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Charge whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Charge whereAmountRefunded($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Charge whereCaptured($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Charge whereApplicationFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Charge whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Charge whereSourceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Charge whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Charge whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Charge whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Charge extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function applicationFees()
    {
        return $this->hasOne(ApplicationFee::class);
    }
}
