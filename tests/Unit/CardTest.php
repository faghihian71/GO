<?php

namespace Tests\Unit;


use App\Exceptions\DuplicateEntryException;
use App\Exceptions\ExceedThresholdOfProductsInCardException;
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

        $this->testProductCreationData = $this->makeNewFakeProduct();


    }

    public function makeNewFakeProduct(){

        return [
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
        $listOfProducts =  $cardService->listProductsInCardWithTotalSum($card->id);
        $this->assertEquals(1, count($listOfProducts[0]) );


    }
    public function testIsNotPossibleAddMoreThanThresholdProduct(){

        $this->expectException(ExceedThresholdOfProductsInCardException::class);

        $productRepostiroy = new ProductRepository();
        $productService = new ProductService($productRepostiroy);


        $firstProduct = $productService->create($this->makeNewFakeProduct());
        $secondProduct = $productService->create($this->makeNewFakeProduct());
        $thirdProduct = $productService->create($this->makeNewFakeProduct());
        $fourthProduct = $productService->create($this->makeNewFakeProduct());


        $cardRepository = new CardRepository();
        $cardService = new CardService($cardRepository);

        $card = $cardService->create($this->testCreationData);

        $cardService->addProductToCard($card->id , $firstProduct->id);
        $cardService->addProductToCard($card->id , $secondProduct->id);
        $cardService->addProductToCard($card->id , $thirdProduct->id);
        $cardService->addProductToCard($card->id , $fourthProduct->id);

        $listOfProducts =  $cardService->listProductsInCard($card->id);
        $this->assertEquals(1 , count($listOfProducts[0]));


    }

    public function testRemoveAProductFromACard(){

        $productRepostiroy = new ProductRepository();
        $productService = new ProductService($productRepostiroy);
        $createdProduct = $productService->create($this->testProductCreationData);


        $cardRepository = new CardRepository();
        $cardService = new CardService($cardRepository);

        $card = $cardService->create($this->testCreationData);

        $cardService->addProductToCard($card->id , $createdProduct->id);
        $cardService->removeProductFromCard($card->id ,$createdProduct->id);

        $listOfProducts =  $cardService->listProductsInCardWithTotalSum($card->id);
        $this->assertEquals(0 , count($listOfProducts[0]));



    }

    public function testIsSumOfProductsCorrect(){

        $productRepostiroy = new ProductRepository();
        $productService = new ProductService($productRepostiroy);


        $firstProduct = $productService->create($this->makeNewFakeProduct());
        $secondProduct = $productService->create($this->makeNewFakeProduct());
        $thirdProduct = $productService->create($this->makeNewFakeProduct());
        $fourthProduct = $productService->create($this->makeNewFakeProduct());


        $cardRepository = new CardRepository();
        $cardService = new CardService($cardRepository);

        $card = $cardService->create($this->testCreationData);

        $cardService->addProductToCard($card->id , $firstProduct->id);
        $cardService->addProductToCard($card->id , $secondProduct->id);
        $cardService->addProductToCard($card->id , $thirdProduct->id);

        $expectedSum = $firstProduct->price + $secondProduct->price + $thirdProduct->price;

        //
        $listOfProducts =  $cardService->listProductsInCardWithTotalSum($card->id);
        $totalSum = $listOfProducts[1];
        $this->assertEquals($expectedSum , $listOfProducts[1]);


    }









}
