<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 13:10
 */

namespace App\Repsitories\Product;


use App\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(array $attributes)
    {
        $product = new Product();
        $product->title  = $attributes['title'];
        $product->price  = $attributes['price'];
        $product->save();
    }

    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    public function update(&$id, $request)
    {
        // TODO: Implement update() method.
    }

    public function get(&$id)
    {
        // TODO: Implement get() method.
    }


}
