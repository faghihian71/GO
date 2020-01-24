<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 13:10
 */

namespace App\Repositories\Product;


use App\Exceptions\DuplicateEntryException;
use App\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;


class ProductRepository implements ProductRepositoryInterface
{
    public function create(array $attributes)
    {
        try {
            $product = new Product();
            $product->title = $attributes['title'];
            $product->price = $attributes['price'];
            $product->save();

            return $product;
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];


            if ($errorCode == 1062) {
                // We change exception cause  should not  depend to low level sql exceptions
                throw new DuplicateEntryException("Product name exists", Response::HTTP_CONFLICT);
            } else {
                throw  $e;
            }
        }
    }

    public function remove($id)
    {
        $findedProduct =  Product::find($id);

        if (!$findedProduct) {
            throw new ModelNotFoundException("product not found",Response::HTTP_NOT_FOUND);
        }
        $findedProduct->delete();




    }

    public function update($id, $request)
    {
        try {
            $findedProduct = Product::find($id);

            if (!$findedProduct) {
                throw new ModelNotFoundException("product not found",Response::HTTP_NOT_FOUND);
            }


            $findedProduct->title = $request['title'];
            $findedProduct->price = $request['price'];
            $findedProduct->save();

            return $findedProduct;
        } catch (QueryException $e) {

            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                // We change exception cause  should not  depend to low level sql exceptions
                throw new DuplicateEntryException("Product name exists", Response::HTTP_CONFLICT);
            } else {
                throw  $e;
            }
        }
    }

    public function get($id)
    {
        return Product::where('id', $id)->first();
    }

    public function list($offset, $limit, $metaDataSearch)
    {
        return Product::paginate($limit);
    }


}
