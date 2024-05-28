<?php
namespace App\Models;
use CodeIgniter\Model;
class PedidosModel extends Model{
    protected $table='pedidos';
    protected $primaryKey='pe_id';
    protected $returnType='array';
    protected $allowedFields =[
        'pe_numero', 'pe_ordenPedido', 'cl_id', 'pro_id', 'pe_descripcion', 
        'pe_cantidad', 'pe_fechaEntrega', 'empresa', 'pe_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getPedidos(){
        return $this->db->table('pedidos pe')
        ->where('pe.pe_estado',1)
        ->join('clientes cl','cl.cl_id = pe.cl_id')
        ->join('productos pro','pro.pro_id = pe.pro_id')    
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('pedidos pe')
        ->where('pe.pe_id', $id)
        ->where('pe.pe_estado', 1)
         ->join('clientes cl','cl.cl_id = pe.cl_id')
        ->join('productos pro','pro.pro_id = pe.pro_id')
        ->get()->getResultArray();
    }
    public function getClientes(){
        return $this->db->table('clientes c')
        ->where('c.cl_estado', 1)
        ->get()->getResultArray();
    }
    public function getProductos(){
        return $this->db->table('stock s')
        ->where('s.st_estado', 1)
        ->get()->getResultArray();
    }
}