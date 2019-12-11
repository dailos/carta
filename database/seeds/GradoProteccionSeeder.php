<?php

use Illuminate\Database\Seeder;

class GradoProteccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('grado_proteccions')->insert([
            ['nombre' => 'INTEGRAL'],
            ['nombre' => 'PARCIAL'],
            ['nombre' => 'AMBIENTAL']
        ]);
    }
}
