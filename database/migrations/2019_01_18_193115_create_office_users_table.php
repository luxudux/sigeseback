<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            //Nombre: office_users_office_id_foreign
            $table->foreign('office_id')
                    ->references('id')
                    ->on('offices')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //Nombre: office_users_user_id_foreign
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
        Schema::dropIfExists('office_users');
    }
}
