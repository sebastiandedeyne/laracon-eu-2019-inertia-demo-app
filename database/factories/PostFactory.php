<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => ucfirst($faker->words(2, true)),
        'contents' => $faker->paragraphs(5, true),
        'published_at' => rand(0, 1) ? now()->subMinutes(rand(0, 60 * 24 * 7)) : null,
    ];
});
