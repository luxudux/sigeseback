<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Preference extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','icon','color_icon','color_text','color_back'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 
        'created_at','updated_at'
    ];

    # Una prioridad puede tener varios Eventos
    public function events(){
        return $this->hasMany('App\Event');
    }
    # Varios documentos puede tener la misma prioridad
    public function documents(){
        return $this->hasMany('App\DocumentOffice');
    }

    
}
