<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserComite extends Model
{
    use HasFactory;
    protected $connection = 'mysql4';
    protected $table = 'sec_users';
    public $guarded = [];
    public $timestamps = false;

    public function setPswdAttribute($value){
        $this->attributes['pswd'] = sha1(intval($value));
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt(intval($value));
    }
    
    public function grupo()
    {
		return $this->belongsTo(UserGrupoComite::class, 'login', 'login');
    }
}
