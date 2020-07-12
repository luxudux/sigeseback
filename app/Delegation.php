<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Delegation extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','acronym'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 
        'created_at','updated_at'
    ];

    public function offices(){
        return $this->hasMany('App\Office');
        //return $this->hasMany('App\Office','delegation_id','id');
    }
}
