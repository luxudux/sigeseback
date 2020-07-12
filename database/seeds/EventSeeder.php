<?php

use Illuminate\Database\Seeder;
use App\Event as Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('events')->truncate();
        Schema::enableForeignKeyConstraints();

        factory(Event::class, 7)->create();
    }
}
