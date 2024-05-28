<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\RegistrosModel;
class Registros extends Controller{
    public function index(){
        $model = new RegistrosModel();
        $registro = $model->where('estado', 1)->findAll();
        // var_dump($registro); die;
        if(count($registro)==0){
            $respuesta = array(
                "error" => true,
                "mensaje" => "No hay elementos"

            ); 
            $data = json_encode($respuesta);
        }else{
            $data = json_encode($registro);
        }
        return $data;
        
    }

    public function create(){

        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $datos= array(
            "nombres" => $request->getVar("nombres"),
            "apellidos" => $request->getVar("apellidos"),
            "email" => $request->getVar("email")

        );
        if (!empty($datos)) {
            $validation->setRules([
                'nombres' =>'required|string|max_length[255]',
                'apellidos' =>'required|string|max_length[255]',
                'email' =>'required|string|max_length[255]'
            ]);
            $validation->withRequest($this->request)->run();
            if ($validation->getErrors()) {
                $error = $validation->getErrors();
                $data = array(
                    "Status" =>404, "Detalle" => $error);
                return json_encode($data, true);
            }else {
                $cliente_id = crypt($datos["nombres"].$datos["apellidos"].$datos["email"], '$2a$07$dfhdfrexfhgdfhdferttgsad$');
                $llave_secreta = crypt($datos["email"].$datos["apellidos"].$datos["nombres"], '$2a$07$dfhdfrexfhgdfhdferttgsad$');
                $datos = array(
                    "nombres" => $datos["nombres"],
                    "apellidos" => $datos["apellidos"],
                    "email" => $datos["email"],
                    "cliente_id" => str_replace('$','a', $cliente_id),
                    "llave_secreta" => str_replace('$', 'o', $llave_secreta) 
                );

                $model = new RegistrosModel();
                $registro = $model->insert($datos);
                $data = array(

                    "Status" => 200,
                    "Detalle" => "Registro OK, guarde sus credenciales",
                    "credenciales"=> array(
                        "cliente_id"=> str_replace('$', 'a', $cliente_id),
                        "llave_secreta"=>str_replace('$', 'o', $llave_secreta)
                    )
                );
                return json_encode($data, true);
            
            }
        }else {
            $data = array(
                "Status" => 400,
                "Detalle" => "Regristro con errores"
                
            );
            return json_encode($data, true);
        }


    }

}