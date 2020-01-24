<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Gog Main Products
        DB::table('products')->insert([
            'title' => 'Fallout',
            'price' => 1.99,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'title' => 'Dont Starve',
            'price' => 2.99,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'title' => "Baldur's Gate",
            'price' => 3.99,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'title' => "Icewind Dale",
            'price' => 4.99,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s')
        ]);

        DB::table('products')->insert([
            'title' => "Bloodborne",
            'price' => 5.99,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s')
        ]);
    }
}
