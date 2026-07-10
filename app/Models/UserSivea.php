<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSivea extends Model
{
    use HasFactory;
    protected $connection = 'sivea';
    protected $table = 'users';
    public $guarded = [];

    public function estamento()
    {
        return $this->belongsTo(EstamentoSivea::class, 'estamento_id'); 
    }

    public function unidades()
    {
        return $this->belongsToMany(NotUnidad::class, 'not_relacion_users_unidad', 'user_id', 'unidad_id')->withPivot('active');
    }

}