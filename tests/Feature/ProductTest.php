<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    private $testCreationData;
    private $faker;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function  setUp()
    {
        parent::setUp();

        // make fake data
        $this->faker = \Faker\Factory::create();
        $this->testCreationData = [
            'title' => $this->faker->name,
            'price' => $this->faker->numberBetween(1, 100000)
        ];


    }


    public function testCreateAProduct(){

        $response = $this->post('/api/v1/product',
            $this->testCreationData);
        $response->assertStatus(201);

    }

    public function testGetListOfProducts(){

        $response = $this->get('/api/v1/product');
        $response->assertStatus(200);
        $response->assertSee("data");
    }

    public function testRemoveAProduct(){

        $productRepostiroy = new ProductRepository();
        $productService = new ProductService($productRepostiroy);
        $result = $productService->create($this->testCreationData);


        $response = $this->delete('/api/v1/product/'.$result->id);
        $response->assertStatus(200);
    }
}
