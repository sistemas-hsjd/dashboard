<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenServicio extends Model
{
    use HasFactory;
    protected $connection = 'generales';
    protected $table = 'gen_servicio';   

    public function jefaturas()
    {
        return $this->hasMany(GenJefatura::class, 'servicio_id');
    }

}
