<?php

use Illuminate\Database\Seeder;

class ClasificacionSueloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('clasificacion_suelos')->insert([
            ['nombre' => 'RÚSTICO'],
            ['nombre' => 'URBANIZABLE'],
            ['nombre' => 'URBANO'],
            ['nombre' => 'SISTEMAS GENERALES'],  // NUEVO
        ]);
    }
}
