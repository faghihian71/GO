<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 23:20
 */

namespace App\Repositories\Card;


interface CardRepositoryInterface
{
    public function create($attributes);

    public function addProductToCard($cardID , $productID);

    public function removeProductFromCard($cardID , $productID);

    public function listProductsInCard($cardID);
}
