<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            //$table->dropForeign('workers_office_id_foreign');
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->string('name',60);
            $table->string('surname',60);
            $table->string('mail',40)->unique();
            $table->enum('sex',['H','M']);
            $table->enum('active', ['S','N']);
            $table->unsignedInteger('office_id');
            $table->timestamps();
            //nombre: workers_office_id_foreign
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
       
        Schema::dropIfExists('workers');
    }
}
