<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    const THRESHOLD_PRODUCT_ADD_ERR_CODE = 1001;

    const ERROR_DICTIONARY = [
        self::THRESHOLD_PRODUCT_ADD_ERR_CODE => 'You cannot add more than 3 products'
    ];


    public function product()
    {
        return $this->belongsToMany(Product::class, 'card_product')->withTimestamps();
    }

}
