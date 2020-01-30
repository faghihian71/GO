<?php

namespace Tests\Unit;


use App\Exceptions\DuplicateEntryException;
use App\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductService;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private $testCreationData;
    private $faker;

    /**
     *  make global dependencies
     */
    public function setUp()
    {
        parent::setUp();

        // make fake data
        $this->faker = \Faker\Factory::create();
        $this->testCreationData = [
            'title' => $this->faker->name,
            'price' => $this->faker->numberBetween(1, 100000)
        ];


    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateProduct()
    {

        $productRepostiroy = new ProductRepository();
        $productService = new ProductService($productRepostiroy);
        $result = $productService->create($this->testCreationData);


        $this->assertEquals($result->title, $this->testCreationData['title']);

    }

    public function testCreateProductWithSameName()
    {


        $this->expectException(DuplicateEntryException::class);

        $productRepostiroy = new ProductRepository();
        $productService = new ProductService($productRepostiroy);
        $productService->create($this->testCreationData);
        $productService->create($this->testCreationData);


    }

    public function testGetAProduct(){

        $productRepostiroy = new ProductRepository();
        $productService = new ProductService($productRepostiroy);

        $createdProduct = $productService->create($this->testCreationData);
        $findedProduct = $productService->get($createdProduct->id);

        $this->assertEquals($createdProduct->title , $findedProduct->title);

    }

    public function updateAProduct(){

        $productRepostiroy = new ProductRepository();
        $productService = new ProductService($productRepostiroy);

        $createdProduct = $productService->create($this->testCreationData);
        $updatedProduct = $productService->update($createdProduct->id,['title'=>'new_title','price'=>200]);

        $this->assertEquals($updatedProduct->title , $createdProduct->title);



    }


    public function testRemoveAProduct()
    {

        $productRepostiroy = new ProductRepository();
        $productService = new ProductService($productRepostiroy);
        $result = $productService->create($this->testCreationData);


        $productID = $result->id;
        $productService->remove($productID);
        $findedProduct = $productService->get($result->id);

        $this->assertEquals($findedProduct , null);


    }


}
