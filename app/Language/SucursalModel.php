<?php
namespace App\Models;
use CodeIgniter\Model;
class SucursalModel extends Model{
    protected $table = 'sucursal';
    protected $primaryKey = 'su_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'su_direccion','su_distrito', 'su_departamento', 'em_id' ,'su_estado'
    ];


    public function getSucursal(){
        return $this->db->table('sucursal su')
        ->where('su.su_estado',1)
        ->where('su.em_id', 'em_id')
        ->join('empresa emp','emp.em_id = su.em_id')
        ->get()->getResultArray();
    }

    public function getId($id){
        return $this->db->table('sucursal su')
        ->where('su.su_id', $id)
        ->where('su.su_estado',1)
        ->where('su.em_id', 'em_id')
        ->join('empresa emp','emp.em_id = su.em_id')
        ->get()->getResultArray();
    }

}