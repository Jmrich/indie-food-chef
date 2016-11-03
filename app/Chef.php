<?php

namespace App;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Chef
 *
 * @package App
 * @property integer $id
 * @property string $stripe_id
 * @property string $bank_account
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Address[] $address
 * @property-read \App\Kitchen $kitchen
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Chef whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Chef whereStripeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Chef whereBankAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Chef whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Chef whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Chef extends Model
{
    use Userable;

    protected $with = ['user'];

    /**
     * Get the business address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function address()
    {
        return $this->belongsToMany(Address::class);
    }

    /**
     * Get the chefs kitchen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kitchen()
    {
        return $this->hasOne(Kitchen::class);
    }
}
