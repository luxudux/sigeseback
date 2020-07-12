<?php

use Illuminate\Database\Seeder;
use App\Call as Call;

class CallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('calls')->truncate();
        Schema::enableForeignKeyConstraints();

        factory(Call::class, 7)->create();
    }
}
