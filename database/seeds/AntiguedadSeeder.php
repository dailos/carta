<?php

use Illuminate\Database\Seeder;

class AntiguedadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('antiguedads')->insert([
            ['nombre' => 'SIGLO XX'],
            ['nombre' => 'SIGLO XIX'],
            ['nombre' => 'SIGLO XVIII'],
            ['nombre' => 'SIGLO XVII'],
            ['nombre' => 'SIGLO XVI'],
            ['nombre' => 'SIGLO XV O ANTERIOR'], // NUEVO

        ]);
    }
}
