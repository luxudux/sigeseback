<?php

use Illuminate\Database\Seeder;
use App\Document as Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('documents')->truncate();
        Schema::enableForeignKeyConstraints();

        factory(Document::class, 7)->create();
    }
}
