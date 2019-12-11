<?php

use Illuminate\Database\Seeder;

class ActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('actividads')->insert([
            ['nombre' => 'AGRICULTURA'],
            ['nombre' => 'COMERCIO'],
            ['nombre' => 'CONJUNTO DE INTERÉS ETNOGRÁFICO'],
            ['nombre' => 'GANADERÍA'],
            ['nombre' => 'HIDRAÚLICA'],
            ['nombre' => 'INDUSTRIAS EXTRACTIVAS-RECOLECTORAS'],
            ['nombre' => 'OTROS BIENES SINGULARES'],
            ['nombre' => 'PESCA ARTESANAL'],
            ['nombre' => 'PRODUCCIÓN INDUSTRIAL'],
            ['nombre' => 'TRANSPORTE']
        ]);
    }
}
