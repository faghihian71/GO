<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function cards()
    {
        return $this->belongsToMany(Card::class, 'card_product')->withTimestamps();
    }

}
