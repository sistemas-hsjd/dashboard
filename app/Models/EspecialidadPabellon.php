<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspecialidadPabellon extends Model
{
    use HasFactory;
    protected $connection = 'mysql3';
    protected $table = 'cb_especialidad';
    public $guarded = [];
}
