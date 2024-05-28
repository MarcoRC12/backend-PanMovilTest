<?php
namespace App\Models;
use CodeIgniter\Model;
class UsuariosmovilModel extends Model{
    protected $table='usuariosmovil';
    protected $primaryKey='usumo_id';
    protected $returnType='array';
    protected $allowedFields =[
        'usumo_correo', 'usumo_contrasena', 'usumo_telefono','usumo_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getUsuariosmovil(){
        return $this->db->table('usuariosmovil usumo')
        ->where('usumo.usumo_estado',1)
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('usuariosmovil usumo')
        ->where('usumo.usumo_id', $id)
        ->where('usumo.usumo_estado', 1)
        ->get()->getResultArray();
    }
    /*public function getLogin($usu){
        $usuario = explode('&', $usu);
        if (count($usuario) == 2) {
            $usuarios = $usuario[0];
            $password = $usuario[1];
            return $this->db->table('usuariosmovil usu')
            ->where('usu.usumo_correo', $usuarios)
            ->where('usu.usumo_contrasena', $password) 
            ->where('usu.usumo_estado',1)
            ->get()->getResultArray();
        }
        else if(count($usuario) == 3){
            if ($usuario[2] == "recuperarcontrasena") {
                    $usuarios = $usuario[1];
                    return $this->db->table('usuariosmovil usu')
                    ->where('usu.usumo_correo', $usuarios)
                    ->where('usu.usumo_estado',1)
                    ->get()->getResultArray();
            }
            else{
                return "No hay registro con los datos brindados";
            }
        }
        else {
            return "El usuario no es válido.";
        }
    
    }*/

    public function getLogin($email, $contrasena){
        return $this->db->table('usuariosmovil usu')
        ->where('usu.usumo_Correo', $email)
        ->where('usu.usumo_Contrasena', $contrasena) 
        ->where('usu.usumo_estado',1)
        ->get()->getResultArray();
    }
    
    public function getEmailUsu($email, $telefono) {
        return $this->db->table('usuariosmovil usu')
        ->where('usu.usumo_Correo', $email)
        ->where('usu.usumo_telefono', $telefono) 
        ->where('usu.usumo_estado',1)
        ->get()->getResultArray();
    }
    public function getOlvidecontrasena($email, $telefono) {
        return $this->db->table('usuariosmovil usu')
        ->where('usu.usumo_Correo', $email)
        ->where('usu.usumo_telefono', $telefono) 
        ->where('usu.usumo_estado',1)
        ->get()->getResultArray();
    }
}

