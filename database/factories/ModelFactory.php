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
use Illuminate\Support\Facades\DB;


$factory->define(App\CompraLinea::class, function ($faker) {
    $faker = Faker\Factory::create('es_ES');
    return [
        'tienda_id' => $faker->numberBetween(1,5),
        'compra_id' => $faker->numberBetween(1,10),
        'producto_id' => $faker->numberBetween(1,10),
        'precio' => $faker->randomFloat(3, 0.00, 100.99),
        'tasa_id' => $faker->numberBetween(1,5),
        'cantidad' => $faker->randomFloat(3, 0.00, 10.99),
    ];
});


$factory->define(App\GrupoCliente::class, function ($faker) {
    $faker = Faker\Factory::create('es_ES');
    return [
        'nombre' => $faker->randomElement($array = array ('premium','porMayor','defecto')),
        'ratio_descuento' => $faker->randomFloat(3, 0.00, 10.00)
    ];
});

$factory->define(App\Producto::class, function ($faker) {
    $faker = Faker\Factory::create('es_ES');
    return [
        'categoria_id' => $faker->numberBetween(1,5),
        'ean13' => $faker->ean13,
        'referencia' => $faker->word,
        'atributo' => $faker->randomElement($array = array ('Talla','Color')),
        'atributo_valor' => $faker->colorName,
        'nombre' => $faker->word,
        'unidad_mesura' => $faker->randomElement($array = array ('unidad','Kg','L')),
        'precio' => $faker->randomFloat(3, 0.000, 100.99),
        'tasa_id' => $faker->numberBetween(1,5),
        'stock_minimo' => $faker->randomFloat(3, 0.000, 10.99),
        'activo' => $faker->boolean,
        'fabricante' => $faker->word,
        'imagen' => $faker->imageUrl($width = 400, $height = 200, 'food')
    ];
});

$factory->define(App\Proveedor::class, function (Faker\Generator $faker) {
    $faker = Faker\Factory::create('es_ES');
    return [
        'nombre' => $faker->domainWord,
        'direccion' => $faker->streetName,
        'ciudad' => $faker->city,
        'telefono' => $faker->phoneNumber,
        'email' => $faker->email,
        'codigo_postal' => $faker->postcode,
        'pais' => $faker->country
    ];
});

$factory->define(App\Empleado::class, function (Faker\Generator $faker) {
    $faker = Faker\Factory::create('es_ES');
    return [
        'nombre' => $faker->firstName(null),
        'apellidos' => $faker->lastName,
        'direccion' => $faker->streetName,
        'ciudad' => $faker->city,
        'telefono' => $faker->phoneNumber,
        'codigo_postal' => $faker->postcode,
        'pais' => $faker->country,
        'email' => $faker->email,
        'dni' => $faker->regexify('[0-9]{8}[A-Z]'),
        'tienda_id' => $faker->numberBetween(1,3)
    ];
});

$factory->define(App\Tienda::class, function (Faker\Generator $faker) {
    $faker = Faker\Factory::create('es_ES');
    return [
        'nombre' => $faker->domainWord,
        'direccion' => $faker->streetName,
        'ciudad' => $faker->city,
        'telefono' => $faker->phoneNumber,
        'email' => $faker->email,
        'codigo_postal' => $faker->postcode,
        'pais' => $faker->country
    ];
});



$factory->define(App\Cliente::class, function (Faker\Generator $faker) {
    $faker = Faker\Factory::create('es_ES');
    return [
        'grupo_cliente_id' => $faker->numberBetween(1,3),
        'nombre' => $faker->firstName(null),
        'apellidos' => $faker->lastName,
        'direccion' => $faker->streetName,
        'ciudad' => $faker->city,
        'telefono' => $faker->phoneNumber,
        'codigo_postal' => $faker->postcode,
        'pais' => $faker->country,
        'email' => $faker->email,
        'dni' => $faker->regexify('[0-9]{8}[A-Z]'),
        'codigo' => $faker->ean13,
    ];
});

