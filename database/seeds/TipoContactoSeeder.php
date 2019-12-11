<?php

use Illuminate\Database\Seeder;

class TipoContactoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('tipo_contactos')->insert([
            ['nombre' => 'Propietario'],
            ['nombre' => 'Representante'],
            ['nombre' => 'Guardian'],
            ['nombre' => 'Usuario'],
            ['nombre' => 'Otro']
        ]);
    }
}
