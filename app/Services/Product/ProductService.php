<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 13:33
 */

namespace App\Services\Product;


use App\Repositories\Product\ProductRepositoryInterface;

class ProductService implements ProductServiceInterface
{
    private $productServiceRepository =  null;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productServiceRepository = $productRepository;
    }

    public function create(array $attributes)
    {
        $product = $this->productServiceRepository->create($attributes);
        return $product;

    }

    public function remove($id)
    {
        return $this->productServiceRepository->remove($id);
    }

    public function update($id, $request)
    {
        return $this->productServiceRepository->update($id , $request);
    }

    public function get($id)
    {
        return $this->productServiceRepository->get($id);
    }

    public function list($offset , $limit , $metaDataSearch){
        return $this->productServiceRepository->list($offset , $limit , $metaDataSearch);
    }

}
