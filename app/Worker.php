<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Worker extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','surname','mail','sex','active','office_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];

    public function office(){
        return $this->belongsTo('App\Office');
    }

    # Pivot Many to Many Un documento puede ser ejecutaro por varios trabajadores y viceversa 
    public function documents(){
        return $this->belongsToMany('App\Document','document_workers');
    }
}
