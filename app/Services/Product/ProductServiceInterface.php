<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 13:32
 */

namespace App\Services\Product;


interface ProductServiceInterface
{
    public function create(array $attributes);

    public function remove($id);

    public function update($id , $request);

    public function get($id);
}
