<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewOfficeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        DB::statement("CREATE VIEW view_office_users AS 
                        select office_users.id, 
                                office_users.office_id, 
                                offices.name AS office_name, 
                                offices.acronym, 
                                offices.code, 
                                offices.mail, 
                                office_users.user_id, 
                                users.name AS user_name, 
                                users.active,
                                users.level_id, 
                                levels.name AS level_name
                        from office_users 
                        inner join offices on offices.id = office_users.office_id 
                        inner join users on users.id = office_users.user_id
                        inner join levels on levels.id = users.level_id;       
                        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_office_users");
    }
}
