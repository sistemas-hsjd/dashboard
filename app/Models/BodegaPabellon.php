<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodegaPabellon extends Model
{
    use HasFactory;
    protected $connection = 'mysql3';
    protected $table = 'cb_bodega';
    public $guarded = [];
}
