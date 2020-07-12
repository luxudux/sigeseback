<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            //$table->dropForeign('calls_contact_id_foreign');
            //$table->dropForeign('calls_user_id_foreign');
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->string('note',200);
            $table->dateTime('day');
            $table->unsignedInteger('contact_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('office_id');
            $table->timestamps();
            //nombre: calls_contact_id_foreign
            $table->foreign('contact_id')
                    ->references('id')
                    ->on('contacts')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //nombre: calls_user_id_foreign
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //nombre: calls_office_id_foreign
            $table->foreign('office_id')
                    ->references('id')
                    ->on('offices')
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
        
        Schema::dropIfExists('calls');
    }
}
