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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

// Factory para currículos

$factory->define(App\Curriculo::class, function(Faker\Generator $faker){

	return [
		'nome'               => $faker->name,
		'nascimento'         => $faker->date('Y-m-d', '-18 years'),
		'cpf'                => $faker->numerify('###.###.###-##'),
		'rg'                 => $faker->numerify('##.###.###-#'),
		'pis'                => $faker->numerify('########'),
		'ctps'               => $faker->numerify('########'),
		'titulo'             => $faker->numerify('########'),
		'indicacao_politica' => $faker->boolean,
		'formacao'           => $faker->randomElement(['Fundamental', 'Médio', 'Superior']),
		'telefone_1'         => $faker->numerify("####-####"),
		'telefone_2'         => $faker->numerify("#####-####"),
		'rua'                => $faker->randomElement(['Rua', 'Avenida', 'Travessa'])." ".$faker->streetName,
		'numero'             => $faker->numerify("###"),
		'bairro'             => $faker->randomElement([
										'Coréia', 
										'Centro', 
										'Santa Terezinha', 
										'Areia Branca', 
										'Juscelino', 
										'Chatuba'
									]),
		'cep'                => $faker->numerify("#####-###"),
		'sexo'               => $faker->randomElement(['M', 'F']),
		'created_at'         => $faker->dateTimeBetween('-7 weeks', 'now'),
	];

});


$factory->define(App\Area::class, function(Faker\Generator $faker){

	return [
		'descricao' => $faker->randomElement(['Pedreiro(a)', 'Marceneiro(a)', 'Balconista', 'Auxiliar de Servicos Gerais'])
	];

});