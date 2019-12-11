<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Administrador
        $admin = User::Create([
        	'name' => 'Paco',
        	'surname' => 'Mireles',
        	'email' => 'paco@fedac.org',
        	'username' => 'paco',
        	'password' => Hash::make('secret'),
        ]);

        $admin->assignRole('admin');
        $admin->givePermissionTo('moderate');

        // Colaboradores
        // $colaborador = factory(App\User::class, 6)->states('collaborator')->create();

    }
}
