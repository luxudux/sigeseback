<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Helpers;
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','password','api_token','active',
        'level_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relations.
     */
    # Un usuario (nivel secretaria) puede registrar varios contactos
    public function contacts(){
        return $this->hasMany('App\Contact');
    }

    public function level(){
        return $this->belongsTo('App\Level');
    }
    # Un usuario (nivel secretaria) puede registrar varias llamadas
    public function calls(){
        return $this->hasMany('App\Call');
    }
    # Un usuario (nivel secretaria) puede registrar varios eventos
    public function events(){
        return $this->hasMany('App\Event');
    }
    # Un usuario (nivel secretaria) puede crear varios documentos
    public function documents(){
        return $this->hasMany('App\Document');
    }
    # Pivot ManyToMany Una secretaria puede administrar varias oficinas
    public function offices(){
        return $this->belongsToMany('App\Office', 'office_users');
    }
    

    /**
     * Validate a user by especifying their roll
     * @param $year, $api_token, $name_level
     * @return bool
     */
    public function validateUser($year,$api_token,$array_name_level){
       
      if($year && $api_token && $array_name_level){
        try{
          // Database Conect
          $user = new User;
          $database = Helpers::name_database($year);
          $user->setConnection($database);
          //Obtenemos el nombre del nivel desde su api-key
          $user_level=$user->where('api_token', $api_token)
                            ->where('active', 'S')->firstOrFail()
                            ->level->name;
          //Validate level name
            if (in_array($user_level, $array_name_level)) {
                return (bool) true;
            }

        //    if ($user_level===$array_name_level) {
        //      return (bool) true;
        //    }
        }catch(\Exception $e){
          return (bool) false;
        }
        return (bool) false;
      }

    }
    //Funcion para validar si corresponde el usuario con el token
    public function validateApikey($year,$user_id,$api_token){
        if($year && $user_id  && $api_token){
            try{
              // Database Conect
              $user = new User;
              $database = Helpers::name_database($year);
              $user->setConnection($database);
              //Validamos si corresponde el id-usuario con x-api-key
              $validate=$user->where('id', $user_id)
                            ->where('api_token', $api_token)->exists();
                            
              if($validate){return (bool) true;}

            }catch(\Exception $e){
              return (bool) false;
            }
            return (bool) false;
          } 
    }

}
