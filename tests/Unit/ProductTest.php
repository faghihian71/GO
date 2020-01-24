<?php

namespace Tests\Unit;


use App\Product;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{

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

        $productService->create();

    }


}
