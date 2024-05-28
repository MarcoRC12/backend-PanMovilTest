<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsuariosModel;
use App\Models\RegistrosModel;
class Usuarios extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
         
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                    $model = new UsuariosModel();
                    $usuarios = $model->getUsuarios();
                    if(!empty($usuarios)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($usuarios), 
                            "Detalle"=>$usuarios);
                    }
                    else{
                        $data = array(
                            "Status"=>404,
                            "Total de registros"=>0, 
                            "Detalle"=>"No hay registros");
                    }
                    return json_encode($data, true);
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);        
    }
    public function show($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();      
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                    $model = new UsuariosModel();
                    if(is_numeric($id)){
                        $usuarios = $model->getId($id);
                    }
                    else if(is_string($id)){
                        $usuarios = $model->getLogin($id);
                    }
                    else{
                        $data = array(
                            "Status"=>404, "Detalle"=>"Datos incorrectos");
                        return json_encode($data, true); 
                    }
                    
                    if(!empty($usuarios)){
                        $data = array(
                            "Status"=>200, "Detalle"=>$usuarios);              
     
                         }
                    else{
                        $data = array(
                            "Status"=>404, "Detalle"=>"No hay registros");
                    }
                    return json_encode($data, true);
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
        // var_dump($registro); die; 
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                        $datos = array(
                            "es_id"=>$request->getVar("es_id"),
                            "us_nombre"=>$request->getVar("us_nombre"),
                            "us_apellido"=>$request->getVar("us_apellido"),
                            "us_correo"=>$request->getVar("us_correo"),
                            "us_usuario"=>$request->getVar("us_usuario"),
                            "us_password"=>$request->getVar("us_password"),
                            "ro_id"=>$request->getVar("ro_id")
                        );
                        if(!empty($datos)){
                            $validation->setRules([
                                "es_id"=>'required|integer',
                                "us_nombre"=>'required|string|max_length[255]',
                                "us_apellido"=>'required|string',
                                "us_correo"=>'required|valid_email',
                                "us_usuario"=>'required|string',
                                "us_password"=>'required|string',
                                "ro_id"=>'required|integer',

                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $datos = array(
                                    "es_id"=>$datos["es_id"],
                                    "us_nombre"=>$datos["us_nombre"],
                                    "us_apellido"=>$datos["us_apellido"],
                                    "us_correo"=>$datos["us_correo"],
                                    "us_usuario"=>$datos["us_usuario"],
                                    "us_password"=>$datos["us_password"],
                                    "ro_id"=>$datos["ro_id"]

                                );
                                $model = new UsuariosModel();
                                $usuarios = $model->insert($datos);
                                $data = array(
                                    "Status"=>200,
                                    "Detalle"=>"Registro existoso"
                                );
                                return json_encode($data, true);
                            }
                        }
                        else{
                            $data = array(
                                "Status"=>404,
                                "Detalle"=>"Registro con errores"
                            );
                            return json_encode($data, true);
                        }
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function update($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                        
                        $datos = $this->request->getRawInput();
                        
                        if(!empty($datos)){
                            $validation->setRules([
                                "es_id"=>'required|integer',
                                "us_nombre"=>'required|string|max_length[255]',
                                "us_apellido"=>'required|string',
                                "us_correo"=>'required|valid_email',
                                "us_usuario"=>'required|string',
                                "us_password"=>'required|string',
                                "ro_id"=>'required|integer',
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new UsuariosModel();
                                $usuarios = $model->find($id);
                                if(is_null($usuarios)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "es_id"=>$datos["es_id"],
                                        "us_nombre"=>$datos["us_nombre"],
                                        "us_apellido"=>$datos["us_apellido"],
                                        "us_correo"=>$datos["us_correo"],
                                        "us_usuario"=>$datos["us_usuario"],
                                        "us_password"=>$datos["us_password"],
                                        "ro_id"=>$datos["ro_id"]
                                    );
                                    $model = new UsuariosModel();
                                    $usuarios = $model->update($id, $datos);
                                    $data = array(
                                        "Status"=>200,
                                        "Detalles"=>"Datos actualizados"
                                    );
                                    return json_encode($data, true);
                                }
                            }
                        }
                        else{
                            $data = array(
                                "Status"=>404,
                                "Detalle"=>"Registro con errores"
                            );
                            return json_encode($data, true);
                        }
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    public function delete($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
         
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                    $model = new UsuariosModel();
                    $usuarios = $model->where('us_estado',1)->find($id);
                    if(!empty($usuarios)){
                        $datos = array("us_estado"=>0);
                        $usuarios = $model->update($id, $datos);
                        $data = array(
                            "Status"=>200,
                            "Detalle"=>"Se ha eliminado el registro"
                        );
                    }
                    else{
                        $data = array(
                            "Status"=>404, 
                            "Detalle"=>"No hay registros");
                    }
                    return json_encode($data, true);
                }
                else{
                    $data = array(
                        "Status"=>404,
                        "Detalles"=>"El token es incorrecto"
                    );
                }
            }
            else{
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }
    
}