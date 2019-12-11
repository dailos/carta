<?php

use Illuminate\Database\Seeder;


class FichaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //disable foreign key check for this connection before running seeder
        Schema::disableForeignKeyConstraints();
        // Truncate tables
        DB::table('fotos')->truncate();
        DB::table('fichas')->truncate();
        //enable foreign key check
        Schema::enableForeignKeyConstraints();
        
    	$fichas = factory(App\Ficha::class, 10)
            ->create()
            ->each(function ($f) {
                $foto = factory(App\Foto::class)->create();
                $croquis = factory(App\Foto::class)->state('croquis')->create();
                $f->fotos = ['fotos' => [$foto->id], 'croquis' => [$croquis->id]];
                $f->save();
            });
    	$fichas_contactos = factory(App\Ficha::class, 5)
            ->state('contacto')
    		->create()
    		->each(function ($f) {
                $foto = factory(App\Foto::class)->create();
                $croquis = factory(App\Foto::class)->state('croquis')->create();
                $f->fotos = ['fotos' => [$foto->id], 'croquis' => [$croquis->id]];
                $f->save();
            });
    }

}