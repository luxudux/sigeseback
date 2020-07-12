<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewDocumentOfficeStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW view_document_office_states AS
                        SELECT document_office_states.id,
                                document_office_states.document_office_id,
                                documents.office_id AS d_office_id,
                                document_office_states.state_id,
                                states.name,
                                states.icon,
                                states.color_icon,
                                document_office_states.created_at
                        FROM document_office_states
                        inner join document_offices on document_offices.id = document_office_states.document_office_id
                        inner join states on states.id = document_office_states.state_id 
                        inner join documents on documents.id = document_offices.document_id;      
                        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_document_office_states");
    }
}
