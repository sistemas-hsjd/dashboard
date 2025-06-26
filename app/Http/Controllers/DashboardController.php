<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Enlace;
use App\Models\Funcionario;

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

    public function getFuncionarios(Request $request){
        $desarrolladores = Funcionario::with([
            'sistemas'
        ])
        ->whereIn('tipo_id', [1,4,5])
        ->where('estado', 1)
        ->orderBy('nombre')
        ->get();

        $tecnicos = Funcionario::with([
            'sistemas'
        ])
        ->whereIn('tipo_id', [2,3])
        ->where('estado', 1)
        ->orderBy('nombre')
        ->get();

        return [
            'desarrolladores' => $desarrolladores,
            'tecnicos' => $tecnicos
        ];

    }

}
