<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

    	// create permissions

    	// create roles and assign created permissions
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'collaborator']);

        Permission::create(['name' => 'moderate']);
    }
}
