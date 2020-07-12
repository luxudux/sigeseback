<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            //$table->dropForeign('offices_delegation_id_foreign');
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->string('name',80)->unique();
            $table->string('acronym',12)->default('');
            $table->string('code',10)->unique();
            $table->string('mail',40)->unique();
            $table->unsignedInteger('delegation_id');
            $table->timestamps();
            //nombre: offices_delegation_id_foreign
            $table->foreign('delegation_id')
                   ->references('id')
                   ->on('delegations')
                   ->onUpdate('cascade')
                   ->onDelete('restrict');//no action
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offices');
    }
}
