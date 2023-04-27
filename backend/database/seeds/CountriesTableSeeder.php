<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['name' => 'Lituanie'],
            ['name' => 'Liechtenstein'],
            ['name' => 'Libye'],
            ['name' => 'Liberia'],
            ['name' => 'Liban'],
            ['name' => 'Lettonie'],
            ['name' => 'Luxembourg'],
            ['name' => 'Macao S.A.R., Chine'],
            ['name' => 'Macédoine'],
            ['name' => 'Madagascar'],
            ['name' => 'Malaisie'],
            ['name' => 'Malawi'],
            ['name' => 'Maldives'],
            ['name' => 'Mali'],
            ['name' => 'Malte'],
            ['name' => 'Martinique'],
            ['name' => 'Mauritanie'],
            ['name' => 'Mayotte'],
            ['name' => 'Micronésie'],
            ['name' => 'Mexique'],
            ['name' => 'Mozambique'],
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert($country);
        }
    }
}
