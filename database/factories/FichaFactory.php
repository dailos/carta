<?php

use Faker\Generator as Faker;

$factory->define(App\Ficha::class, function (Faker $faker) {
    return [
        'cod_ficha' => $faker->unique()->numberBetween(1000, 9999),
        'denominacion' => $faker->sentence,
        'isla_id' => 3,
        'municipio_id' => $faker->numberBetween(10, 30),
        'actividad_id' => $faker->numberBetween(1, 10),
        'grupo_id' => $faker->numberBetween(1, 35),
        'tipo_id' => $faker->numberBetween(1, 243),
        'direccion' => $faker->streetAddress,
        'cod_postal' => $faker->postcode,
        'toponimias' => $faker->sentence($nbWords = 2, $variableNbWords = true),
        'obs_localizacion' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'antiguedad_id' => $faker->numberBetween(1, 6),
        'historia' => $faker->text($maxNbChars = 500),
    ];
});

$factory->state(App\Ficha::class, 'contacto', function ($faker) {
    return [
        'contactos' => [$faker->numberBetween(1, 4) => 
            [
                'nombre' => $faker->name,
                'telefono' => $faker->e164PhoneNumber,
                'id_documento' => strval($faker->numberBetween(1000000, 9000000)),
                'direccion' => $faker->address,
                'email' => $faker->safeEmail,
            ]]
    ];
});
