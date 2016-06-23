<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Actor::class, function ($faker) {
    return [
        'cedula' => $faker->randomNumber($nbDigits = 9),
        'nombre' => $faker->name,
        'correo' => $faker->email,
        'telefono' => $faker->randomNumber($nbDigits = 9),
        'tipo_canal' => $faker->randomElement($array = array ('Agentes','Movishop','TAT')),
        'contratante' => $faker->randomElement($array = array ('Movicom','Cellphone')),
        'tipo_contrato' => $faker->randomElement($array = array ('Temporal','Indeterminado')),
        'sueldo' => $faker->randomFloat($nbMaxDecimals = 2, $min = 100000, $max = 1000000),
        'Ubicacion_ID' => 1
    ];
});

$factory->define(App\Simcard::class, function ($faker) {
    return [
        'ICC' => $faker->randomNumber($nbDigits = 9),
        'numero_linea' => $faker->randomNumber($nbDigits = 9),
        'categoria' => $faker->randomElement($array = array ('Prepago','Libre','Postpago')),
        'fecha_adjudicacion' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '2years', $timezone = date_default_timezone_get()),
        'fecha_asignacion' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '2years', $timezone = date_default_timezone_get()),
        'fecha_activacion' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '2years', $timezone = date_default_timezone_get()),
        'fecha_vencimiento' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '2years', $timezone = date_default_timezone_get())
    ];
});