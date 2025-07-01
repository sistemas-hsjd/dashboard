<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProfesionPabellon extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql3';
    protected $table = 'cb_tipo_profesional';
    public $guarded = [];
}
