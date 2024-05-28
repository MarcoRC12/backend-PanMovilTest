<?php
namespace App\Models;
use CodeIgniter\Model;
class PagosModel extends Model{
    protected $table='pagos';
    protected $primaryKey='pag_id';
    protected $returnType='array';
    protected $allowedFields =[
        'st_id', 'pag_PrecioCompra', 'pv_id', 'pag_FechaCompra', 
        'pag_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getPagos(){
        return $this->db->table('pagos p')
        ->where('p.pag_estado',1)
        ->join('proveedores pr','p.pv_id = pr.pv_id')
        ->join('stock s','p.st_id = s.st_id')
        ->join('productos pro','pro.pro_id = s.pro_id')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('pagos p')
        ->where('p.pag_id', $id)
        ->where('p.pag_estado', 1)
        ->join('proveedores pr','p.pv_id = pr.pv_id')
        ->join('stock s','p.st_id = s.st_id')
        ->join('productos pro','pro.pro_id = s.pro_id')
        ->get()->getResultArray();
    }
    public function getProveedores(){
        return $this->db->table('provedores pr')
        ->where('pr.pv_estado', 1)
        ->get()->getResultArray();
    }
    public function getStock(){
        return $this->db->table('stock s')
        ->where('s.estado', 1)
        ->get()->getResultArray();
    }
}