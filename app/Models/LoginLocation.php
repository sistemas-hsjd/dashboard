<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLocation extends Model
{
    protected $table = 'login_locations';
    public $timestamps = false;
    protected $fillable = ['user_id', 'nombre_completo', 'rut', 'unidades', 'ip_address', 'latitude', 'longitude', 'accuracy_meters', 'location_status', 'logged_in_at'];
    protected $casts = ['unidades' => 'array', 'latitude' => 'float', 'longitude' => 'float', 'accuracy_meters' => 'float', 'logged_in_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(UserPortal::class, 'user_id');
    }
}
