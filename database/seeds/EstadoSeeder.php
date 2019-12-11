<?php

use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('estados')->insert([
            ['nombre' => 'BUENO'],
            ['nombre' => 'REGULAR'],
            ['nombre' => 'MALO']
        ]);
    }
}
