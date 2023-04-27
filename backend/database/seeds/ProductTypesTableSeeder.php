<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
            'name' => 'main'
        ]);

        DB::table('product_types')->insert([
            'name' => 'addon'
        ]);

        DB::table('product_types')->insert([
            'name' => 'one-time'
        ]);
    }
}
