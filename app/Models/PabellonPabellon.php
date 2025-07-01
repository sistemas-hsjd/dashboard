<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PabellonPabellon extends Model
{
    use HasFactory;
    protected $connection = 'mysql3';
    protected $table = 'cb_pabellon';
    public $guarded = [];
}
