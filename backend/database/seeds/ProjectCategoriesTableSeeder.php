<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectCategories = [];

        array_push($projectCategories, array(
            'category_name' => 'Construction & Rénovation',
            'category_slug' => 'construction', // custom slug!
            'category_icon' => '/icons/construction.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Sanitaire, Chauffage & Isolation',
            'category_icon' => '/icons/sanitaire.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Électricité & Domotique',
            'category_icon' => '/icons/lamp.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Revêtement Mur & Sol',
            'category_icon' => '/icons/revetement.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Portes & Fenêtres',
            'category_icon' => '/icons/portes.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Cuisine & Électroménager',
            'category_icon' => '/icons/cuisine.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Mobilier & Décoration',
            'category_icon' => '/icons/mobilier.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Jardin & Exterieur',
            'category_icon' => '/icons/jardin.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Beauté & Bien-être',
            'category_icon' => '/icons/flower.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Mode & Santé',
            'category_icon' => '/icons/mode.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Événements',
            'category_icon' => '/icons/events.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Communication & Multimedia',
            'category_slug' => 'communication-multi-media', // custom slug!
            'category_icon' => '/icons/communication.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Garagistes & Mécanique',
            'category_icon' => '/icons/garagistes.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Services administratifs',
            'category_icon' => '/icons/services_administratifs.svg',
        ));

        array_push($projectCategories, array(
            'category_name' => 'Alimentation & événements',
            'category_icon' => '/icons/alimentation.svg',
        ));

        foreach ($projectCategories as $category) {
            if (empty($category['category_slug'])) $category['category_slug'] = Str::slug($category['category_name']);
            DB::table('project_categories')->insert($category);
        }
    }
}
