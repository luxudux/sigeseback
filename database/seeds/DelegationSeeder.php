<?php

use Illuminate\Database\Seeder;


class DelegationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $table = 'delegations';
        Schema::disableForeignKeyConstraints();
        DB::table($table)->truncate();
        Schema::enableForeignKeyConstraints();

        //Inserta datos
        DB::table($table)->insert(['name' => 'DELEGACIÓN 1','acronym' => 'DEL-1']);
        DB::table($table)->insert(['name' => 'DELEGACIÓN 2','acronym' => 'DEL-2']);
        DB::table($table)->insert(['name' => 'DELEGACIÓN 3','acronym' => 'DEL-3']);
        DB::table($table)->insert(['name' => 'DELEGACIÓN 4','acronym' => 'DEL-4']);
        DB::table($table)->insert(['name' => 'DELEGACIÓN 5','acronym' => 'DEL-5']);
    }
}
