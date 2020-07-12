<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerOfficeUsersBi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table='office_users';
        DB::unprepared("CREATE TRIGGER trigger_office_users_bi 
            BEFORE INSERT ON $table
		 		FOR EACH ROW BEGIN
		 			IF ((SELECT count(*) FROM $table WHERE office_id=NEW.office_id AND user_id=NEW.user_id)>0)
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
        DB::unprepared('DROP TRIGGER trigger_office_users_bi');
    }
}
