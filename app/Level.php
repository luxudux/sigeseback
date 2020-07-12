<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Level extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 
        'created_at','updated_at'
    ];

    # Un nivel tiene muchos usuarios
    public function users(){
        return $this->hasMany('App\User');
    }
    
}
