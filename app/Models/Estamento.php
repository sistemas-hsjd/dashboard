<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estamento extends Model
{
    use HasFactory;
    protected $connection = 'generales';
    protected $table = 'gen_titulo_profesional';
}
