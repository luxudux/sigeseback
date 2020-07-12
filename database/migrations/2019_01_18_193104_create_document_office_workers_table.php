<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentOfficeWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_office_workers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('document_office_id');
            $table->unsignedInteger('worker_id');
            $table->timestamps();
            //Nombre: document_workers_document_office_id_foreign
            $table->foreign('document_office_id')
                    ->references('id')
                    ->on('document_offices')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //Nombre: document_workers_worker_id_foreign
            $table->foreign('worker_id')
                    ->references('id')
                    ->on('workers')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_office_workers');
    }
}
