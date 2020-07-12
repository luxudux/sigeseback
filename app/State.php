<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class State extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','icon','color_icon',
        'created_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 
        'updated_at'
    ];

    # Pivot Many to Many Un estado puede tener varios documentos
    public function documents(){
        return $this->belongsToMany('App\Document', 'document_states');
    }
    
}
