<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 23:23
 */

namespace App\Repositories\Card;


use App\Card;
use App\Exceptions\DuplicateEntryException;
use App\Exceptions\ExceedThresholdOfProductsInCardException;
use App\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CardRepository implements CardRepositoryInterface
{
    const PRODUCTS_IN_CARD_THRESHOLD = 3;

    public function create($attributes)
    {
        try {
            $card = new Card();
            $card->title = $attributes['title'];
            $card->save();

            return $card;
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];


            if ($errorCode == 1062) {
                // We change exception cause  should not  depend to low level sql exceptions
                throw new DuplicateEntryException("Card name exists", Response::HTTP_CONFLICT);
            } else {
                throw  $e;
            }
        }
    }

    public function addProductToCard($cardID, $productID)
    {
        $findedCard = Card::findOrFail($cardID);
        if(!$findedCard){
            throw new ModelNotFoundException();
        }

        $findedProduct = Product::findOrFail($productID);

        DB::beginTransaction();

        // Prevent Race Conditions of adding products
        DB::table('cards')->where('id', '=', $cardID)->lockForUpdate()->get();


        if($findedCard->product->count() <=2) {
            $findedCard->product()->save($findedProduct);
        }  else {

            DB::rollBack();

            throw new ExceedThresholdOfProductsInCardException(Card::ERROR_DICTIONARY[CARD::THRESHOLD_PRODUCT_ADD_ERR_CODE]
            ,CARD::THRESHOLD_PRODUCT_ADD_ERR_CODE);
        }

        DB::commit();


    }

    public function removeProductFromCard($cardID, $productID)
    {
        $findedCard = Card::findOrFail($cardID);
        if(!$findedCard){
            throw new ModelNotFoundException();
        }

        $findedProduct = Product::findOrFail($productID);

        DB::beginTransaction();

        // Prevent Race Conditions of adding products
        DB::table('cards')->where('id', '=', $cardID)->lockForUpdate()->get();

        $findedCard->product()->detach($findedProduct->id);

        DB::commit();

    }

    public function listProductsInCard($cardID)
    {
        $findedCard = Card::findOrFail($cardID);
        return $findedCard->product()->paginate(self::PRODUCTS_IN_CARD_THRESHOLD);
    }


    public function getTotalSumOfProductsInCard($cardID){
         return Card::findOrFail($cardID)->product()->sum('price');
    }




}
