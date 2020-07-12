<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewCallsReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW 
        view_calls_received AS 
        SELECT calls.id, 
            calls.note, 
            calls.day, 
            calls.contact_id,
            contacts.name,
            contacts.surname,
            contacts.institution, 
            calls.user_id, 
            users.name AS user_name,
            calls.office_id,
            calls.created_at
        FROM `calls`
        inner join contacts on contacts.id = calls.contact_id
        inner join users on users.id = calls.user_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_calls_received");
    }
}
