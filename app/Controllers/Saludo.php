<?php
namespace App\Controllers;
use CodeIgniter\Controller;
class Saludo extends Controller
{
    public function index()
    {
        echo "Hola mundo luego de ella";
    }
    public function comentarios(){
        $comentarios="Quiero decir muchas cosas";
        echo json_encode($comentarios);
        // El método json_encode permite transformar las variables
        // en el formato JSON, ideal para web services con RESTful
    }
    public function mensajes($id){
        if(!is_numeric($id)){
            $respuesta = array(
                'error'=>true,
                'mensaje'=>'Debe ser numérico'
            );
            echo json_encode($respuesta);
            return;
        }
        $mensajes = array(
            array('id'=>1,'mensaje'=>'Richi el mejor'),
            array('id'=>2,'mensaje'=>'Ella'),
            array('id'=>3,'mensaje'=>'Tu ex')
        );
        if($id>=count($mensajes) OR $id < 0){
            $respuesta = array(
                'error'=>true,
                'mensaje'=>'El id no existe'
            );
            echo json_encode($respuesta);
            return;
        }
        echo json_encode($mensajes[$id]);
    }
}
