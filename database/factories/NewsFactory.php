<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\News::class, function (Faker $faker) {
    return [
        'author_id' => 1,
        'title' => $faker->jobTitle,
        'content' => $faker->text
    ];
});
