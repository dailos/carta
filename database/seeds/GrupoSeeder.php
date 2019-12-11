<?php

use Illuminate\Database\Seeder;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('grupos')->insert([
            ['nombre' => 'AÉREO'],
            ['nombre' => 'ALMACENAMIENTO'],
            ['nombre' => 'ALMACENES'],
            ['nombre' => 'AMBULANTE'],
            ['nombre' => 'ARTESANIA'],
            ['nombre' => 'CANTERAS'],
            ['nombre' => 'CAPTACION'],
            ['nombre' => 'COMERCIO'],
            ['nombre' => 'CONSERVAS'],
            ['nombre' => 'DISTRIBUCIÓN'],
            ['nombre' => 'ELABORACIÓN DE QUESOS'],
            ['nombre' => 'EXPLOTACIONES SINGULARES'],
            ['nombre' => 'EXTRACCIÓN'],
            ['nombre' => 'FINCAS AGRÍCOLAS'],
            ['nombre' => 'GESTIÓN DEL AGUA'],
            ['nombre' => 'GESTIÓN DEL GANADO'],
            ['nombre' => 'HORNOS'],
            ['nombre' => 'INDUSTRIA AGROALIMENTARIA'],
            ['nombre' => 'LUGARES DE ELABORACIÓN'],
            ['nombre' => 'MANTENIMIENTO'],
            ['nombre' => 'MANUFACTURA'],
            ['nombre' => 'MARITIMO'],
            ['nombre' => 'OTROS'],
            ['nombre' => 'PAISAJES ETNOGRÁFICOS'],
            ['nombre' => 'PASTOREO'],
            ['nombre' => 'POBLADOS'],
            ['nombre' => 'PUERTOS'],
            ['nombre' => 'SALAZÓN'],
            ['nombre' => 'SALINAS'],
            ['nombre' => 'SERVICIOS'],
            ['nombre' => 'SILVICULTURA'],
            ['nombre' => 'TALLERES'],
            ['nombre' => 'TERRENOS DE PRODUCCION'],
            ['nombre' => 'TERRESTRE'],
            ['nombre' => 'VENTA DE PRODUCTOS']
        ]);
    }
}
