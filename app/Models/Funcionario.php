<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    public function sistemas()
    {
        return $this->belongsToMany(Sistema::class, 'funcionarios_sistemas', 'funcionario_id', 'sistema_id');
    }

}
