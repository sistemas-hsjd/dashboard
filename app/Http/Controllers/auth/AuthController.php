<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\UserPortal;
use DB;

class AuthController extends Controller
{
    
    public function showLoginForm(){
        return view('auth.login');
        // No hay un usuario autenticado
    }

    public function login(Request $request){
        $this->validateLogin($request);

        if (Auth::guard('generales')->attempt(['rut' => $request->rut,'password' => $request->password])) {
            $user = Auth::guard('generales')->user();
            $token = $user->createToken($user->paterno.'_'.uniqid())->plainTextToken;

            session()->flash('token', $token);
            session()->flash('role_id', $user->role_id);

            $user->token = $token;
            $user->save();

            return redirect()->route('misSistemas')->with('token', $token);
        }
        
        //return $request;
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

}
