<?php

namespace Tests\Feature;

use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
{
    private $testCreationData;
    private $testCreationDataForProduct;
    private $faker;


    public function  setUp()
    {
        parent::setUp();

        // make fake data
        $this->faker = \Faker\Factory::create();
        $this->testCreationData = [
            'title' => $this->faker->name,
        ];

        $this->testCreationDataForProduct = [
            'title' => $this->faker->name,
            'price' => $this->faker->numberBetween(1,1000)
        ];


    }

    public function testCreateACard(){

        $response = $this->post('/api/v1/card',
            $this->testCreationData);
        $response->assertStatus(201);

    }

    public function testCanAddAProductToCard(){

        $response = $this->post('/api/v1/card',
            $this->testCreationData);

        $decodedResponse = json_decode($response->content() , true);
        $cardID = $decodedResponse['data']['id'];

        $response = $this->post('/api/v1/product',
            $this->testCreationDataForProduct);

        $decodedResponse = json_decode($response->content() , true);
        $productId = $decodedResponse['data']['id'];

        $finalResponse = $this->post('/api/v1/card/'.$cardID.'/product',
            ['id'=>$productId]);


        $finalResponse->assertStatus(200);



    }



}
