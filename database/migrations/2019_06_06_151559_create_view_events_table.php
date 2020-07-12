<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW 
        view_events AS 
        SELECT events.id, 
            events.title, 
            events.description, 
            events.start, 
            events.end, 
            events.preference_id, 
            preferences.name AS preference_name,
            events.office_id,
            offices.name AS office_name, 
            events.user_id, 
            users.name AS user_name,
            events.created_at, 
            events.updated_at 
        FROM `events`
        inner join preferences on preferences.id = preference_id
        inner join offices on offices.id = events.office_id
        inner join users on users.id = events.user_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_events");
    }
}
