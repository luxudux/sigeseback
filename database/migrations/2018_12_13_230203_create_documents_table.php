<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            //$table->dropForeign('documents_state_id_foreign');
            //$table->dropForeign('documents_conclution_id_foreign');
            //$table->dropForeign('documents_preference_id_foreign');
            //$table->dropForeign('documents_office_id_foreign');
            //$table->dropForeign('documents_user_id_foreign');
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->string('subject',50);
            $table->string('control',30)->default('');
            // $table->string('url',150)->unique();
            $table->string('url',150);
            $table->unsignedInteger('type_id');
            $table->dateTime('expiration');
            $table->enum('active',['S','N'])->default('S');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            //Nombre: documents_type_id_foreign
            $table->foreign('type_id')
                    ->references('id')
                    ->on('types')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //Nombre: documents_office_id_foreign
            $table->foreign('office_id')
                    ->references('id')
                    ->on('offices')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //Nombre: documents_user_id_foreign
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        
        
        Schema::dropIfExists('documents');
    }
}
