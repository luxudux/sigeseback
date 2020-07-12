<?php

use Illuminate\Database\Seeder;
use App\DocumentWorker as DocumentWorker;

class DocumentWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('document_workers')->truncate();
        Schema::enableForeignKeyConstraints();

        factory(DocumentWorker::class, 7)->create();
    }
}
