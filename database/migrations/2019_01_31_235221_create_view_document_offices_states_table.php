<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewDocumentOfficesStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::statement("CREATE VIEW view_document_offices_states AS
                        SELECT document_office_states.id,
                                document_office_states.document_office_id,
                                document_offices.conclution_id,
                                conclutions.name AS conclution_name,
                                conclutions.icon AS conclution_icon,
                                conclutions.color_icon AS conclution_color_icon,
                                documents.office_id AS d_office_id,
                                documents.type_id,
                                types.name AS type_name,
                                document_offices.preference_id,
                                preferences.name AS preference_name,
                                preferences.icon AS preference_icon,
                                preferences.color_icon AS preference_color_icon,
                                document_office_states.state_id,
                                states.name,
                                states.icon,
                                states.color_icon,
                                document_office_states.created_at
                        FROM document_office_states
                        inner join document_offices on document_offices.id = document_office_states.document_office_id
                        inner join conclutions on conclutions.id = document_offices.conclution_id
                        inner join states on states.id = document_office_states.state_id
                        inner join preferences on preferences.id = document_offices.preference_id
                        inner join documents on documents.id = document_offices.document_id
                        inner join types on types.id = documents.type_id;
                        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_document_offices_states");
    }
}
