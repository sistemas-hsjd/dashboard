<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserPortal extends Authenticatable
{
    use HasApiTokens, SoftDeletes;
    protected $table = 'users'; 
    protected $connection = 'generales';
    protected $fillable = [
        'id',           
        'rut',                     
        'nombre',                  
        'password_old',            
        'ultimo_acceso',  
        'token',          
        'remember_token',          
        'id_perfil',              
        'password',              
        'created_at',             
        'created_by',              
        'updated_at',              
        'deleted_at',      
        'email_recuperacion',  
        'fecha_asignacion_email',  
        'token_recuperacion',  
        'id_identificacion',   
        'fecha_inicio_vigencia',  
        'fecha_termino_vigencia',  
        'id_tutor'
    ];

    protected $hidden = ['password'];
    protected $dates = ['deleted_at'];

    public function misSistemas(){
        return $this->belongsToMany(GenSistema::class, 'gen_user_sistemas', 'id_user', 'id_sistema')
        ->where('sistema_local', 1)
        ->where('estado', 1)
        ->withPivot('favorito');
    }

    public function jefatura(){
        return $this->belongsToMany(GenServicio::class, 'gen_jefaturas', 'user_id', 'servicio_id');
    }

    public function tutor(){
        return $this->hasOne(UserPortal::class, 'id', 'id_tutor');
    }
}

