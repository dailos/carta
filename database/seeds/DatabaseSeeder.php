<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(TruncateAllSeeder::class);
        
        $this->call(ActividadSeeder::class);
        $this->call(AntiguedadSeeder::class);
        $this->call(ClasificacionSueloSeeder::class);
        $this->call(CalificacionSueloSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(FragilidadSeeder::class);
        $this->call(GradoProteccionSeeder::class);
        $this->call(GrupoSeeder::class);
        $this->call(IslaSeeder::class);
        $this->call(MunicipioSeeder::class);
        $this->call(LocalidadSeeder::class);
        $this->call(PropiedadSeeder::class);
        $this->call(TipoContactoSeeder::class);
        $this->call(TipoSeeder::class);
        $this->call(UsoActualSeeder::class);
        $this->call(ValorCientificoSeeder::class);
        
        $this->call(RolesAndPermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $this->call(FichaSeeder::class);

    }
}
