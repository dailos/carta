<?php

use Illuminate\Database\Seeder;

class PropiedadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('propiedads')->insert([
            ['nombre' => 'PRIVADA'],
            ['nombre' => 'PUBLICA']
        ]);
    }
}
