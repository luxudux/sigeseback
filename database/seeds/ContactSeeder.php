<?php

use Illuminate\Database\Seeder;
use App\Contact as Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('contacts')->truncate();
        Schema::enableForeignKeyConstraints();

        factory(Contact::class, 7)->create();
    }
}
