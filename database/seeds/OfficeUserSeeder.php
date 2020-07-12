<?php

use Illuminate\Database\Seeder;
use App\OfficeUser as OfficeUser;

class OfficeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('office_users')->truncate();
        Schema::enableForeignKeyConstraints();

        factory(OfficeUser::class, 7)->create();
    }
}
