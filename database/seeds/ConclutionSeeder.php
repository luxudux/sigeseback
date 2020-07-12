<?php

use Illuminate\Database\Seeder;


class ConclutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('conclutions')->truncate();
        Schema::enableForeignKeyConstraints();

        //Inserta datos
        DB::table('conclutions')->insert([
            'name' => 'Pendiente',
            'icon' => 'warning',
            'color_icon' => 'grey-text text-lighten-1'
        ]);
        DB::table('conclutions')->insert([
            'name' => 'Terminado',
            'icon' => 'done',
            'color_icon' => 'green-text text-darken-1'
        ]);
    }
}
