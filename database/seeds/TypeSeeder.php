<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'types';
        Schema::disableForeignKeyConstraints();
        DB::table($table)->truncate();
        Schema::enableForeignKeyConstraints();

        //Inserta datos
        DB::table($table)->insert(['name' => 'Informativo','code' => 'INFO']);
        DB::table($table)->insert(['name' => 'Solicitud','code' => 'SOL']);
        DB::table($table)->insert(['name' => 'Circular','code' => 'CIR']);
        DB::table($table)->insert(['name' => 'Memorandum','code' => 'MEM']);
        DB::table($table)->insert(['name' => 'Extrañamiento','code' => 'EXTR']);
        DB::table($table)->insert(['name' => 'Nombramiento','code' => 'NMBR']);
        DB::table($table)->insert(['name' => 'Respuesta','code' => 'RSPTA']);
    }
}
