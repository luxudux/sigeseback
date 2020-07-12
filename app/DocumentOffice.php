<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DocumentOffice extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','document_id','conclution_id','preference_id','office_id','created_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];

     public function conclution(){
        return $this->belongsTo('App\Conclution');
    }
    
    public function preference(){
        return $this->belongsTo('App\Preference');
    }
}
