<?php

namespace App\Http\Controllers\Api\Product;

use App\Exceptions\DuplicateEntryException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductStandardJsonResponse;
use App\Services\Product\ProductServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Http\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    private $productService = null;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->productService->list(null, 3, null);
        return ProductResource::collection($products);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $createdProduct = $this->productService->create($request->toArray());
            return (new ProductResource($createdProduct))
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

        $updatedProdcut = $this->productService->update($id, $request->toArray());
        return (new ProductResource($updatedProdcut));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->productService->remove($id);

    }


}
