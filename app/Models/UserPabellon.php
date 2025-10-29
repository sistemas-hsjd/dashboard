<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPabellon extends Model
{
    use HasFactory;

    protected $connection = 'mysql3';
    protected $table = 'cb_usuario';
    public $guarded = [];

    public function setGlClaveAttribute($value){
        $this->attributes['gl_clave'] = sha1(intval($value));
    }

    protected $appends = ['medico'];

    public function getMedicoAttribute()
    {
        if (!$this->gl_rut) {
            return null;
        }

        $rutPartes = explode("-", $this->gl_rut);
        $rutNumerico = $rutPartes[0] ?? null;

        if (!$rutNumerico) {
            return null;
        }

        return EquipoPabellon::with('labores')->where('pro_rut', $rutNumerico)->first();
    }

    public function Perfiles(){
        return $this->belongsToMany(PerfilPabellon::class, 'cb_labor', 'id_usuario', 'id_perfil');
    }

    public function Bodegas(){
        return $this->belongsToMany(BodegaPabellon::class, 'cb_usuario_bodega', 'id_usuario', 'id_bodega');
    }

    public function Especialidades(){
        return $this->belongsToMany(EspecialidadPabellon::class, 'cb_usuario_especialidad', 'id_usuario', 'id_especialidad');
    }

    public function EquiposMedico(){
        return $this->belongsToMany(EquipoMedicoPabellon::class, 'cb_usuario_equipo', 'id_usuario', 'id_equipo_medico');
    }

    public function Pabellones(){
        return $this->belongsToMany(PabellonPabellon::class, 'cb_usuario_pabellon', 'id_usuario', 'id_pabellon');
    }

}
