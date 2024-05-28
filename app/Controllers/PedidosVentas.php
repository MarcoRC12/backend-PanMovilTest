<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\PedidosVentasModel;
use App\Models\RegistrosModel;
class PedidosVentas extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
         
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                    $model = new PedidosVentasModel();
                    $pedidosventa = $model->getPedidosVentas();
                    if(!empty($pedidosventa)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($pedidosventa), 
                            "Detalle"=>$pedidosventa);
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
                    $model = new PedidosVentasModel();
                    $pedidosventa = $model->getId($id);
                    if(!empty($pedidosventa)){
                        $data = array(
                            "Status"=>200, "Detalle"=>$pedidosventa);
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
                            "ve_id"=>$request->getVar("ve_id"),
                            "pe_id"=>$request->getVar("pe_id"),
                            "tp_id"=>$request->getVar("tp_id"),
                            "pev_precioUnitario"=>$request->getVar("pev_precioUnitario"),
                            "pev_subtotal"=>$request->getVar("pev_subtotal"),
                            "pev_totalDeuda"=>$request->getVar("pev_totalDeuda"),
                        );
                        if(!empty($datos)){
                            $validation->setRules([
                                "ve_id"=>'required|integer',
                                "pe_id"=>'required|integer',
                                "tp_id"=>'required|string|max_length[255]',
                                "pev_precioUnitario"=>'required|string|max_length[255]',
                                "pev_subtotal"=>'required|string|max_length[255]',
                                "pev_totalDeuda"=>'required|string|max_length[255]'

                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $datos = array(
                                    "ve_id"=>$datos["ve_id"],
                                    "pe_id"=>$datos["pe_id"],
                                    "tp_id"=>$datos["tp_id"],
                                    "pev_precioUnitario"=>$datos["pev_precioUnitario"],
                                    "pev_subtotal"=>$datos["pev_subtotal"],
                                    "pev_totalDeuda"=>$datos["pev_totalDeuda"]
                                );
                                $model = new PedidosVentasModel();
                                $pedidosventa = $model->insert($datos);
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
                                "ve_id"=>'required|integer',
                                "pe_id"=>'required|integer',
                                "tp_id"=>'required|string|max_length[255]',
                                "pev_precioUnitario"=>'required|string|max_length[255]',
                                "pev_subtotal"=>'required|string|max_length[255]',
                                "pev_totalDeuda"=>'required|string|max_length[255]'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new PedidosVentasModel();
                                $pedidosventa = $model->find($id);
                                if(is_null($pedidosventa)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "ve_id"=>$datos["ve_id"],
                                    "pe_id"=>$datos["pe_id"],
                                    "tp_id"=>$datos["tp_id"],
                                    "pev_precioUnitario"=>$datos["pev_precioUnitario"],
                                    "pev_subtotal"=>$datos["pev_subtotal"],
                                    "pev_totalDeuda"=>$datos["pev_totalDeuda"]
                                    );
                                    $model = new PedidosVentasModel();
                                    $pedidosventa = $model->update($id, $datos);
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
                    $model = new PedidosVentasModel();
                    $pedidosventa = $model->where('pev_estado',1)->find($id);
                    if(!empty($pedidosventa)){
                        $datos = array("pev_estado"=>0);
                        $pedidosventa = $model->update($id, $datos);
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