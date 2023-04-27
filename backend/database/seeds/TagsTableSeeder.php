<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            "name" => "Aide à domicile",
            "slug" => "first-tag-slug"
        ]);

        DB::table('tags')->insert([
            "name" => "Alimentation - Événement",
            "slug" => str_slug("Alimentation - Événement", "-")
        ]);

        DB::table('tags')->insert([
            "name" => "Astuces",
            "slug" => str_slug("Astuces", "-")
        ]);

        DB::table('tags')->insert([
            "name" => "Beauté & Bien-être",
            "slug" => str_slug("Beauté & Bien-être", "-")
        ]);

        DB::table('tags')->insert([
            "name" => "Fédération des Artisans",
            "slug" => str_slug("Fédération des Artisans", "-")
        ]);

        DB::table('tags')->insert([
            "name" => "Garagistes & Mécanique",
            "slug" => str_slug("Garagistes & Mécanique", "-")
        ]);

        DB::table('tags')->insert([
            "name" => "Jardin & Extérieur",
            "slug" => str_slug("Jardin & Extérieur", "-")
        ]);

        DB::table('tags')->insert([
            "name" => "Maison",
            "slug" => str_slug("Maison", "-")
        ]);

        DB::table('tags')->insert([
            "name" => "Online Marketing",
            "slug" => str_slug("Online Marketing", "-")
        ]);

        DB::table('tags')->insert([
            "name" => "Presse",
            "slug" => str_slug("Presse", "-")
        ]);
    }
}
