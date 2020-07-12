<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            //$table->dropForeign('events_preference_id_foreign');
            //$table->dropForeign('events_office_id_foreign');
            //$table->dropForeign('events_user_id_foreign');
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->string('title',50);
            $table->string('description',200);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->unsignedInteger('preference_id');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
            //name: events_preference_id_foreign
            $table->foreign('preference_id')
                    ->references('id')
                    ->on('preferences')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //name: events_office_id_foreign
            $table->foreign('office_id')
                    ->references('id')
                    ->on('offices')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            //name: events_user_id_foreign
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
     
        Schema::dropIfExists('events');
    }
}
