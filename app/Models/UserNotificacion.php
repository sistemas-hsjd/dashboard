<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificacion extends Model
{
    use HasFactory;
    protected $connection = 'mysql5';
    protected $table = 'cl_usuario';
    public $guarded = [];
    public $timestamps = false;
}
