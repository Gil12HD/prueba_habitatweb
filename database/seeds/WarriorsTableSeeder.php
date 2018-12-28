<?php

use Illuminate\Database\Seeder;

class WarriorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Se trunca la tabla
        App\Warriors::truncate();
        // Se especifica el numero de datos que se crearán de acuerdo al modelo Warriors
        factory(App\Warriors::class, 20)->create();
    }
}
