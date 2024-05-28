<?php
namespace App\Models;
use CodeIgniter\Model;
class StockModel extends Model{
    protected $table='stock';
    protected $primaryKey='st_id';
    protected $returnType='array';
    protected $allowedFields =[
        'st_CantidadAdquirida', 'st_CantidadDisponible', 'pro_id', 'st_codigo', 'empresa', 'sucursal',
        'st_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getStock(){
        return $this->db->table('stock s')
        ->where('s.st_estado',1)
        ->join('productos pro','s.pro_id = pro.pro_id')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('stock s')
        ->where('s.st_id', $id)
        ->where('s.st_estado', 1)
        ->join('productos pro','s.pro_id = pro.pro_id')
        ->get()->getResultArray();
    }
    public function getProductos(){
        return $this->db->table('productos pro')
        ->where('pro.pro_estado', 1)
        ->get()->getResultArray();
    }
}