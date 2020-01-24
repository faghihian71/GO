<?php
/**
 * Created by PhpStorm.
 * User: babakfaghihian
 * Date: 1/24/2020 AD
 * Time: 13:33
 */

namespace App\Services\Product;


use App\Repsitories\Product\ProductRepositoryInterface;

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
        // TODO: Implement remove() method.
    }

    public function update(&$id, $request)
    {
        // TODO: Implement update() method.
    }

    public function get(&$id)
    {
        // TODO: Implement get() method.
    }

}
