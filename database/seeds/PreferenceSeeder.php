<?php

use Illuminate\Database\Seeder;


class PreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'preferences';
        Schema::disableForeignKeyConstraints();
        DB::table('preferences')->truncate();
        Schema::enableForeignKeyConstraints();

        //Inserta datos
        DB::table($table)->insert([
            'name' => 'Baja',
            'icon' => 'low_priority',
            'color_icon' => 'grey-text text-lighten-1',
            'color_text' => '',
            'color_back' => ''
        ]);
        DB::table($table)->insert([
            'name' => 'Media',
            'icon' => 'access_time',
            'color_icon' => 'grey-text text-darken-1',
            'color_text' => '',
            'color_back' => ''
        ]);
        DB::table($table)->insert([
            'name' => 'Alta',
            'icon' => 'priority_high',
            'color_icon' => 'red-text text-darken-4',
            'color_text' => '',
            'color_back' => ''
        ]);
    }
}
