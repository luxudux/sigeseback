<?php

use Illuminate\Database\Seeder;


class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'states';
        Schema::disableForeignKeyConstraints();
        DB::table($table)->truncate();
        Schema::enableForeignKeyConstraints();

        //Inserta datos
        DB::table($table)->insert([
            'name' => 'Elaborado',
            'icon' => 'elaborado',
            'color_icon' => 'grey-text text-darken-1'
        ]);
        DB::table($table)->insert([
            'name' => 'Revisión',
            'icon' => 'revision',
            'color_icon' => 'grey-text text-darken-2'
        ]);
        DB::table($table)->insert([
            'name' => 'Aprobado',
            'icon' => 'aprobado',
            'color_icon' => 'green-text text-darken-1'
        ]);
        DB::table($table)->insert([
            'name' => 'Enviado',
            'icon' => 'enviado',
            'color_icon' => 'green-text text-darken-1'
        ]);
        DB::table($table)->insert([
            'name' => 'Recibido',
            'icon' => 'recibido',
            'color_icon' => 'green-text text-darken-1'
        ]);
        DB::table($table)->insert([
            'name' => 'Leído',
            'icon' => 'leido',
            'color_icon' => 'green-text text-darken-1'
        ]);
        DB::table($table)->insert([
            'name' => 'Notificado',
            'icon' => 'notificado',
            'color_icon' => 'green-text text-darken-1'
        ]);
        DB::table($table)->insert([
            'name' => 'Delegado',
            'icon' => 'delegado',
            'color_icon' => 'green-text text-darken-1'
        ]);
        DB::table($table)->insert([
            'name' => 'Finalizado',
            'icon' => 'finalizado',
            'color_icon' => 'green-text text-darken-1'
        ]);
    }
}
