<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ApplicationFee
 *
 * @property string $id
 * @property string $account
 * @property integer $amount
 * @property integer $amount_refunded
 * @property string $charge_id
 * @property boolean $refunded
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationFee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationFee whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationFee whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationFee whereAmountRefunded($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationFee whereChargeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationFee whereRefunded($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationFee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ApplicationFee whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ApplicationFee extends Model
{
    //
}
