<?php

/* @var $factory Factory */

use App\Model;
use App\Models\ProjectCategory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ProjectCategory::class, function (Faker $faker) {
    return [
        'category_name' => $faker->name,
        'category_icon' => $faker->name,
    ];
});
