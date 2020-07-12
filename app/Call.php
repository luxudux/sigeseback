<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','note','day',
        'contact_id','user_id','office_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function contact(){
        return $this->belongsTo('App\Contact');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function office(){
        return $this->belongsTo('App\Office');
    }
}
