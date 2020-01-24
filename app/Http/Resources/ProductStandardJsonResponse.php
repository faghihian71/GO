<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 17:08
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;

class ProductStandardJsonResponse extends Resource
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
            'type'          => 'games',
            'id'            => (string)$this->id,
            'attributes'    => [
                'title' => $this->title,
                'price' => $this->price,
            ],
        ];
    }

}
