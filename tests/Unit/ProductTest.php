<?php

namespace Tests\Unit;


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


        $factory = new Factory();
        $this->testCreationData = $factory->define(App\Product::class, function (Generator $faker) {
            return [
                'title' => $faker->name,
                'price' => $faker->numberBetween(1,100000)
            ];
        });

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
