<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','surname','town_id','phone_p','phone_s',
        'sex', 'mail', 'institution',
        'office_id','user_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function town(){
        return $this->belongsTo('App\Town');
    }

    public function office(){
        return $this->belongsTo('App\Office');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    #Un contacto puede realizar varias llamadas
    public function calls(){
        return $this->hasMany('App\Call');
    }
}
