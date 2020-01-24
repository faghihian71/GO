<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 17:08
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price . ' USD'
        ];
    }



}
