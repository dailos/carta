<?php

use Illuminate\Database\Seeder;

class CalificacionSueloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('calificacion_suelos')->insert([
            ['nombre' => 'RÚSTICO DE ASENTAMIENTO AGRÍCOLA'],
            ['nombre' => 'RÚSTICO DE ASENTAMIENTO RURAL'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN AGRARIA'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN COSTERA'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN CULTURAL'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN DE BARRANCOS'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN DE ENTORNOS'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN DE INFRAESTRUCTURAS'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN FORESTAL'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN HIDROLÓGICA'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN INTEGRAL'], // NUEVO
            ['nombre' => 'RÚSTICO DE PROTECCIÓN MINERA'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN NATURAL'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN PAISAJÍSTICA'],
            ['nombre' => 'RÚSTICO DE PROTECCIÓN TERRITORIAL'],
            ['nombre' => 'RÚSTICO NO PROTEGIDO'], // NUEVO
            ['nombre' => 'RÚSTICO RESIDUAL ESPECÍFICO'], // NUEVO
            ['nombre' => 'SISTEMAS GENERALES'], // NUEVO
            ['nombre' => 'URBANIZABLE ESTRATÉGICO'], // NUEVO
            ['nombre' => 'URBANIZABLE NO SECTORIZADO'],
            ['nombre' => 'URBANIZABLE NO SECTORIZADO DIFERIDO'],
            ['nombre' => 'URBANIZABLE NO SECTORIZADO ESTRATÉGICO'],
            ['nombre' => 'URBANIZABLE NO SECTORIZADO TURÍSTICO'],
            ['nombre' => 'URBANIZABLE SECTORIZADO'],
            ['nombre' => 'URBANO CONSOLIDADO'],
            ['nombre' => 'URBANO CONSOLIDADO DE INTERÉS CULTURAL'],
            ['nombre' => 'URBANO CONSOLIDADO DE REHABILITACIÓN URBANA'],
            ['nombre' => 'URBANO DE INTERÉS CULTURAL'],
            ['nombre' => 'URBANO NO CONSOLIDADO'],
            ['nombre' => 'URBANO NO CONSOLIDADO DE INTERÉS CULTURAL'],
            ['nombre' => 'URBANO NO CONSOLIDADO DE REHABILITACIÓN'],
            ['nombre' => 'DOTACIÓN ESCOLAR'], // NUEVO
            ['nombre' => 'ESPACIO LIBRE-VERDE, PQ.URBANO'], // NUEVO
            ['nombre' => 'RED VIARIA'], // NUEVO
            ['nombre' => 'VIÑEDOS'], // NUEVO

        ]);
    }
}
