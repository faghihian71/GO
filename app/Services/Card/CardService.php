<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 23:26
 */

namespace App\Services\Card;
use App\Repositories\Card\CardRepositoryInterface;

class CardService implements CardServiceInterface
{
    private $cardRepository = null;
    public function __construct(CardRepositoryInterface $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function create($attributes)
    {

        return $this->cardRepository->create($attributes);

    }

    public function addProductToCard($cardID, $productID)
    {
        return $this->cardRepository->addProductToCard($cardID,$productID);
    }

    public function removeProductFromCard($cardID, $productID)
    {
        return $this->cardRepository->removeProductFromCard($cardID,$productID);
    }

    public function listProductsInCard($cardID)
    {
        return $this->cardRepository->listProductsInCard($cardID);
    }


}
