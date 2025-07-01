<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHospitalizados extends Model
{
    use HasFactory;

    // protected $connection = 'mysql3';
    protected $table = 'hospitalizacion.users';
    public $guarded = [];

    public function setNombreAttribute($value){
        $this->attributes['nombre'] = ucfirst($value);
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt(intval($value));
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'hospitalizacion.hos_usuario_servicio', 'id_usuario', 'id_servicio');
    }

    public function especialidades_medicas()
    {
        return $this->belongsToMany(Unidad::class, 'hospitalizacion.hos_usuario_especialidad_medica', 'id_usuario', 'id_especialidad_medica');
    }
}
