<?php

use Illuminate\Database\Seeder;

class UsoActualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('uso_actuals')->insert([
        	['nombre' => 'ABANDONADO'],
        	['nombre' => 'AGRÍCOLA'],
        	['nombre' => 'ALMACÉN'],
        	['nombre' => 'COMERCIAL'],
        	['nombre' => 'CULTIVO'],
        	['nombre' => 'ESCOLAR'],
        	['nombre' => 'ESTANQUE'],
        	['nombre' => 'GARAJE'],
        	['nombre' => 'INDUSTRIAL'],
        	['nombre' => 'ORIGINARIO'],
            ['nombre' => 'OTROS USOS'],
        	['nombre' => 'REFUGIO DE CAZADORES'],
        	['nombre' => 'VIVIENDA']
        ]);
    }
}
