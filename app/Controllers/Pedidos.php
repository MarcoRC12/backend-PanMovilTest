<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\PedidosModel;
use App\Models\RegistrosModel;
class Pedidos extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
         
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                    $model = new PedidosModel();
                    $pedidos = $model->getPedidos();
                    if(!empty($pedidos)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($pedidos), 
                            "Detalle"=>$pedidos);
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
                    $model = new PedidosModel();
                    $pedidos = $model->getId($id);
                    if(!empty($pedidos)){
                        $data = array(
                            "Status"=>200, "Detalle"=>$pedidos);
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
                            "pe_numero"=>$request->getVar("pe_numero"),
                            "pe_ordenPedido"=>$request->getVar("pe_ordenPedido"),
                            "cl_id"=>$request->getVar("cl_id"),
                            "pro_id"=>$request->getVar("pro_id"),
                            "pe_descripcion"=>$request->getVar("pe_descripcion"),
                            "pe_cantidad"=>$request->getVar("pe_cantidad"),
                            "empresa"=>$request->getVar("empresa"),
                            "pe_fechaEntrega"=>$request->getVar("pe_fechaEntrega")
                        );
                        if(!empty($datos)){
                            $validation->setRules([
                                "pe_numero"=>'required|integer',
                                "pe_ordenPedido"=>'required|integer',
                                "cl_id"=>'required|integer',
                                "pro_id"=>'required|integer',
                                "pe_descripcion"=>'required|string|max_length[255]',                                
                                "pe_cantidad"=>'required|integer',
                                "empresa"=>'required',
                                "pe_fechaEntrega"=>'required|valid_date'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $datos = array(
                                    "pe_numero"=>$datos["pe_numero"],
                                    "pe_ordenPedido"=>$datos["pe_ordenPedido"],
                                    "cl_id"=>$datos["cl_id"],
                                    "pro_id"=>$datos["pro_id"],
                                    "pe_descripcion"=>$datos["pe_descripcion"],
                                    "pe_cantidad"=>$datos["pe_cantidad"],
                                    "empresa"=>$datos["empresa"],
                                    "pe_fechaEntrega"=>$datos["pe_fechaEntrega"]
                                );
                                $model = new PedidosModel();
                                $pedidos = $model->insert($datos);
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
                                "pe_numero"=>'required|integer',
                                "pe_ordenPedido"=>'required|integer',
                                "cl_id"=>'required|integer',
                                "pro_id"=>'required|integer',
                                "pe_descripcion"=>'required|string|max_length[255]',                                
                                "pe_cantidad"=>'required|integer',
                                "empresa"=>'required',
                                "pe_fechaEntrega"=>'required|valid_date'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new PedidosModel();
                                $pedidos = $model->find($id);
                                if(is_null($pedidos)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                    "pe_numero"=>$datos["pe_numero"],
                                    "cl_id"=>$datos["cl_id"],
                                    "pro_id"=>$datos["pro_id"],
                                    "pe_descripcion"=>$datos["pe_descripcion"],
                                    "pe_cantidad"=>$datos["pe_cantidad"],
                                    "empresa"=>$datos["empresa"],
                                    "pe_fechaEntrega"=>$datos["pe_fechaEntrega"]
                                    );
                                    $model = new PedidosModel();
                                    $pedidos = $model->update($id, $datos);
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
                    $model = new PedidosModel();
                    $pedidos = $model->where('pe_estado',1)->find($id);
                    if(!empty($pedidos)){
                        $datos = array("pe_estado"=>0);
                        $pedidos = $model->update($id, $datos);
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