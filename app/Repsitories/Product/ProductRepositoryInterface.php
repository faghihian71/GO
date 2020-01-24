<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 13:07
 */

namespace App\Repsitories\Product;


interface ProductRepositoryInterface
{
    public function create($attributes);

    public function remove($id);

    public function update(&$id , $request);

    public function get(&$id);

}
