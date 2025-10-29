<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\UserPortal;
use App\Models\UserComite;
use App\Models\UserPabellon;
use App\Models\UserNotificacion;
use App\Models\UserHospitalizados;
use App\Models\UserRce;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use Mail;

class AuthController extends Controller
{
    
    public function showLoginForm(){
        return view('auth.login');
        // No hay un usuario autenticado
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (Auth::guard('generales')->attempt(['rut' => $request->rut, 'password' => $request->password])) {
            $user = Auth::guard('generales')->user();

            // Generar token manualmente con expiración
            $plainTextToken = Str::random(64);

            $user->tokens()->create([
                'name' => $user->paterno . '_' . uniqid(),
                'token' => hash('sha256', $plainTextToken),
                'abilities' => ['*'],
                'expires_at' => Carbon::now()->addDays(7), // Token expira en 7 días
            ]);

            session()->flash('token', $plainTextToken);
            session()->flash('role_id', $user->role_id);

            $user->token = $plainTextToken; // Esto puede no ser seguro: evita guardar token plano en BD si no es necesario
            $user->save();

            if($user->update_password==0){
                //return 'cambiar contraseña';
                return redirect()->route('cambiarContrasena')->with('token', $plainTextToken);
            }else{
                return redirect()->route('misSistemas')->with('token', $plainTextToken);
            }
        }

        return back()
            ->withErrors(['rut' => trans('auth.failed')])
            ->withInput($request->only('rut'));
    }
    protected function validateLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rut' => 'required',
            'password' => 'required|string',
        ]);
    }

    public function store(Request $request)
    {
        $usuario = new User();
        $usuario->email = 'nserranoherrera@gmail.com';
        $usuario->name = 'Nelson';
        $usuario->rut = '15500246-8';
        $usuario->bo_estado = 1;
        $usuario->id_estamento = 4;
        $usuario->password = Hash::make('1550'); 
        $usuario->save();
        return 'ok';
    }
    
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    public function changePasswordSistemas(Request $request){
        if($request->rut && $request->password){

            $userPortal = UserPortal::where('rut', $request->rut)->first();
            $user_comite = UserComite::where('login', $request->rut)->first();
            $user_hosp = UserHospitalizados::where('rut', $request->rut)->first();
            $user_not = UserNotificacion::where('gl_user', $request->rut)->first();
            $user_pab = UserPabellon::where('gl_rut', $request->rut)->first();
            $user_rce = UserRce::where('rut', $request->rut)->first();
           
            if($userPortal){
                $dataRequest = [
                    'password' => $request->password,
                    'update_password' => 1 
                ];
                UserPortal::updateOrCreate(['rut'=> $request->rut], $dataRequest);
            }

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

           return response()->json([
                'redirect' => route('misSistemas')
            ]);
        }else{
            return 'cambio no realizado'; 
        }
        
    }

    public function recuperarContrasena(Request $request){
        $email = $request->email;
        $codigo = Str::random(10);

        $userPortal = UserPortal::where('email_recuperacion', $email)->first();

        if($userPortal){
            $dataRequest = [
                'password' => $codigo,
                'update_password' => 0,
                'codigo' => $codigo
            ];
            UserPortal::updateOrCreate(['rut'=> $userPortal->rut], $dataRequest);
        }

        $template_path = 'email.email_recuperar_contrasena';
        Mail::send(['html'=> $template_path ],['data' => $dataRequest], function($message) use($email){
            if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message->to($email, 'User')->subject('Reestablecer contraseña San Juan');
            }
            
            $message->from('sistemas.ssmoc@appminsal.cl','Cuenta San Juan');
        });
        return response()->json([
            'redirect' => route('login')
        ]);
    }
}
