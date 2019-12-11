<?php

use Illuminate\Database\Seeder;

class IslaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('islas')->insert([
            ['nombre' => 'EL HIERRO'],
            ['nombre' => 'FUERTEVENTURA'],
            ['nombre' => 'GRAN CANARIA'],
            ['nombre' => 'LA GOMERA'],
            ['nombre' => 'LA PALMA'],
            ['nombre' => 'LANZAROTE'],
            ['nombre' => 'TENERIFE']
        ]);
    }
}
