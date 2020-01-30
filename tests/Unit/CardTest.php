<?php

namespace Tests\Unit;


use App\Exceptions\DuplicateEntryException;
use App\Product;
use App\Repositories\Card\CardRepository;
use App\Repositories\Product\ProductRepository;
use App\Services\Card\CardService;
use App\Services\Product\ProductService;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
{
    private $testCreationData;
    private $testProductCreationData;
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
        ];

        $this->testProductCreationData = [
            'title' => $this->faker->name,
            'price'=>$this->faker->numberBetween(1,1000)
        ];


    }

    /**
     * Test for creating a card
     *
     * @return void
     */
    public function testCreateCard()
    {

        $cardRepository = new CardRepository();
        $cardService = new CardService($cardRepository);
        $result = $cardService->create($this->testCreationData);

        $this->assertEquals($result->title, $this->testCreationData['title']);

    }


    /**
     * Test can create a card with same name that exist
     */
    public function testCreateACardWithSameName()
    {

        $this->expectException(DuplicateEntryException::class);
        $cardRepository = new CardRepository();
        $cardService = new CardService($cardRepository);


        $cardService->create($this->testCreationData);
        $cardService->create($this->testCreationData);


    }


    public function testCanUpdateACardWithNameThatExistBefore(){

        $this->expectException(DuplicateEntryException::class);
        $cardRepository = new CardRepository();
        $cardService = new CardService($cardRepository);


        $first_card = $cardService->create($this->testCreationData);
        $second_card = $cardService->create(['title'=>'custom_title']);

        $cardService->update(['title'=>'custom_title']);


    }


    public function testCanAddaProductToCard(){

        $productRepostiroy = new ProductRepository();
        $productService = new ProductService($productRepostiroy);
        $createdProduct = $productService->create($this->testProductCreationData);


        $cardRepository = new CardRepository();
        $cardService = new CardService($cardRepository);

        $card = $cardService->create($this->testCreationData);

        $cardService->addProductToCard($card->id , $createdProduct->id);
        $listOfProducts =  $cardService->listProductsInCard($card->id);
        $this->assertEquals(count($listOfProducts) , 1);






    }







}
