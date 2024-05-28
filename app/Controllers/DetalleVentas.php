<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\DetalleVentasModel;
use App\Models\RegistrosModel;
class DetalleVentas extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
         
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                    $model = new DetalleVentasModel();
                    $detalleventa = $model->getDetalleVentas();
                    if(!empty($detalleventa)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($detalleventa), 
                            "Detalle"=>$detalleventa);
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
                    $model = new DetalleVentasModel();
                    $detalleventa = $model->getId($id);
                    if(!empty($detalleventa)){
                        $data = array(
                            "Status"=>200, "Detalle"=>$detalleventa);
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
                            "dv_numero"=>$request->getVar("ve_id"),
                            "dv_ordenVenta"=>$request->getVar("ve_id"),
                            "ve_id"=>$request->getVar("ve_id"),
                            "pro_id"=>$request->getVar("pro_id"),
                            "tp_id"=>$request->getVar("tp_id"),
                            "dv_cantidad"=>$request->getVar("dv_cantidad"),
                            "dv_subtotal"=>$request->getVar("dv_subtotal"),
                            "empresa"=>$request->getVar("empresa")
                        );
                        if(!empty($datos)){
                            $validation->setRules([
                                "dv_numero"=>'required|integer',
                                "dv_ordenVenta"=>'required|integer',
                                "ve_id"=>'required|integer',
                                "pro_id"=>'required|integer',
                                "tp_id"=>'required|integer',
                                "dv_cantidad"=>'required|string|max_length[255]',
                                "dv_subtotal"=>'required|string|max_length[255]',
                                "empresa"=>'required'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $datos = array(
                                    "dv_numero"=>$datos["dv_numero"],
                                    "dv_ordenVenta"=>$datos["dv_ordenVenta"],
                                    "ve_id"=>$datos["ve_id"],
                                    "pro_id"=>$datos["pro_id"],
                                    "tp_id"=>$datos["tp_id"],
                                    "dv_cantidad"=>$datos["dv_cantidad"],
                                    "dv_subtotal"=>$datos["dv_subtotal"],
                                    "empresa"=>$datos["empresa"]
                                );
                                $model = new DetalleVentasModel();
                                $detalleventa = $model->insert($datos);
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
                                "dv_numero"=>'required|integer',
                                "dv_ordenVenta"=>'required|integer',
                                "ve_id"=>'required|integer',
                                "pro_id"=>'required|integer',
                                "tp_id"=>'required|integer',
                                "dv_cantidad"=>'required|string|max_length[255]',
                                "dv_subtotal"=>'required|string|max_length[255]',
                                "empresa"=>'required'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new DetalleVentasModel();
                                $detalleventa = $model->find($id);
                                if(is_null($detalleventa)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "dv_numero"=>$datos["dv_numero"],
                                        "dv_ordenVenta"=>$datos["dv_ordenVenta"],
                                        "ve_id"=>$datos["ve_id"],
                                        "pro_id"=>$datos["pro_id"],
                                        "tp_id"=>$datos["tp_id"],
                                        "dv_cantidad"=>$datos["dv_cantidad"],
                                        "dv_subtotal"=>$datos["dv_subtotal"],
                                        "empresa"=>$datos["empresa"]
                                    );
                                    $model = new DetalleVentasModel();
                                    $detalleventa = $model->update($id, $datos);
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
                    $model = new DetalleVentasModel();
                    $detalleventa = $model->where('dv_estado',1)->find($id);
                    if(!empty($detalleventa)){
                        $datos = array("dv_estado"=>0);
                        $detalleventa = $model->update($id, $datos);
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