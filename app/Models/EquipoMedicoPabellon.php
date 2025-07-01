<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoMedicoPabellon extends Model
{
    use HasFactory;
    protected $connection = 'mysql3';
    protected $table = 'cb_equipo_medico';
    public $guarded = [];
}
