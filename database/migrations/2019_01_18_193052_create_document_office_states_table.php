<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentOfficeStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_office_states', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('document_office_id');
            $table->unsignedInteger('state_id');
            $table->string('feedback',200)->default('');
            $table->timestamps();
            //Nombre: document_office_states_document_office_id_foreign
            $table->foreign('document_office_id')
                    ->references('id')
                    ->on('document_offices')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //Nombre: document_office_states_state_id_foreign
            $table->foreign('state_id')
                    ->references('id')
                    ->on('states')
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
        Schema::dropIfExists('document_office_states');
    }
}
