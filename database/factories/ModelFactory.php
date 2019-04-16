<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use Illuminate\Support\Str;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret')
    ];
});

$factory->define(App\Gallery::class, function(Faker $faker){       //uvek je drugi parametar callback i uvek vraca asocijativni niz gde je key naziv atributa
    return[
        "name" => $faker->realText(255),
        "description" => $faker->paragraph,
    ];
 });

 $factory->define(App\Photo::class, function(Faker $faker){       //uvek je drugi parametar callback i uvek vraca asocijativni niz gde je key naziv atributa
    return[
        "url" =>  $faker->imageUrl($width = 640, $height = 480),
    ];
 });


 $factory->define(App\Comment::class, function(Faker $faker){       //uvek je drugi parametar callback i uvek vraca asocijativni niz gde je key naziv atributa
    return[
        "text" =>  $faker->paragraph,
    ];
 });


