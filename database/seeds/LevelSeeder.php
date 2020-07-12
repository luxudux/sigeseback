<?php

use Illuminate\Database\Seeder;


class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'levels';
        Schema::disableForeignKeyConstraints();
        DB::table($table)->truncate();
        Schema::enableForeignKeyConstraints();

        //Inserta datos
        DB::table($table)->insert(['name' => 'Manager']);
        DB::table($table)->insert(['name' => 'Secretary']);
        DB::table($table)->insert(['name' => 'Maintenance']);
        DB::table($table)->insert(['name' => 'Adminer']);
    }
}
