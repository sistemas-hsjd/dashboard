<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenSistema extends Model
{
    use HasFactory;
    protected $table = 'gen_sistemas'; 
    protected $connection = 'generales';
}
