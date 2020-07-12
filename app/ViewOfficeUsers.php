<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ViewOfficeUsers as ViewOfficeUsers;
use Helpers;

class ViewOfficeUsers extends Model
{
  //  protected $table = 'view_office_users'; // Overriding default table name
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'id','office_id', 'office_name', 'acronym', 'code', 'mail',
        'user_id', 'user_name', 'active', 'worker_id', 'level_id', 'level_name',
        // 'created_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];
    
}

