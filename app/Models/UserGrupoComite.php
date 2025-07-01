<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGrupoComite extends Model
{
    use HasFactory;
    protected $connection = 'mysql4';
    protected $table = 'sec_users_groups';
    protected $guarded = [];
    public $timestamps = false;
}
