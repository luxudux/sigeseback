<?php

use Illuminate\Database\Seeder;
use App\DocumentOffice as DocumentOffice;

class DocumentOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('document_offices')->truncate();
        Schema::enableForeignKeyConstraints();

        factory(DocumentOffice::class, 7)->create();
    }
}
