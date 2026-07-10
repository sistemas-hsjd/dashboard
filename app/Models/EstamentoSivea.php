<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstamentoSivea extends Model
{
    use HasFactory;
    protected $connection = 'sivea';
    protected $table = 'not_estamento';
}
