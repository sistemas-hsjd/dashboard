<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Freshwork\ChileanBundle\Rut;
use App\Models\Unidad;
use App\Models\GenServicio;
use App\Models\Estamento;
use App\Models\GenSistema;
use App\Models\UserPortal;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    public function getPersona(Request $request){
        if(isset($request->run)){
            if(Rut::parse($request->run)->validate()){
                $rut = Rut::parse($request->run)->format(Rut::FORMAT_WITH_DASH);
                $rut = explode("-", $rut);
                $rut = $rut[0].'-'.$rut[1];

                $user = UserPortal::where('rut', $rut)->first();
                if (!$user) {
                    $datos = json_decode($this->obtenerFonasa($rut), true);
                    $id_sexo = 0; 
                    if($datos[0]['sexo']=='Masculino'){
                        $id_sexo = 1;
                    }else if($datos[0]['sexo']=='Femenino'){
                        $id_sexo = 2;
                    }
            
                    return $data = [
                        "run" => $rut,
                        "nombre_completo" => $datos[0]['nombres'].' '.$datos[0]['paterno'].' '.$datos[0]['materno'],
                        "fc_nacimiento" => $datos[0]['fechaNacimiento'],
                        "sexo" => $id_sexo,
                        "telefono" => $datos[0]['telefono']
                    ];
                }else{
                    return 'usuario registrado';
                }
            }else{
                echo 'rut falso';
            }
        }else{
            echo 'no hay rut';
        }
    }

    public function obtenerFonasa($rut){
        if (Rut::parse($rut)->isValid()){
            $arrayRut = Rut::parse($rut)->toArray();
            $url = 'mantiza='.$arrayRut[0].'&dv='.$arrayRut[1];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://10.4.237.125/fonasa/get_fonasa.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $url,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }else{
            return 'rut invalido';
        }
    }
    
    public function getInfoInicial(Request $request){
        return [
            'servicios' => GenServicio::where('bo_estado', 1)->orderBy('tx_descripcion', 'asc')->get(),
            'estamentos' => Estamento::where('bo_estado', 1)->where('cuenta_usuario', 1)->orderBy('tx_descripcion', 'asc')->get(),
            'sistemas' => GenSistema::where('sistema_local', 1)->orderBy('tx_descripcion', 'asc')->get(),
        ];
    }

}
