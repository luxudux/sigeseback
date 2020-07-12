<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','title','description','start','end','preference_id',
        'office_id','user_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];

    public function preference(){
        return $this->belongsTo('App\Preference');
    }

    public function office(){
        return $this->belongsTo('App\Office');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
