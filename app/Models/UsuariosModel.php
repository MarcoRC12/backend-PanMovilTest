<?php
namespace App\Models;
use CodeIgniter\Model;
class UsuariosModel extends Model{
    protected $table='usuarios';
    protected $primaryKey='us_id';
    protected $returnType='array';
    protected $allowedFields =[
        'es_id', 'us_nombre', 'us_apellido', 'us_correo', 'us_usuario', 'us_password',
        'ro_id', 'us_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getUsuarios(){
        return $this->db->table('usuarios usu')
        ->where('usu.us_estado',1)
        ->join('establecimiento es','es.es_id = usu.es_id')
        ->join('sucursal su','su.su_id = es.su_id')
        ->join('roles rol','rol.ro_id = usu.ro_id')
        ->join('empresa emp','emp.em_id = su.em_id')
        ->get()->getResultArray();
    }
    public function getId($id){
         return $this->db->table('usuarios usu')
        ->where('usu.us_id', $id)
        ->where('usu.us_estado',1)
        ->join('establecimiento es','es.es_id = usu.es_id')
        ->join('sucursal su','su.su_id = es.su_id')
        ->join('roles rol','rol.ro_id = usu.ro_id')
        ->join('permisos perm','perm.ro_id = usu.ro_id')
        ->join('modulos mo','mo.mo_id = perm.mo_id')
        ->join('empresa emp','emp.em_id = su.em_id')
        ->get()->getResultArray();
    }
    public function getLogin($usu){
            $usuario = explode('&', $usu);
            if (count($usuario) == 2) {

            $usuarios = $usuario[0];
            $password = $usuario[1];
            return $this->db->table('usuarios usu')
        ->where('usu.us_usuario', $usuarios)
        ->where('usu.us_password', $password) 
        ->where('usu.us_estado',1)
        ->join('establecimiento es','es.es_id = usu.es_id')
        ->join('sucursal su','su.su_id = es.su_id')
        ->join('roles rol','rol.ro_id = usu.ro_id')
        ->join('permisos perm','perm.ro_id = usu.ro_id')
        ->join('empresa emp','emp.em_id = su.em_id')
        ->get()->getResultArray();
        } else {
            return "El usuario no es válido.";
        }
        
    }
}