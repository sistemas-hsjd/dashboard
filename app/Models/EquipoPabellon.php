<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoPabellon extends Model
{
    use HasFactory;

    protected $connection = 'mysql3';
    protected $table = 'cb_medico_ncr';
    protected $primaryKey = 'pro_cod';
    public $guarded = [];

    public function TipoProfesion()
    {
        return $this->hasOne(TipoProfesionPabellon::class, 'pro_tipo', 'id');
    }
   
    public function Labores(){
        return $this->belongsToMany(LaborPabellon::class, 'cb_medico_cod_ncr', 'pro_cod', 'tla_cod', 'pro_cod', 'cod_car');
    }
}
