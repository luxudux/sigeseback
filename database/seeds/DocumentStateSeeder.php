<?php

use Illuminate\Database\Seeder;
use App\DocumentState as DocumentState;

class DocumentStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('document_states')->truncate();
        Schema::enableForeignKeyConstraints();

        factory(DocumentState::class, 7)->create();
    }
}
