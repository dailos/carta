<?php

use Illuminate\Database\Seeder;

class TruncateAllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
