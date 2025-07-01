<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'gen_servicio';
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(UserHospitalizados::class, 'hospitalizacion.hos_usuario_servicio', 'id_servicio', 'id_usuario');
    }

}
