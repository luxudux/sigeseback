<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_offices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('conclution_id');
            $table->unsignedInteger('preference_id');
            $table->timestamps();
            //Nombre: document_offices_document_id_foreign
            $table->foreign('document_id')
                    ->references('id')
                    ->on('documents')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //Nombre: document_offices_office_id_foreign
            $table->foreign('office_id')
                    ->references('id')
                    ->on('offices')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //Nombre: document_offices_conclution_id_foreign
            $table->foreign('conclution_id')
                    ->references('id')
                    ->on('conclutions')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //Nombre: document_offices_preference_id_foreign
            $table->foreign('preference_id')
                    ->references('id')
                    ->on('preferences')
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
        Schema::dropIfExists('document_offices');
    }
}
