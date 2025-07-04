<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenJefatura extends Model
{
    use HasFactory;
    protected $connection = 'generales';
    protected $table = 'gen_jefaturas';   

    public function usuario()
    {
        return $this->belongsTo(UserPortal::class, 'user_id');
    }

    public function estamento()
    {
        return $this->belongsTo(Estamento::class, 'estamento_id');
    }

    public function servicio()
    {
        return $this->belongsTo(GenServicio::class, 'servicio_id');
    }
    
}
