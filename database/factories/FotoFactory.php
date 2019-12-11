<?php

use Faker\Generator as Faker;

$factory->define(App\Foto::class, function (Faker $faker) {
    return [
        'nombre' => 'nombre',
        'src' => config('carta.fotoStoragePath') . '/foto0' . $faker->numberBetween(1, 2, 3) . '.jpeg',
    ];
});

$factory->state(App\Foto::class, 'croquis', [
	'src' => config('carta.fotoStoragePath') . '/croquis01.jpeg',
]);