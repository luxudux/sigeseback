<?php

use Illuminate\Database\Seeder;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'towns';
        Schema::disableForeignKeyConstraints();
        DB::table($table)->truncate();
        Schema::enableForeignKeyConstraints();

         //Inserta datos
         DB::table($table)->insert(['name' => 'Sin Especificar','stranger' => 'S']);
         DB::table($table)->insert(['name' => 'Extranjero','stranger' => 'S']);
         DB::table($table)->insert(['name' => 'Aguascalientes','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Baja California','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Baja California Sur','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Campeche','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Chiapas','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Chihuahua','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Colima','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Ciudad de México','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Estado de México','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Guanajuato','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Guerrero','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Hidalgo','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Jalisco','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Michoacán de Ocampo','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Morelos','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Nayarit','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Nuevo León','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Oaxaca','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Puebla','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Querétaro','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Quintana Roo','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'San Luis Potosí','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Sinaloa','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Sonora','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Tabasco','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Tamaulipas','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Tlaxcala','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Veracruz','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Yucatán','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Zacatecas','stranger' => 'N']);
         DB::table($table)->insert(['name' => 'Otro','stranger' => 'N']);

    }
}
