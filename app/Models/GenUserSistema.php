<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenUserSistema extends Model
{
    use HasFactory;
    protected $table = 'gen_user_sistemas'; 
    protected $connection = 'generales';
}