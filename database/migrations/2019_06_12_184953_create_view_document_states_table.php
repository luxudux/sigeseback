<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewDocumentStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        DB::statement("CREATE VIEW view_document_states AS
                        SELECT  document_states.id,
                                document_states.document_id,
                                documents.office_id AS remitente_id,
                                documents.type_id,
                                types.name AS type_name,
                                offices.name AS remitente_name,
                                document_states.state_id,
                                states.name AS state_name,
                                states.icon,
                                states.color_icon,
                                document_states.created_at
                        FROM document_states
                        inner join states on states.id = document_states.state_id 
                        inner join documents on documents.id = document_states.document_id
                        inner join types on types.id = documents.type_id
                        inner join offices on offices.id = documents.office_id;      
                        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_document_states");
    }
}
