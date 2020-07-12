<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Type extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','code'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 
        'created_at','updated_at'
    ];

    public function documents(){
        return $this->hasMany('App\Document');
        //return $this->hasMany('App\Document','type_id','id');
    }
}
