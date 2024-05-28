<?php
namespace App\Models;
use CodeIgniter\Model;
class PermisosModel extends Model{
    protected $table='permisos';
    protected $primaryKey='perm_id';
    protected $returnType='array';
    protected $allowedFields =[
        'ro_id', 'mo_id', 'perm_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getPermisos(){
        return $this->db->table('permisos per')
        ->where('per.perm_estado',1)
        ->join('roles rol','rol.ro_id = per.ro_id')
        ->join('modulos mo','mo.mo_id = per.mo_id')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('permisos per')
        ->where('per.perm_id', $id)
        ->where('per.perm_estado',1)
         ->join('roles rol','rol.ro_id = per.ro_id')
        ->join('modulos mo','mo.mo_id = per.mo_id')
        ->get()->getResultArray();
    }
}