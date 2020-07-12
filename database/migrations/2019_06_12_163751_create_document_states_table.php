<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_states', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('document_id');
            $table->unsignedInteger('state_id');
            $table->string('feedback',200)->default('');
            $table->timestamps();
            //Nombre: document_states_document_id_foreign
            $table->foreign('document_id')
                    ->references('id')
                    ->on('documents')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //Nombre: document_states_state_id_foreign
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
        Schema::dropIfExists('document_states');
    }
}
