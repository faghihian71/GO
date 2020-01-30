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

class ProductCardResource extends ResourceCollection
{
    private $totalSum = 0;
    public function setTotalSum($totalSum){
        $this->totalSum = $totalSum;
    }
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
            'data' => $this->collection,

           // 'products'=> ProductResource::collection($this->product)
        ];
    }


}
