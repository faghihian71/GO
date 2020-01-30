<?php

namespace App\Http\Controllers\Api\ProductCard;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Http\Resources\ProductCardResource;
use App\Services\Card\CardServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;


class ProductCardController extends Controller
{
    private $cardService = null;

    public function __construct(CardServiceInterface $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cardID)
    {
       list($paginatedItems , $totalSum) = $this->cardService->listProductsInCardWithTotalSum($cardID);

        $cardResource = new ProductCardResource($paginatedItems);
        $cardResource->additional(['meta' => [
            'total_sum' => $totalSum,
        ]]);

        return $cardResource
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $cardId)
    {

            $productId = $request->get('id');
            $createdCard = $this->cardService->addProductToCard($cardId,$productId);
            return response()->json()->setStatusCode(Response::HTTP_OK);


    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cardID , $productID)
    {

        $this->cardService->removeProductFromCard($cardID,$productID);
        return response()->json()->setStatusCode(Response::HTTP_OK);

    }


}
