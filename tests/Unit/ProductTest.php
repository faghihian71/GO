<?php

namespace Tests\Unit;


use App\Product;
use App\Repsitories\Product\ProductRepository;
use App\Services\Product\ProductService;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    private $testCreationData;

    /**
     *  make global dependencies
     */
    public function setUp()
    {
        parent::setUp();

        // make fake data
        $faker = \Faker\Factory::create();
        $this->testCreationData = [
                'title' => $faker->name,
                'price' => $faker->numberBetween(1,100000)
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

        // Product Service expcets productRepositoryInterface
        $productService = new ProductService($productRepostiroy);

        $result = $productService->create($this->testCreationData);


        $this->assertEquals($result->title , $this->testCreationData['title'] );

    }


}
