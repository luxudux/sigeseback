<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerDocumentOfficesBi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table='document_offices';
        DB::unprepared("CREATE TRIGGER trigger_document_offices_bi 
            BEFORE INSERT ON $table
		 		FOR EACH ROW BEGIN
		 			IF ((SELECT count(*) FROM $table 
                                WHERE document_id=NEW.document_id AND office_id=NEW.office_id)>0)
		 			THEN
                        SIGNAL SQLSTATE '45000' 
		 				SET MESSAGE_TEXT = 'Ya existe';
		 			END IF;
		 		END;    
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER trigger_document_offices_bi');
    }
}
