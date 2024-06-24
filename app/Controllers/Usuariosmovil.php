<?php
namespace App\Controllers;
use App\Models\UsuariosmovilModel;
use CodeIgniter\Controller;
use App\Models\RegistrosModel;
class Usuariosmovil extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();

        $model = new UsuariosmovilModel();
                    $usuarios = $model->getUsuariosmovil();
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
    public function show($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();      
            $model = new UsuariosmovilModel();
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
            
    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
        // var_dump($registro); die; 
                        $datos = array(
                            "usumo_correo"=>$request->getVar("usumo_correo"),
                            "usumo_contrasena"=>$request->getVar("usumo_contrasena"),
                            "usumo_telefono"=>$request->getVar("usumo_telefono")
                        );
                        if(!empty($datos)){
                            $validation->setRules([
                                "usumo_correo"=>'required|string|max_length[255]',
                                "usumo_contrasena"=>'required|string|max_length[255]',
                                "usumo_telefono"=>'required|string|max_length[20]'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $datos = array(
                                    "usumo_correo"=>$datos["usumo_correo"],
                                    "usumo_contrasena"=>$datos["usumo_contrasena"],
                                    "usumo_telefono"=>$datos["usumo_telefono"]);
                                $model = new UsuariosmovilModel();
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
    public function update($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();                        
        $datos = $this->request->getRawInput();
        if(!empty($datos)){
            $validation->setRules([
                "usumo_correo"=>'required|string|max_length[255]',
                "usumo_contrasena"=>'required|string|max_length[255]',
            ]);
            $validation->withRequest($this->request)->run();
            if($validation->getErrors()){
                $errors = $validation->getErrors();
                $data = array("Status"=>404, "Detalle"=>$errors);
                return json_encode($data, true);
            }
            else{
                $model = new UsuariosmovilModel();
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
                        "usumo_correo"=>$datos["usumo_correo"],
                        "usumo_contrasena"=>$datos["usumo_contrasena"],
                        "usumo_telefono"=>$datos["usumo_telefono"]
                    );
                    $model = new UsuariosmovilModel();
                    $usuarios = $model->update($id, $datos);
                    $data = array(
                        "Status"=>200,
                        "Detalles"=>"Datos actualizados"
                    );
                    return json_encode($data, true);
                }
            }
        }
    }

    public function delete($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
                    $model = new UsuariosmovilModel();
                    $usuarios = $model->where('usumo_estado',1)->find($id);
                    if(!empty($usuarios)){
                        $datos = array("usumo_estado"=>0);
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
    
    public function buscaremail($email, $telefono){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosmovilModel();
        $usuarios = $model->getEmailUsu($email, $telefono);
        if(!empty($usuarios)){
            $data = array(
                "Status"=>200,
                "Total de registros"=>count($usuarios), 
                "Detalle"=>$usuarios);
        }
        else{
            $data = array(
                "Status"=>404, 
                "Detalle"=>"No hay registros");
        }
        return json_encode($data, true);
    }

    public function login($email, $contrasena){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuariosmovilModel();
        $usuarios = $model->getLogin($email, $contrasena);
        if(!empty($usuarios)){
            $data = array(
                "Status"=>200,
                "Total de registros"=>count($usuarios), 
                "Detalle"=>$usuarios);
        }
        else{
            $data = array(
                "Status"=>404, 
                "Detalle"=>"No hay registros");
        }
        return json_encode($data, true);
    }

    public function actualizarcontrasena($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $model = new UsuariosmovilModel();
        $datos = $this->request->getRawInput();
        $usuario = $model->getId($id);
        $email =  $usuario['0']['usumo_Correo'];
        $telefono =  $usuario['0']["usumo_telefono"];    
        $validation->setRules([
            "usumo_Contrasena"=>'required|string|max_length[255]',
        ]);
        $validation->withRequest($this->request)->run();
        if($validation->getErrors()){
            $errors = $validation->getErrors();
            $data = array("Status"=>404, "Detalle"=>$errors);
            return json_encode($data, true);
        }
        else{
            if(is_null($email)){
                $data = array(
                    "Status"=>404,
                    "Detalles"=>"Registro no existe"
                );
                return json_encode($data, true);
            }
            else{
                $datos = array(
                    "usumo_correo"=>$email,
                    "usumo_contrasena"=>$datos["usumo_Contrasena"],
                    "usumo_telefono"=>$telefono
                );
                $model = new UsuariosmovilModel();
                $model->update($id, $datos);
                $data = array(
                    "Status"=>200,
                    "Detalles"=>"Datos actualizados"
                );
                return json_encode($data, true);
            }
        }
    }
}
