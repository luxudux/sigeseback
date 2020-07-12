<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewOfficesDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW 
                        view_offices_documents AS 
                        select document_offices.id,
                                document_offices.document_id,
                                documents.subject,
                                documents.control,
                                documents.url,
                                documents.expiration,
                                documents.office_id AS document_office_id,
                                -- documents.conclution_id,
                                -- conclutions.name AS conclution_name,
                                -- conclutions.icon AS conclution_icon,
                                -- conclutions.color_icon AS conclution_color_icon,
                                -- documents.preference_id,
                                -- preferences.name AS preference_name,
                                -- preferences.icon AS preference_icon,
                                -- preferences.color_icon AS preference_color_icon,
                                -- preferences.color_text AS preference_color_text,
                                -- preferences.color_back AS preference_color_back,
                                document_offices.office_id,
                                offices.name AS office_name,
                                offices.acronym AS office_acronym,
                                offices.delegation_id AS office_delegation,
                                offices.code AS office_code,
                                offices.mail AS office_mail
                        from document_offices
                        inner join documents on documents.id = document_offices.document_id
                        inner join offices on offices.id = document_offices.office_id;
                        -- inner join conclutions on conclutions.id = documents.conclution_id
                        -- inner join preferences on preferences.id = documents.preference_id;       
                        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_offices_documents");
    }
}
