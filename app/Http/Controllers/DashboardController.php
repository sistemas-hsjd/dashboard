<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Enlace;

class DashboardController extends Controller
{
    public function getInfo(Request $request){
        $ip = $this->getClientIP();
        $categorias = Categoria::with(['enlaces'])->where('estado', 1)->get();
        
        return [
            "categorias" => $categorias,
            "ip" => $ip
        ];
    }

    public function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // En caso de proxies, puede contener múltiples IPs
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

}
