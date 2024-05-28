<?php
namespace App\Models;
use CodeIgniter\Model;
class ProductosModel extends Model{
    protected $table='productos';
    protected $primaryKey='pro_id';
    protected $returnType='array';
    protected $allowedFields =[
        'pro_nombre', 'pro_descripcion', 'tpro_id', 'pro_PrecioUnitario', 'pro_marca', 'pro_imagen' ,
        'pro_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getProductos(){
        return $this->db->table('productos pro')
        ->where('pro.pro_estado',1)
        ->join('tipos_productos tpro','pro.tpro_id = tpro.tpro_id')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('productos pro')
        ->where('pro.pro_id', $id)
        ->where('pro.pro_estado', 1)
        ->join('tipos_productos tpro','pro.tpro_id = tpro.tpro_id')
        ->get()->getResultArray();
    }

    public function getEmpresa($id){
        return $this->db->table('empresa emp')
        ->where('emp.em_id', $id)
        ->where('emp.em_estado', 1)
        ->get()->getResultArray();
    }
    public function getTiposProductos(){
        return $this->db->table('tipos_productos tpro')
        ->where('tpro.tpro_estado', 1)
        ->get()->getResultArray();
    }
}