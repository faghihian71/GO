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
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class CardRepository implements CardRepositoryInterface
{
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
        // TODO: Implement addProductToCard() method.
    }

    public function removeProductFromCard($cardID, $productID)
    {
        // TODO: Implement removeProductFromCard() method.
    }

    public function listProductsInCard($cardID)
    {
        // TODO: Implement listProductsInCard() method.
    }


}
