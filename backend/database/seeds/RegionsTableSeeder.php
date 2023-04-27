<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            'name' => 'Capellen'
        ]);

        DB::table('regions')->insert([
            'name' => 'Clervaux'
        ]);

        DB::table('regions')->insert([
            'name' => 'Diekirch'
        ]);

        DB::table('regions')->insert([
            'name' => 'Echternach'
        ]);

        DB::table('regions')->insert([
            'name' => 'Esch-sur-Alzette'
        ]);

        DB::table('regions')->insert([
            'name' => 'Grevenmacher'
        ]);

        DB::table('regions')->insert([
            'name' => 'Luxembourg-campagne'
        ]);

        DB::table('regions')->insert([
            'name' => 'Luxembourg-ville'
        ]);

        DB::table('regions')->insert([
            'name' => 'Mersch'
        ]);

        DB::table('regions')->insert([
            'name' => 'Redange'
        ]);

        DB::table('regions')->insert([
            'name' => 'Remich'
        ]);

        DB::table('regions')->insert([
            'name' => 'Vianden'
        ]);

        DB::table('regions')->insert([
            'name' => 'Wiltz'
        ]);
    }
}
