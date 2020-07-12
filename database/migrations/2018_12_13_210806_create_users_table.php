<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            //$table->dropForeign('users_level_id_foreign');
            //$table->dropForeign('users_worker_id_foreign');
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->string('name',60);
            $table->string('password',100);
            $table->rememberToken();
            $table->string('api_token',100)->unique();
            $table->enum('active',['S','N'])->default('N');
            $table->unsignedInteger('level_id');
            // $table->unsignedInteger('worker_id');
            $table->timestamps();
            //nombre: users_level_id_foreign
            $table->foreign('level_id')
                    ->references('id')
                    ->on('levels')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //nombre: users_worker_id_foreign
            // $table->foreign('worker_id')
            //         ->references('id')
            //         ->on('workers')
            //         ->onUpdate('cascade')
            //         ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('users');
    }
}
