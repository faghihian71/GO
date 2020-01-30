<?php

namespace Tests\Feature;

use App\Repositories\Product\ProductRepository;
use App\Services\Product\ProductService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
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
        ];


    }

    public function testCreateACard(){

        $response = $this->post('/api/v1/card',
            $this->testCreationData);

        $response->assertStatus(201);

    }

}
