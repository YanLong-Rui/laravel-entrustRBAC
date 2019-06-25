<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Comments::class, function (Faker $faker) {
    return [
        'body' => $faker->text(),
        'commentable_id' => $faker->numberBetween(1,20),
        'commentable_type' => $faker->words([1,'post']),
    ];
});
