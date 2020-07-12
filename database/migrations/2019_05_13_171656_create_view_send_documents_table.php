<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// VIEW STATE OF DOCUMENTS
class CreateViewSendDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW 
        view_send_documents AS
        SELECT documents.id, 
                documents.subject, 
                documents.control,
                documents.type_id,
                types.name AS type_name, 
                documents.url, 
                documents.expiration, 
                documents.active, 
                documents.office_id, 
                documents.user_id,
                documents.created_at, 
                documents.updated_at,
        (SELECT count(document_id) FROM `document_offices` WHERE document_offices.document_id=documents.id) As sent
        FROM documents
        inner join types on types.id = documents.type_id 
        WHERE (SELECT count(document_id) FROM `document_offices` WHERE document_offices.document_id=documents.id)>0
        AND documents.active = 'S' 
         ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_send_documents");
    }
}
