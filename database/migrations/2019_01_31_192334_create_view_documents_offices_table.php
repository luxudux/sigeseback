<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewDocumentsOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW 
                    view_documents_offices AS 
                    Select document_offices.id, 
                            document_offices.document_id,
                            documents.active,
                            documents.type_id,
                            types.name AS type_name,
                            document_offices.office_id,
                            offices.name AS office_name,
                            offices.acronym AS office_acronym,
                            offices.delegation_id AS office_delegation,
                            offices.code AS office_code,
                            offices.mail AS office_mail,
                            document_offices.conclution_id,
                            conclutions.name AS conclution_name,
                            document_offices.preference_id,
                            preferences.name AS preference_name
                    from document_offices
                    inner join documents on documents.id = document_offices.document_id
                    inner join types on types.id = documents.type_id
                    inner join offices on offices.id = document_offices.office_id
                    inner join conclutions on conclutions.id = document_offices.conclution_id
                    inner join preferences on preferences.id = document_offices.preference_id;       
                        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_documents_offices");
    }
}
