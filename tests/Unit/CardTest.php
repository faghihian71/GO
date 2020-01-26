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




}
