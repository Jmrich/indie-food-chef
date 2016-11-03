<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PaymentMethod
 *
 * @property integer $id
 * @property string $source_id
 * @property string $type
 * @property string $card_brand
 * @property string $last_four
 * @property string $zip_code
 * @property boolean $default
 * @property integer $customer_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentMethod whereSourceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentMethod whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentMethod whereCardBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentMethod whereLastFour($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentMethod whereZipCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentMethod whereDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentMethod whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PaymentMethod whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentMethod extends Model
{
    //
}
