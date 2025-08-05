<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Enlace;
use App\Models\Funcionario;
use App\Models\UserPortal;
use App\Models\Unidad;
use App\Models\GenServicio;
use App\Models\GenSistema;
use App\Models\Estamento;
use App\Models\GenPlataformaApoyo;
use Illuminate\Support\Facades\Auth;
use Freshwork\ChileanBundle\Rut;
use App\Http\Controllers\ApplicationController;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Http;
use Mail;

class DashboardController extends Controller
{

    public function abrirMsaccess()
    {
        $ip = $this->getClientIP();
        $url = 'http://'.$this->getClientIP().':5000/open-access';
        $response = Http::get($url);
        return response()->json([
            'status' => $response->status(),
            'mensaje' => $response->body(),
        ]);
    }

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
        
        $data = json_decode($request->input('cuentas'), true);
        // $platsistemasaformasApoyo = GenPlataformaApoyo::with('sistema')->get();
        $sistemasIds = json_decode($request->input('sistemas'), true);
    
        $servicio = GenServicio::with('jefaturas.usuario', 'jefaturas.estamento')->find($request->servicio);
        $estamentoFuncionario = Estamento::find($request->estamento);
        $medico = [1, 6, 32, 36, 39, 40, 45];
        $enfermera = [3, 4, 14, 15, 16, 17, 18, 19, 20, 21];
        $matronas = [5];

        $estamento = (int)$request->estamento;
        if (in_array($estamento, $medico)) {
            $tipo = 'MEDICO';
        } elseif (in_array($estamento, $enfermera)) {
            $tipo = 'ENFERMERA';
        } elseif (in_array($estamento, $matronas)) {
            $tipo = 'MATRONA';
        } else {
            $tipo = 'otro';
        }

        // se envia si hay sistemas de apoyo
        $plataformasApoyo = [];
        foreach ($sistemasIds as $key => $value) {
            $plataforma = $this->getSistemaApoyo($value);
            if($plataforma){
                $plataformasApoyo[] = $plataforma;
            }
        }

        if (count($plataformasApoyo) > 0) {
            foreach ($plataformasApoyo as $value) {
                $pos = array_search($value->sistema->id, $sistemasIds);
                if ($pos !== false) {
                    unset($sistemasIds[$pos]);
                }
            }
            // Reindexar un array
            $sistemasIds = array_values($sistemasIds);
            if($this->sendEmailPlataformaApoyo($data, $plataformasApoyo, $estamentoFuncionario, $servicio, $request)!=='ok'){
                return 'error plataformas';
            }
        }
      
        $sistemas = GenSistema::whereIn('id', $sistemasIds)->get();
        $sistemas = $sistemas->pluck('tx_descripcion')->toArray();

        $jefes = [];
        foreach ($servicio->jefaturas as $key => $value) {
            $estamentoDescripcion = $value->estamento->tx_descripcion;
            $email = $value->usuario->email_recuperacion;
            
           if (str_contains($estamentoDescripcion, strtoupper($tipo))) {
                $jefes[] = $value;
            }
        }
        //return $jefes;
        //49
        //user 44
        $email1 = null;
        $email2 = null;
        if(Auth::user()){
            $user = Auth::user(); 
            if ($user->jefatura()->exists()) {
                $email1 = config('app.EMAIL_CREAR_CUENTA');
                $mensaje = 'Estimado Paolo, Se ha enviado una notificación para la creación de las siguientes cuentas San Juan autorizado por: ' . Auth::user()->nombre;
            }
        }else{
            foreach ($jefes as $jefatura) {
                $email = $jefatura['usuario']['email_recuperacion'] ?? null;

                if ($jefatura['tipo_jefatura_id'] == 1 && $email) {
                    $email1 = $email;
                }

                if ($jefatura['tipo_jefatura_id'] == 2 && $email) {
                    $email2 = $email;
                }
            }
         
            $mensaje = 'Estimado(a), Se ha enviado una notificación para su autorización de cuenta San Juan, para el siguiente funcionario(a)';
        }

        foreach ($data as $key => $value) {
            $data[$key]['nombre_unidad'] = $servicio->tx_descripcion;
            $data[$key]['estamento'] = $estamentoFuncionario->tx_descripcion;
            $data[$key]['sistemas'] = implode(",", $sistemas);
            if($request->estamento == 39 || $request->estamento == 45){
                $data[$key]['RUN_tutor'] = $request->RUN_tutor; 
                $data[$key]['inicio_rotacion'] = $request->inicio_rotacion;
                $data[$key]['fin_rotacion'] = $request->fin_rotacion;
            }
        }

        $template_path = 'email.email_template';
        Mail::send(['html'=> $template_path ],['data' => $data, 'mensaje' => $mensaje], function($message) use($email1, $email2){
            if (!empty($email1) && filter_var($email1, FILTER_VALIDATE_EMAIL)) {
                $message->to($email1, 'User')->subject('Notificación de creacíon San Juan');
            }
            
            if (!empty($email2) && filter_var($email2, FILTER_VALIDATE_EMAIL)) {
                $message->cc($email2);
            }
            $message->from('sistemas.ssmoc@appminsal.cl','Cuenta San Juan');
        });

        return "El correo ha sido enviado";
    }

    public function sendEmailPlataformaApoyo($data, $plataformasApoyo, $estamentoFuncionario, $servicio, $request){

        $email = '';

        foreach ($data as $key => $value) {
            $data[$key]['nombre_unidad'] =  $servicio->tx_descripcion;
            $data[$key]['estamento'] = $estamentoFuncionario->tx_descripcion;

            if ($request->estamento == 39 || $request->estamento == 45) {
                $data[$key]['RUN_tutor'] = $request->RUN_tutor; 
                $data[$key]['inicio_rotacion'] = $request->inicio_rotacion;
                $data[$key]['fin_rotacion'] = $request->fin_rotacion;
            }
        }

        foreach ($plataformasApoyo as $key => $value) {
            $sistema = $value->sistema->tx_descripcion;
            $email = $value->email;
            $mensaje = 'Estimado(a) '.$value->encargado. ' se ha solicitado acceso a la plataforma '.$sistema;

            foreach ($data as $k => $v) {
                $data[$k]['sistema'] = $sistema;
            }

            try {
                $template_path = 'email.email-plataforma';
                Mail::send(['html' => $template_path], ['data' => $data, 'mensaje' => $mensaje], function ($message) use ($email, $sistema) {
                    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $message->to($email, 'User')->subject('Solicitud de acceso a plataforma '.$sistema);
                    }

                    $message->from('sistemas.ssmoc@appminsal.cl', 'Solicitud de acceso a : '.$sistema);
                });
            } catch (\Exception $e) {
                return 'error';
            }
        }

        return 'ok';
    }

    private function getSistemaApoyo($id){
        return $plataformasApoyo = GenPlataformaApoyo::with('sistema')->whereHas('sistema', function($query) use ($id) {
            $query->where('sistema_id', $id);
        })->first();
    }

    private function getSistema($nombre){
        return $plataformasApoyo = GenPlataformaApoyo::whereHas('sistema', function($query) use ($nombre) {
            $query->where('tx_descripcion', $nombre);
        })->first();
    }

    public function getTutor(Request $request){
        if(isset($request->rut)){
            if(Rut::parse($request->rut)->validate()){
                $rut = Rut::parse($request->rut)->format(Rut::FORMAT_WITH_DASH);
                 return UserPortal::with(['tutor'])->where('rut', $rut)->first();
            }
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

    public function showSistemas(Request $request){
        $aplication = new ApplicationController();
        $ip = $aplication->getClientIP();
        return view('contenido.contenido', compact('ip'));
    }

    public function getMisSistemas(Request $request)
    {
        
        $user = Auth::user();
        $usuarioConSistemas = UserPortal::with('misSistemas')->find($user->id);

        if (!$usuarioConSistemas) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $rut = $user->rut;
        $token = $user->token ?? '';

        $sistemas = $usuarioConSistemas->misSistemas->map(function ($sistema) use ($rut, $token) {
            $urlSistema = $sistema->tx_direccion;

            if ($urlSistema) {
                $urlSistema = str_replace('$rUser', $rut, $urlSistema);
                $urlSistema = str_replace('$tokenPortal', $token, $urlSistema);
                $urlSistema = preg_replace("/\r|\n/", "", $urlSistema); // limpia saltos de línea
            }
            $sistema->url_final = $urlSistema;
            return $sistema;
        });
        
        $nuevo = [
            "id" => 10000000,
            "tx_descripcion" => "Registros de UPC adulto",
            "tx_direccion" => "",
            "tx_imagen" => "UPC.jpeg",
            "img" => "UPC.jpeg",
            "nr_orden" => 24,
            "tx_info" => "Access",
            "sistema_local" => 1
        ];

        // Agregar el nuevo sistema a la colección
        $sistemas->push((object) $nuevo);
    
        $defaultSistemas = GenSistema::whereIn('id', [22,24,20,23,19,25])->get()->toArray();
        // $sistemas = array_merge($sistemas->toArray(), $defaultSistemas);

        return response()->json([
            'mis_sistemas' => $sistemas,
            'defaultSistemas' => $defaultSistemas,
            'rut' => $rut,
            'token' => $token,
            'user' => $user
        ]);
    }

    public function getDefault(Request $request){
        return $defaultSistemas = GenSistema::whereIn('id', [22,24,20,21,19,25])
        ->get();
    }

    // arrreglar esta funcion para agregar
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
