<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewDocumentOfficesWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // CHANGE TO view_document_offices_workers
        DB::statement("CREATE VIEW view_document_offices_workers AS
                SELECT document_office_workers.id,
                document_office_workers.document_office_id,
                documents.subject,
                documents.control AS document_control,
                documents.url AS document_url,
                documents.type_id,
                types.name AS type_name,
                documents.expiration AS document_expriation,
                documents.office_id AS d_office_id,
                document_offices.conclution_id,
                conclutions.name AS conclution_name,
                conclutions.icon AS conclution_icon,
                conclutions.color_icon AS conclution_color_icon,
                document_office_workers.worker_id,
                workers.name AS worker_name,
                workers.surname AS worker_surname,
                workers.mail AS worker_mail,
                workers.sex AS worker_sex,
                workers.active AS worker_active,
                document_office_workers.created_at
            FROM document_office_workers
            inner join document_offices on document_offices.id = document_office_workers.document_office_id
            inner join documents on documents.id = document_offices.document_id
            inner join types on types.id = documents.type_id
            inner join workers on workers.id = document_office_workers.worker_id
            inner join conclutions on conclutions.id = document_offices.conclution_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_document_offices_workers");
    }
}
