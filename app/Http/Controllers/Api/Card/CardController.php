<?php

namespace App\Http\Controllers\Api\Card;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Services\Card\CardServiceInterface;
use \Illuminate\Http\Response;
use Illuminate\Http\Request;


class CardController extends Controller
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
    public function index(Request $request)
    {
       //todo
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $createdCard = $this->cardService->create($request->toArray());
            return (new CardResource($createdCard))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);


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
    public function destroy($id)
    {



    }


}
