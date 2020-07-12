<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DocumentOfficeState extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','document_office_id','state_id','feedback','created_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];

    public function offices(){
        return $this->hasMany('App\DocumentOffice');
        //return $this->hasMany('App\DocumentOffice,'document_office_id','id');
    }
}
