<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = new Language;
        $lang->key = 0;
        $lang->code = "fr";
        $lang->name = "Français";
        $lang->save();

        $lang = new Language;
        $lang->key = 1;
        $lang->code = "de";
        $lang->name = "Deutsch";
        $lang->save();

        $lang = new Language;
        $lang->key = 2;
        $lang->code = "lu";
        $lang->name = "Lëtzebuergesch";
        $lang->save();

        $lang = new Language;
        $lang->key = 3;
        $lang->code = "en";
        $lang->name = "English";
        $lang->save();

        $lang = new Language;
        $lang->key = 4;
        $lang->code = "pt";
        $lang->name = "Portugues";
        $lang->save();
    }
}
