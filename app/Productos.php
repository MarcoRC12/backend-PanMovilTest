<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ProductosModel;
use App\Models\RegistrosModel;
class Productos extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
         
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                    $model = new ProductosModel();
                    $producto = $model->getProductos();
                    if(!empty($producto)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($producto), 
                            "Detalle"=>$producto);
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
                    $model = new ProductosModel();
                    $producto = $model->getId($id);
                    if(!empty($producto)){
                        $data = array(
                            "Status"=>200, "Detalle"=>$producto);
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
                            "pro_nombre"=>$request->getVar("pro_nombre"),
                            "pro_descripcion"=>$request->getVar("pro_descripcion"),
                            "tpro_id"=>$request->getVar("tpro_id"),
                            "pro_PrecioUnitario"=>$request->getVar("pro_PrecioUnitario"),
                            "pro_marca"=>$request->getVar("pro_marca"),
                            "pro_imagen"=>$request->getFile("pro_imagen"),
                            "empresa"=>$request->getvar("empresa")
                        );
                        $logo = $datos['pro_imagen']; 
                        $empresa2 = intval($datos['empresa']); 
                        if(!empty($datos)){
                            $validation->setRules([
                                "pro_nombre"=>'required|string|max_length[255]',
                                "pro_descripcion"=>'required|string|max_length[255]',
                                "tpro_id"=>'required|integer',
                                "pro_PrecioUnitario"=>'required|string|max_length[255]',
                                "pro_marca"=>'required|string|max_length[255]'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $newName = $logo->getRandomName();
                                $datos = array(
                                    "pro_nombre"=>$datos["pro_nombre"],
                                    "pro_descripcion"=>$datos["pro_descripcion"],
                                    "tpro_id"=>$datos["tpro_id"],
                                    "pro_PrecioUnitario"=>$datos["pro_PrecioUnitario"],
                                    "pro_marca"=>$datos["pro_marca"],
                                    "pro_imagen"=>$newName
                                );
                                $model = new ProductosModel();
                                $producto = $model->insert($datos);
                                $data = array(
                                    "Status"=>200,
                                    "Detalle"=>"Registro existoso"
                                );
                                //Subir archivo
                                
                                $model2 = new ProductosModel;
                                $empresa = $model2->getEmpresa($empresa2);                                

                                if($logo->isValid() && !$logo->hasMoved()) {
                                    // Directorio de destino
                                    $uploadPath = './public/'.$empresa[0]['em_razonsocial']."/Productos";
                        
                                    // Generar un nombre de archivo único
                        
                                    // Mover el archivo al directorio de destino
                                    $logo->move($uploadPath, $newName);
                        
                                    // Enviar una respuesta JSON con la ubicación del archivo
                                    $response = [
                                        'status' => 'success',
                                        'message' => 'Archivo subido correctamente',
                                        'logo$logo_path' => base_url($uploadPath."/".$newName)
                                    ];
                        
                                    $up = $this->response->setJSON($response);
                                } else {
                                    // Si hay un error en la carga del archivo
                                    $response = [
                                        'status' => 'error',
                                        'message' => $logo->getErrorString()
                                    ];
                                  $up =  $this->response->setJSON($response);
                                }
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
                                "pro_nombre"=>'required|string|max_length[255]',
                                "pro_descripcion"=>'required|string|max_length[255]',
                                "tpro_id"=>'required|integer',
                                "pro_PrecioUnitario"=>'required|string|max_length[255]',
                                "pro_marca"=>'required|string|max_length[255]',
                                "pro_imagen"=>'required|string|max_length[255]'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new ProductosModel();
                                $producto = $model->find($id);
                                if(is_null($producto)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "pro_nombre"=>$datos["pro_nombre"],
                                        "pro_descripcion"=>$datos["pro_descripcion"],
                                        "tpro_id"=>$datos["tpro_id"],
                                        "pro_PrecioUnitario"=>$datos["pro_PrecioUnitario"],
                                        "pro_marca"=>$datos["pro_marca"],
                                        "pro_imagen"=>$datos["pro_imagen"]
                                    );
                                    $model = new ProductosModel();
                                    $producto = $model->update($id, $datos);
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
                    $model = new ProductosModel();
                    $producto = $model->where('pro_estado',1)->find($id);
                    if(!empty($producto)){
                        $datos = array("pro_estado"=>0);
                        $producto = $model->update($id, $datos);
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