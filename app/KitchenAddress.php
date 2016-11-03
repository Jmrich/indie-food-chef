<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KitchenAddress extends Model
{
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
}
