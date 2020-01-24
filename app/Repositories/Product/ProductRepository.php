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
use Illuminate\Database\QueryException;


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
                throw new DuplicateEntryException("Product name exists", 2000);
            } else {
                throw  $e;
            }
        }
    }

    public function remove($id)
    {
        return Product::destroy($id);

    }

    public function update($id, $request)
    {
        // TODO: Implement update() method.
    }

    public function get($id)
    {
        return  Product::where('id',$id)->first();
    }

    public function list($offset, $limit, $metaDataSearch)
    {
        return Product::paginate($limit);
    }


}
