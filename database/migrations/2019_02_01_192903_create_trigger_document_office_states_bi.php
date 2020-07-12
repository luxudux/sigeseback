<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerDocumentOfficeStatesBi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table='document_office_states';
        DB::unprepared("CREATE TRIGGER trigger_document_office_states_bi 
            BEFORE INSERT ON $table
		 		FOR EACH ROW BEGIN
		 			IF ((SELECT count(*) FROM $table WHERE document_office_id=NEW.document_office_id AND state_id=NEW.state_id)>0)
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
        DB::unprepared('DROP TRIGGER trigger_document_office_states_bi');
    }
}
