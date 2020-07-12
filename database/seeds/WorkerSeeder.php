<?php

use Illuminate\Database\Seeder;
use App\Worker as Worker;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('workers')->truncate();
        Schema::enableForeignKeyConstraints();

        factory(Worker::class, 7)->create();
    }
}
