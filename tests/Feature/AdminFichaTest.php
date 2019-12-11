<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Ficha;
use App\User;
use Illuminate\Support\Facades\Log;

class AdminFichaTest extends TestCase
{

	use RefreshDatabase;

	function setUp()
	{
	    parent::setUp();

	    $this->seed('RolesAndPermissionsTableSeeder');
	    $this->seed('IslaSeeder');
	    $this->seed('MunicipioSeeder');
	}

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowFicha()
    {
    	$ficha = factory(Ficha::class)->create();

        $response = $this->get('fichas/' . $ficha->cod_ficha);

		$response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowFichaCollaborator()
    {
    	$user = factory(User::class)->states('collaborator')->create();

    	$ficha = factory(Ficha::class)->create();

    	// Log::debug('que hay: ', ['user' => $user, 'ficha' => $ficha]);

        $response = $this->actingAs($user)->get('/user/fichas/' . $ficha->id);

		$response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateFichaCollaborator()
    {
    	$user = factory(User::class)->states('collaborator')->create();

        $response = $this->actingAs($user)->get('/user/fichas/create');

		$response->assertStatus(200);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowFichaAdmin()
    {
    	$user = factory(User::class)->states('admin')->create();

    	$ficha = factory(Ficha::class)->create();

        $response = $this->actingAs($user)->get('/admin/fichas/' . $ficha->id);

		$response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateFichaAdmin()
    {
    	$user = factory(User::class)->states('admin')->create();

        $response = $this->actingAs($user)->get('/admin/fichas/create');

		$response->assertStatus(200);
    }
}
