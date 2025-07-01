<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRce extends Model
{
    use HasFactory;

    protected $connection = 'registro_clinico';
    protected $table = 'users';
    public $guarded = [];

    public function setPasswordAttribute($value){
        $this->attributes['password'] =  Hash::make($value);
    }
}
