<?php

use Illuminate\Database\Seeder;

class ValorCientificoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('valor_cientificos')->insert([
            ['nombre' => 'ALTO'],
            ['nombre' => 'MEDIO'],
            ['nombre' => 'BAJO']
        ]);
    }
}
