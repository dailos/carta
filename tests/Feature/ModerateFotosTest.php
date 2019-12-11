<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Ficha;
use App\Foto;
use App\ModerableRecord;
use App\Repositories\Fotos;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModerateFotosTest extends TestCase
{
	use RefreshDatabase;

	protected $rightfulUser;
    protected $unrightfulUser;
    protected $collaborator;

	function setUp()
	{
	    parent::setUp();

	    $this->seed('RolesAndPermissionsTableSeeder');
	    $this->seed('IslaSeeder');
	    $this->seed('MunicipioSeeder');
	    $this->rightfulUser = factory(User::class)->create();
	    $this->rightfulUser->givePermissionTo('moderate');
	    $this->unrightfulUser = factory(User::class)->create();
	    $this->collaborator = factory(User::class)->create();
	}

    /**
     * 
     *
     * @return void
     */
    public function testRemoveChangedFotosOnCreate()
    {
    	$fotosRepo = new Fotos();

        $this->actingAs($this->collaborator);

        $foto = factory(Foto::class)->create();
        $croquis = factory(Foto::class)->create();

        $moderableModel = factory(Ficha::class)->make([
        	'fotos' => ['fotos' => [$foto->id], 'croquis' => [$croquis->id]],
        ]);

        $moderableModel->moderate()->save();

        $moderation = ModerableRecord::first();

        $fotosRepo->deleteAll($moderation->fields['fotos']);

        // Eliminar petición de moderación
        $moderation->delete();

        $this->assertTrue(ModerableRecord::first() == null);
        $this->assertTrue(Foto::find($foto->id) == null);
        $this->assertTrue(Foto::find($croquis->id) == null);
 
    }

    /**
     * 
     *
     * @return void
     */
    public function testRemoveChangedFotosOnUpdate()
    {
        $fotosRepo = new Fotos();

        $this->actingAs($this->collaborator);

        $foto1 = factory(Foto::class)->create();
        $foto2 = factory(Foto::class)->create();
        $croquis = factory(Foto::class)->create();

        $ficha = factory(Ficha::class)->create([
            'fotos' => ['fotos' => [$foto1->id, $foto2->id], 'croquis' => [$croquis->id]],
        ]);

        $foto3 = factory(Foto::class)->create();

        $moderableModel = factory(Ficha::class)->make([
            'fotos' => ['fotos' => [$foto2->id, $foto3->id], 'croquis' => null],
        ]);

        $moderableModel->moderate()->save();

        $moderation = ModerableRecord::first();

        $fotosRepo->deleteDiff($ficha->fotos, $moderation->fields['fotos']);

        // Eliminar petición de moderación
        $moderation->delete();

        $this->assertTrue(ModerableRecord::first() == null);
        $this->assertTrue(Foto::find($foto1->id) == null);
        $this->assertTrue(Foto::find($foto2->id) != null);
        $this->assertTrue(Foto::find($foto3->id) != null);
        $this->assertTrue(Foto::find($croquis->id) == null);
    
    }
}
