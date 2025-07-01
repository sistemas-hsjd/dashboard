<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilPabellon extends Model
{
    use HasFactory;
    protected $connection = 'mysql3';
    protected $table = 'cb_perfil';
    public $guarded = [];
}
