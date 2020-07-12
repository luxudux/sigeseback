<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Document extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','subject','control','type_id','url','expiration',
        'office_id','user_id','active'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];

    public function type(){
        return $this->belongsTo('App\Type');
    }
    public function office(){
        return $this->belongsTo('App\Office');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    # Pivot Many to Many Un documento puede tener varios encargados de ejecución
    public function workers(){
        return $this->belongsToMany('App\Worker','document_workers');
    }
    # Pivot Many to Many Un documento puede tener varios estados
    public function states(){
        return $this->belongsToMany('App\State','document_states');
    }
    # Pivot ManyToMany Un documento puede tener destinatarios
    public function off_receivers(){
        return $this->belongsToMany('App\Office','document_offices');
    }
}
