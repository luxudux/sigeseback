<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
        //$table->dropForeign('contacts_office_id_foreign');
        //$table->dropForeign('contacts_user_id_foreign');
	    $table->engine = 'InnoDB';
        $table->collation = 'utf8_unicode_ci';
        $table->increments('id');
        $table->string('name',60);
        $table->string('surname',60)->default('');  
        $table->unsignedInteger('town_id');
        $table->string('phone_p',15)->default('0');
        $table->string('phone_s',15)->default('0');
        $table->enum('sex',['H','M']);
        $table->string('mail',30)->default('');
        $table->string('institution',60)->default('');
        $table->unsignedInteger('office_id');
        $table->unsignedInteger('user_id');
        $table->timestamps();
        //nombre: contacts_town_id_foreign
        $table->foreign('town_id')
                ->references('id')
                ->on('towns')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        //nombre: contacts_office_id_foreign
        $table->foreign('office_id')
                ->references('id')
                ->on('offices')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        //nombre: contacts_user_id_foreign
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
        
        Schema::dropIfExists('contacts');
    }
}
