<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ProveedoresModel;
use App\Models\RegistrosModel;
class Proveedores extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
         
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                    $model = new ProveedoresModel();
                    $proveedor = $model->where('pv_estado',1)->findAll();
                    if(!empty($proveedor)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($proveedor), 
                            "Detalle"=>$proveedor);
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
                    $model = new ProveedoresModel();
                    $proveedor = $model->where('pv_estado',1)->find($id);
                    if(!empty($proveedor)){
                        $data = array(
                            "Status"=>200, "Detalle"=>$proveedor);
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
                            "pv_RazonSocial"=>$request->getVar("pv_RazonSocial"),
                            "pv_ruc"=>$request->getVar("pv_ruc"),
                            "pv_NombreEncargado"=>$request->getVar("pv_NombreEncargado"),
                            "pv_ApellidoEncargado"=>$request->getVar("pv_ApellidoEncargado"),
                            "pv_telefono"=>$request->getVar("pv_telefono"),
                            "pv_direccion"=>$request->getVar("pv_direccion"),
                            "empresa"=>$request->getVar("empresa")
                        );
                        if(!empty($datos)){
                            $validation->setRules([
                                "pv_RazonSocial"=>'required|string|max_length[255]',
                                "pv_ruc"=>'required|string|max_length[255]',
                                "pv_NombreEncargado"=>'required|string|max_length[255]',
                                "pv_ApellidoEncargado"=>'required|string|max_length[255]',
                                "pv_telefono"=>'required|string|max_length[255]',
                                "pv_direccion"=>'required|string|max_length[255]',
                                "empresa"=>'required|integer'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $datos = array(
                                    "pv_RazonSocial"=>$datos["pv_RazonSocial"],
                                    "pv_ruc"=>$datos["pv_ruc"],
                                    "pv_NombreEncargado"=>$datos["pv_NombreEncargado"],
                                    "pv_ApellidoEncargado"=>$datos["pv_ApellidoEncargado"],
                                    "pv_telefono"=>$datos["pv_telefono"],
                                    "pv_direccion"=>$datos["pv_direccion"],
                                    "empresa"=>$datos["empresa"]
                                );
                                $model = new ProveedoresModel();
                                $proveedor = $model->insert($datos);
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
                                "pv_RazonSocial"=>'required|string|max_length[255]',
                                "pv_ruc"=>'required|string|max_length[255]',
                                "pv_NombreEncargado"=>'required|string|max_length[255]',
                                "pv_ApellidoEncargado"=>'required|string|max_length[255]',
                                "pv_telefono"=>'required|string|max_length[255]',
                                "pv_direccion"=>'required|string|max_length[255]',
                                "empresa"=>'required|integer'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new ProveedoresModel();
                                $proveedor = $model->find($id);
                                if(is_null($proveedor)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "pv_RazonSocial"=>$datos["pv_RazonSocial"],
                                        "pv_ruc"=>$datos["pv_ruc"],
                                        "pv_NombreEncargado"=>$datos["pv_NombreEncargado"],
                                        "pv_ApellidoEncargado"=>$datos["pv_ApellidoEncargado"],
                                        "pv_telefono"=>$datos["pv_telefono"],
                                        "pv_direccion"=>$datos["pv_direccion"],
                                        "empresa"=>$datos["empresa"]
                                    );
                                    $model = new ProveedoresModel();
                                    $proveedor = $model->update($id, $datos);
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
                    $model = new ProveedoresModel();
                    $proveedor = $model->where('pv_estado',1)->find($id);
                    if(!empty($proveedor)){
                        $datos = array("pv_estado"=>0);
                        $proveedor = $model->update($id, $datos);
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