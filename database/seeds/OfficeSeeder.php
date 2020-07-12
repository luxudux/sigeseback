<?php

use Illuminate\Database\Seeder;
use App\Office as Office;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('offices')->truncate();
        Schema::enableForeignKeyConstraints();

        factory(Office::class, 7)->create();
        

    }
}
