<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Enlace;
use App\Models\Funcionario;
use App\Models\UserPortal;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApplicationController;

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

    public function solicitarCuentas(Request $request){
        return $cuentas = json_decode($request->input('cuentas'), true);
        return $request;
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

    public function showSistemas(Request $request){
        $aplication = new ApplicationController();
        $ip = $aplication->getClientIP();
        return view('contenido.contenido', compact('ip'));
    }

    public function getMisSistemas(Request $request)
    {
        $user = Auth::user();

        //return $user->token;
        // Cargar el usuario con sus sistemas relacionados
        $usuarioConSistemas = UserPortal::with('misSistemas')->find($user->id);



        // Validación por si no encuentra usuario
        if (!$usuarioConSistemas) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Token del portal del usuario
        $rut = $user->rut;
        $token = $user->token ?? '';

        // Procesamos cada sistema
        $sistemas = $usuarioConSistemas->misSistemas->map(function ($sistema) use ($rut, $token) {
            $urlSistema = $sistema->tx_direccion;

            if ($urlSistema) {
                $urlSistema = str_replace('$rUser', $rut, $urlSistema);
                $urlSistema = str_replace('$tokenPortal', $token, $urlSistema);
                $urlSistema = preg_replace("/\r|\n/", "", $urlSistema); // limpia saltos de línea
            }

            // Agregamos el campo ya listo
            $sistema->url_final = $urlSistema;

            return $sistema;
        });

        // Retornamos los sistemas con URL reemplazada
        return response()->json([
            'mis_sistemas' => $sistemas,
            'rut' => $rut,
            'token' => $token,
        ]);
    }

    // arrreglar esta funcion para agregaer 
    private function changePasswordSistemas($request){
        $url_prev = url()->previous();
        if(strpos($url_prev, 'edit') && $request->password){
            $user_comite = UserComite::where('login',$request->rut)->first();
            $user_hosp = UserHospitalizados::where('rut',$request->rut)->first();
            $user_not = UserNotificacion::where('gl_user',$request->rut)->first();
            $user_pab = UserPabellon::where('gl_rut',$request->rut)->first();
            $user_rce = UserRce::where('rut',$request->rut)->first();
           
            if($user_comite){
                $dataRequest = [
                    'password' => $request->password,
                    'pswd' => $request->password,
                ];
                UserComite::updateOrCreate(['login'=> $request->rut], $dataRequest);
            }
    
            if($user_hosp){
                $dataRequest = [
                    'password' => $request->password,
                ];
                UserHospitalizados::updateOrCreate(['rut'=> $request->rut], $dataRequest);
            }
    
            if($user_not){
                $rut = explode("-", $request->rut);
                $dataRequest = [
                    'gl_pass' => $request->password,
                ];
                UserNotificacion::updateOrCreate(['gl_user'=> $request->rut], $dataRequest);
            }
    
            if($user_pab){
                $dataRequest = [
                    'gl_clave' => $request->password,
                ];
                UserPabellon::updateOrCreate(['gl_rut'=> $request->rut], $dataRequest);
            }
    
            if($user_rce){
                $dataRequest = [
                    'password' => $request->password,
                ];
                UserRce::updateOrCreate(['rut'=> $request->rut], $dataRequest);
            }
            $user_comite = UserComite::where('login',$request->rut)->first();
            $user_hosp = UserHospitalizados::where('rut',$request->rut)->first();
            $user_not = UserNotificacion::where('gl_user',$request->rut)->first();
            $user_pab = UserPabellon::where('gl_rut',$request->rut)->first();
            $user_rce = UserRce::where('rut',$request->rut)->first();
        }
    }

}
