<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Office extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'acronym','code','mail','delegation_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        // 'password',
    ];

   public function delegation()
   {
       return $this->belongsTo('App\Delegation');
      //return $this->belongsTo('App\Delegation', 'delegation_id', 'id');
   }
   # Una oficina puede tener varios contactos telefónicos
   public function contacts(){
       return $this->hasMany('App\Contact');
   }
   # Una oficina puede tener varias llamadas
   public function calls(){
       return $this->hasMany('App\Call');
   }
   #Una oficina pude tener varios trabajadores
   public function workers(){
       return $this->hasMany('App\Worker');
   }
   # Un centro de trabajo puede tener varios eventos
   public function events(){
       return $this->hasMany('App\Event');
   }
   # Un centro de trabajo puede tener varios documentos (creacion)
   public function documents(){
       return $this->hasMany('App\Document');
   }
   # Pivot ManyToMany Una officina puede ser administrada por varias secretarias
   public function users(){
       return $this->belongsToMany('App\User', 'office_users');
   }
   # Pivot ManyToMany Una oficina enviar varios documentos a destinatarios
   public function doc_receivers(){
       return $this->belongsToMany('App\Document','document_offices');
   }
}
