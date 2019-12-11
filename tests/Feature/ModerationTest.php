<?php

namespace Tests\Feature;

use App\User;
use App\Ficha;
use App\ModerableRecord;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ModerationTest extends TestCase
{
    use RefreshDatabase;

    protected $rightfulUser;
    protected $unrightfulUser;

    function setUp()
    {
        parent::setUp();

        $this->seed('RolesAndPermissionsTableSeeder');
        $this->seed('IslaSeeder');
        $this->seed('MunicipioSeeder');
        $this->rightfulUser = factory(User::class)->create();
        $this->rightfulUser->givePermissionTo('moderate');
        $this->unrightfulUser = factory(User::class)->create();
    }

    /**
     * An action performed over a morerable object
     * gets recorded on database but is not executed
     *
     * @return void
     */
    public function testActionOnModerableObjectGetsRecordedButNotExecuted()
    {
        $this->actingAs($this->unrightfulUser);

        $moderableModel = factory(Ficha::class)->make();
        $moderableModel->moderate()->save();

        $this->assertDatabaseMissing($moderableModel->getTable(), $moderableModel->toArray());
        $this->assertDatabaseHas('moderable_records', ['id' => 1]);
    }

    /**
     * An action can be applied by a user
     * with the correct permission
     *
     * @return void
     */
    public function testUserWithPermissionCanApplyAction()
    {
        $this->actingAs($this->rightfulUser);

        $moderableModel = factory(Ficha::class)->make();
        $moderableModel->moderate()->save();

        ModerableRecord::first()->apply();

        $this->assertDatabaseHas($moderableModel->getTable(), $moderableModel->toArray());
    }

    /**
     * An action cannot be applied by a user
     * with the incorrect/non-existent permission
     *
     * @return void
     */
    public function testUserWithoutPermissionCannotApplyAction()
    {
        $this->actingAs($this->unrightfulUser);

        $moderableModel = factory(Ficha::class)->make();
        $moderableModel->moderate()->save();

        ModerableRecord::first()->apply();

        $this->assertDatabaseMissing($moderableModel->getTable(), $moderableModel->toArray());
    }

    /**
     * A recorded create action gets applied correctly
     * over the referenced model
     *
     * @return void
     */
    public function testCreateActionGetsAppliedCorrectly()
    {
        $this->actingAs($this->rightfulUser);

        $moderableModel = factory(Ficha::class)->make();
        $moderableModel->moderate()->save();

        $this->assertDatabaseMissing($moderableModel->getTable(), $moderableModel->toArray());

        ModerableRecord::first()->apply();

        $this->assertDatabaseHas($moderableModel->getTable(), $moderableModel->toArray());
    }

    /**
     * A recorded update action gets applied correctly
     * over the referenced model
     *
     * @return void
     */
    public function testUpdateActionGetsAppliedCorrectly()
    {
        $this->actingAs($this->rightfulUser);

        $moderableModel = factory(Ficha::class)->create();

        $this->assertDatabaseHas($moderableModel->getTable(), $moderableModel->toArray());

        $newTime = \Carbon\Carbon::now()->subYear();

        $moderableModel->moderate()->update(['created_at'=> $newTime]);

        ModerableRecord::first()->apply();

        $this->assertDatabaseHas($moderableModel->getTable(), $moderableModel->toArray());
    }

    /**
     * A recorded delete action gets applied correctly
     * over the referenced model
     *
     * @return void
     */
    public function testDeleteActionGetsAppliedCorrectly()
    {
        $this->actingAs($this->rightfulUser);

        $moderableModel = factory(Ficha::class)->create();

        $moderableModel->moderate()->delete();

        $this->assertDatabaseHas($moderableModel->getTable(), $moderableModel->toArray());

        ModerableRecord::first()->apply();

        $this->assertDatabaseMissing($moderableModel->getTable(), $moderableModel->toArray());
    }

    /**
     * A deferred action gets applied on the model after moderation is accepted
     *
     * @return void
     */
    // public function testDeferredActionsGetAppliedCorrectly()
    // {
    //     $this->actingAs($this->rightfulUser);

    //     $user = factory(Ficha::class)->make();
    //     $user->moderate()
    //         ->deferred(['assignRole' => ['supplier']])
    //         ->save();

    //     ModerableRecord::first()->apply();

    //     $this->assertTrue(User::whereUsername($user->username)->first()->hasRole('supplier'));
    // }
}
