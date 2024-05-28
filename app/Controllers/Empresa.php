<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\EmpresaModel;
use App\Models\RegistrosModel;
class Empresa extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
         
        foreach($registro as $key=>$value){
            if(array_key_exists('Authorization',$headers) && !empty($headers['Authorization'])){
                if($request->getHeader('Authorization')=='Authorization: Basic '.base64_encode($value['cliente_id'].':'.$value['llave_secreta'])){
                    $model = new EmpresaModel();
                    $Empresa = $model->where('em_estado',1)->findAll();
                    if(!empty($Empresa)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($Empresa), 
                            "Detalle"=>$Empresa);
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
                    $model = new EmpresaModel();
                    $Empresa = $model->where('em_estado',1)->find($id);
                    if(!empty($Empresa)){
                        $data = array(  
                            "Status"=>200, "Detalle"=>$Empresa);
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
                            "em_direccion" => $request->getVar("em_direccion"),
                            "em_razonsocial" => $request->getVar("em_razonsocial"),
                            "em_ruc" => $request->getVar("em_ruc"),
                            "em_dueñonombre" => $request->getVar("em_dueñonombre"),
                            "em_dueñoapellido" => $request->getVar("em_dueñoapellido"),
                            "em_telefono" => $request->getVar("em_telefono"),
                            "em_logo" => $request->getFile("em_logo")
                            );
                            $logo = $datos['em_logo'];   
                            if(!empty($datos)){
                            $validation->setRules([
                                "em_direccion" => 'required|string|max_length[255]',
                                "em_razonsocial" => 'required|string|max_length[255]',
                                "em_ruc" => 'required|integer',
                                "em_dueñonombre" => 'required|string|max_length[255]',
                                "em_dueñoapellido" => 'required|string|max_length[255]',
                                "em_telefono" => 'required|string|max_length[255]'
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
                                    "em_direccion" => $datos["em_direccion"],
                                    "em_razonsocial" => $datos["em_razonsocial"],
                                    "em_ruc" => $datos["em_ruc"],
                                    "em_dueñonombre" => $datos["em_dueñonombre"],
                                    "em_dueñoapellido" => $datos["em_dueñoapellido"],
                                    "em_telefono" => $datos["em_telefono"],
                                    "em_logo" => $newName                                
                                );
                                $model = new EmpresaModel();
                                $Empresa = $model->insert($datos);
                                $data = array(
                                    "Status"=>200,
                                    "Detalle"=>"Registro existoso"
                                );
                               
                                //Crear carpeta
                                $nombreCarpeta = array(
                                    1 => "public/".$datos['em_razonsocial'],
                                    2 => "public/".$datos['em_razonsocial'].'/Productos',
                                    3 => "public/".$datos['em_razonsocial'].'/Logo'

                                );
                                foreach( $nombreCarpeta as $carpeta){
                                if (!is_dir($carpeta)) {
                                    
                                    if (mkdir($carpeta)) {
                                        $info = "Carpeta creada correctamente.";
                                    } else {
                                        $info = "Error al crear la carpeta.";
                                    }
                                } else {
                                    $info = "La carpeta ya existe.";
                                }

                                };
                                //aqui
                                //Subir archivo

                                if ($logo->isValid() && !$logo->hasMoved()) {
                                    // Directorio de destino
                                    $uploadPath = './public/'.$datos['em_razonsocial']."/Logo";
                        
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
                                "em_direccion" => 'required|string|max_length[255]',
                                "em_razonsocial" => 'required|string|max_length[255]',
                                "em_ruc" => 'required|integer',
                                "em_dueñonombre" => 'required|string|max_length[255]',
                                "em_dueñoapellido" => 'required|string|max_length[255]',
                                "em_telefono" => 'required|string|max_length[255]',
                                "em_logo" => 'required|string|max_length[255]'                            
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new EmpresaModel();
                                $Empresa = $model->find($id);
                                if(is_null($Empresa)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "em_direccion" => $datos["em_direccion"],
                                        "em_razonsocial" => $datos["em_razonsocial"],
                                        "em_ruc" => $datos["em_ruc"],
                                        "em_dueñonombre" => $datos["em_dueñonombre"],
                                        "em_dueñoapellido" => $datos["em_dueñoapellido"],
                                        "em_telefono" => $datos["em_telefono"],                                
                                        "em_logo" => $datos["em_logo"]
                                    );
                                    $model = new EmpresaModel();
                                    $Empresa = $model->update($id, $datos);
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
                    $model = new EmpresaModel();
                    $Empresa = $model->where('em_estado',1)->find($id);
                    if(!empty($Empresa)){
                        $datos = array("em_estado"=>0);
                        $Empresa = $model->update($id, $datos);
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