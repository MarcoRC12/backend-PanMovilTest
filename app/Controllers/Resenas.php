<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ResenasModel;
use App\Models\RegistrosModel;
class Resenas extends Controller{
    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
         
                    $model = new ResenasModel();
                    $Resenas = $model->getResenas();
                    if(!empty($Resenas)){
                        $data = array(
                            "Status"=>200,
                            "Total de registros"=>count($Resenas), 
                            "Detalle"=>$Resenas);
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
                    $model = new ResenasModel();
                    $Resenas = $model->getId($id);
                    if(!empty($Resenas)){
                        $data = array(  
                            "Status"=>200, "Detalle"=>$Resenas);
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
        // var_dump($registro); die; 
                        $datos = array(
                            "re_estrellas"=>$request->getVar("re_estrellas"),
                            "re_descripcion"=>$request->getVar("re_descripcion"),
                            "pro_id"=>$request->getVar("pro_id"),
                            "usumo_id"=>$request->getVar("usumo_id")
                        );
                        if(!empty($datos)){
                            $validation->setRules([
                                "re_estrellas"=>'required',
                                "re_descripcion"=>'required|string|max_length[255]',
                                "pro_id"=>'required',
                                "usumo_id"=>'required'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $datos = array(
                                    "re_estrellas"=>$datos["re_estrellas"],
                                    "re_descripcion"=>$datos["re_descripcion"],
                                    "pro_id"=>$datos["pro_id"],
                                    "usumo_id"=>$datos["usumo_id"]

                                );
                                $model = new ResenasModel();
                                $Resenas = $model->insert($datos);
                                $last = $model->getInsertID();
                                $data = array(
                                    "Status"=>200,
                                    "Detalle"=>"Registro existoso",
                                    "id"=> strval($last));
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
                                "re_estrellas"=>'required',
                                "re_descripcion"=>'required|string|max_length[255]',
                                "pro_id"=>'required',
                                "usumo_id"=>'required'
                            ]);
                            $validation->withRequest($this->request)->run();
                            if($validation->getErrors()){
                                $errors = $validation->getErrors();
                                $data = array("Status"=>404, "Detalle"=>$errors);
                                return json_encode($data, true);
                            }
                            else{
                                $model = new ResenasModel();
                                $Resenas = $model->find($id);
                                if(is_null($Resenas)){
                                    $data = array(
                                        "Status"=>404,
                                        "Detalles"=>"Registro no existe"
                                    );
                                    return json_encode($data, true);
                                }
                                else{
                                    $datos = array(
                                        "re_estrellas"=>$datos["re_estrellas"],
                                        "re_descripcion"=>$datos["re_descripcion"],
                                        "pro_id"=>$datos["pro_id"],
                                        "usumo_id"=>$datos["usumo_id"]                                    
                                    );
                                    $model = new ResenasModel();
                                    $Resenas = $model->update($id, $datos);
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
    public function delete($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
         
                    $model = new ResenasModel();
                    $Resenas = $model->where('re_estado',1)->find($id);
                    if(!empty($Resenas)){
                        $datos = array("re_estado"=>0);
                        $Resenas = $model->update($id, $datos);
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
            }