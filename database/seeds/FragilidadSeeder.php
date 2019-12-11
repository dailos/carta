<?php

use Illuminate\Database\Seeder;

class FragilidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('fragilidads')->insert([
            ['nombre' => 'ALTA'],
            ['nombre' => 'MEDIA'],
            ['nombre' => 'BAJA']
        ]);
    }
}
