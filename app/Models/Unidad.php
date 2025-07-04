<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;
    protected $connection = 'generales';
    protected $table = 'gen_unidad';   

    // public function jefatura(){
    //     return $this->belongsToMany(UserPortal::class, 'gen_jefaturas', 'servicio_id', 'user_id');
    // }
}
