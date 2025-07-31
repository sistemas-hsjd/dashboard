<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenPlataformaApoyo extends Model
{
    use HasFactory;
    protected $connection = 'generales';
    protected $table = 'gen_plataformas_apoyos';

    public function sistema()
    {
        return $this->belongsTo(GenSistema::class, 'sistema_id'); 
    }
    
}
