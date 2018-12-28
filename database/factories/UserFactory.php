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

// Se crean los datos aleatorios de acuerdo al modelo Warriors
$factory->define(App\Warriors::class, function (Faker $faker) {
    $array_imagenes = array('0' => 'https://pm1.narvii.com/6147/e5a718cfcce99bd0d954b898229c231f178bad47_hq.jpg',
        '1' => 'http://pm1.narvii.com/6332/bc7b112692ad6a54c1c1edf682ef4bb35bb0c85e_00.jpg',
        '2' => 'https://i.pinimg.com/originals/74/2d/7b/742d7bdabb8b7866901f99d94ad43c78.png',
        '3' => 'http://www.pokemon-sunmoon.com/media/uploads/sept_20_assets/passimian.png',
        '4' => 'https://s3.amazonaws.com/revistapicnic/wp-content/uploads/2016/09/21231758/pok%C3%A9mon-sol-y-luna-lycanroc-forma-diurna.png',
        '5' => 'http://www.gifs-animados.es/clip-art/caricaturas/pokemon/gifs-animados-pokemon-30069.jpg',
        '6' => 'http://3.bp.blogspot.com/-W-pm2LbAAh4/TzmC755RrMI/AAAAAAAAAFU/bw2KGbsQmMA/s1600/FAKEMON___water_starter_by_CountSplatula.jpg',
        '7' => 'http://www.gifs-animados.es/clip-art/caricaturas/pokemon/gifs-animados-pokemon-957578.jpg',
        '8' => 'http://www.gifs-animados.es/clip-art/caricaturas/pokemon/gifs-animados-pokemon-1638197.jpg',
        '9' => 'http://www.gifs-animados.es/clip-art/caricaturas/pokemon/gifs-animados-pokemon-17151.jpg',
        '10' => 'http://amsafallconference.org/wp-content/uploads/2018/10/pichu-evolution-chart-awesome-plusle-pokemon-wiki-of-pichu-evolution-chart-500x500.png',
        '11' => 'http://amsafallconference.org/wp-content/uploads/2018/10/pichu-evolution-chart-elegant-pikachu-pokemon-wiki-of-pichu-evolution-chart-500x500.png',
        '12' => 'http://www.gifs-animados.es/clip-art/caricaturas/pokemon/gifs-animados-pokemon-609671.jpg',
        '13' => 'https://i.pinimg.com/originals/24/cd/9f/24cd9fc2599fa12ee55ddc1d24738295.jpg',
        '14' => 'http://www.gifs-animados.es/clip-art/caricaturas/pokemon/gifs-animados-pokemon-8491351.jpg',
        '15' => 'https://i.pinimg.com/originals/f0/fa/19/f0fa19997850f1f80bd9cffe26feaec7.jpg',
        '16' => 'https://i.pinimg.com/originals/66/8d/fd/668dfd6912069b02e098660382836973.png',
        '17' => 'https://i.pinimg.com/originals/1f/59/b0/1f59b0b106e0e23dc7aca6c07ef37feb.png',
        '18' => 'https://i.pinimg.com/originals/57/38/54/573854369c29c45a453634293689dc2d.png',
        '19' => 'https://i.pinimg.com/originals/b7/6e/31/b76e310b424fc61195b5bbad6cbc81ca.png'
    );
    $rand = array_rand($array_imagenes,1);
    \Log::info($rand);
    $img = $array_imagenes[$rand];
    \Log::info($img);
    $number = rand(5,8); // Se crea un numero aleatorio para crear el nombre del Peleador
    $letters = 'abcefghijklmnopqrstuvwxyz'; // Se declaran las letras que contendrá dicho nombre
    $nombre = substr(str_shuffle($letters), 0, $number); // Primero se hacen aleatorias las letras para despúes 
                                                        // generar el nombre con el tamaño proporcionado por la variable $number
    return [
        'name' => $nombre,
        'speed' => rand(1,5),
        'strength' => rand(1,5),
        'skills' => rand(1,5),
        'img' => $img
    ];
});

