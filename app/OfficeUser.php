<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OfficeUser as OfficeUser;
use Helpers;

class OfficeUser extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','office_id','user_id','created_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];
    //Compruebe si tiene permiso de oficina
    public function validateOffice($year,$user_id, $office_id){
       
        if($year && $user_id && $office_id){
          try{
            // Database Conect
            $office_user = new OfficeUser;
            $database = Helpers::name_database($year);
            $office_user->setConnection($database);
            //Obtenemos el array de oficinas a partir del id del usuario
            $validate=$office_user->where('user_id', $user_id)
                                        ->where('office_id', $office_id)
                                        ->first();
              if($validate){return (bool) true;}
  
          }catch(\Exception $e){
            return (bool) false;
          }
         
        }
        return (bool) false;
      }
    //Obtener todas las las oficinas que tiene acceso un usuario en concreto
    //@return array
    Public function getOffice($year,$user_id){
      if($year && $user_id){
        try{
          // Database Conect
          $office_user = new OfficeUser;
          $database = Helpers::name_database($year);
          $office_user->setConnection($database);
          //Obtenemos el array de oficinas a partir del id del usuario
          $results=$office_user->where('user_id', $user_id)
                                ->get(['office_id']);
          if($results){
            //Formar el array
            foreach($results as $result) {
            $offices[]=$result['office_id'];
            }
          return $offices;
          }

        }catch(\Exception $e){
          return (bool) false;
        }
       
      }
      return (bool) false;
    }
}

