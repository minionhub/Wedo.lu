<?php

/* @var $factory Factory */

use App\Model;
use App\Models\ProjectSubCategory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ProjectSubCategory::class, function (Faker $faker) {
    return [
        'sub_category_name' => $faker->name,
    ];
});
