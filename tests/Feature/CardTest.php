<?php

namespace Tests\Feature;

use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
{
    use RefreshDatabase;
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
        $response->assertStatus(Response::HTTP_CREATED);

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


        $finalResponse->assertStatus(Response::HTTP_OK);



    }

    public function testCanRemoveAProductFromACard(){

        $response = $this->post('/api/v1/card',
            $this->testCreationData);

        // Fetch CardID
        $decodedResponse = json_decode($response->content() , true);
        $cardID = $decodedResponse['data']['id'];

        $response = $this->post('/api/v1/product',
            $this->testCreationDataForProduct);

        // Fetch ProductID
        $decodedResponse = json_decode($response->content() , true);
        $productId = $decodedResponse['data']['id'];

        // Add product To Card
        $this->post('/api/v1/card/'.$cardID.'/product',
            ['id'=>$productId]);


        $finalResponse = $this->delete('/api/v1/card/'.$cardID.'/product/'.$productId,
            ['id'=>$productId]);


        $finalResponse->assertStatus(Response::HTTP_OK);



    }

    public function testCanGetListOfProductsOfACard()
    {

        $response = $this->post('/api/v1/card',
            $this->testCreationData);

        // Fetch CardID
        $decodedResponse = json_decode($response->content() , true);
        $cardID = $decodedResponse['data']['id'];

        $response = $this->post('/api/v1/product',
            $this->testCreationDataForProduct);

        // Fetch ProductID
        $decodedResponse = json_decode($response->content() , true);
        $productId = $decodedResponse['data']['id'];

        // Add product To Card
        $this->post('/api/v1/card/'.$cardID.'/product',
            ['id'=>$productId]);


        $finalResponse = $this->get('/api/v1/card/'.$cardID.'/product');
        $finalResponse->assertSee( $this->testCreationDataForProduct['title']);

    }



}
