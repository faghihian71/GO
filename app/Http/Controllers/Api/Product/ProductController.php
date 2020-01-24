<?php

namespace App\Http\Controllers\Api\Product;

use App\Exceptions\DuplicateEntryException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductStandardJsonResponse;
use App\Services\Product\ProductServiceInterface;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $createdProduct = $this->productService->create($request->toArray());
            return (new ProductResource($createdProduct))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);

        } catch (DuplicateEntryException $ex) {

            return response()->json([
                'message' => $ex->getMessage(),
                'status' => Response::HTTP_CONFLICT,
                'error_code' => $ex->getCode()
            ], Response::HTTP_CONFLICT);

        } catch (\Exception $ex) {

            return response()->json([
                'message' => $ex->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error_code' => $ex->getCode()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        try {

            $updatedProdcut = $this->productService->update($id, $request->toArray());
            return (new ProductResource($updatedProdcut));

        } catch (DuplicateEntryException $ex) {

            return response()->json([
                'message' => $ex->getMessage(),
                'status' => Response::HTTP_CONFLICT,
                'error_code' => $ex->getCode()
            ], Response::HTTP_CONFLICT);

        } catch (NotFoundHttpException $ex){

            return response()->json([
                'message' => $ex->getMessage(),
                'status' => Response::HTTP_NOT_FOUND,
                'error_code' => Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);

        } catch (\Exception $ex) {

            return response()->json([
                'message' => $ex->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error_code' => $ex->getCode()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (!$this->productService->remove($id)) {
                return response()->json([
                        'message' => 'product not found',
                        'status' => Response::HTTP_NOT_FOUND,
                        'error_code' => Response::HTTP_NOT_FOUND]
                    , Response::HTTP_NOT_FOUND);
            }


        } catch (\Exception $ex) {

            return response()->json([
                'message' => $ex->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error_code' => $ex->getCode()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
