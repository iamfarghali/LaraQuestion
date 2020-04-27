<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define( Question::class, function ( Faker $faker ) {
    return [
        'title'   => rtrim( $faker->sentence( rand( 3, 10 ), '.' ) ),
        'body'    => $faker->paragraphs( rand( 5, 12 ), true ),
        'views'   => rand( 0, 50 ),
        'answers' => rand( 0, 10 ),
        'votes'   => rand( -10, 20 )
    ];
} );
