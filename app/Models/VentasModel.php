<?php
namespace App\Models;
use CodeIgniter\Model;
class VentasModel extends Model{
    protected $table='ventas';
    protected $primaryKey='ve_id';
    protected $returnType='array';
    protected $allowedFields =[
        'cl_id', 've_fecha', 'tv_id', 've_total', 
        've_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo
    
    public function getVentas(){
        return $this->db->table('ventas v')
       ->where('v.ve_estado',1)
        ->join('tipo_venta tv','v.tv_id = tv.tv_id')
        ->join('clientes c','v.cl_id = c.cl_id')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('ventas v')
        ->where('v.ve_id', $id)
        ->where('v.ve_estado', 1)
        ->join('tipo_venta tv','tv.tv_id = v.tv_id')
        ->join('clientes c','v.cl_id = c.cl_id')
        ->get()->getResultArray();
    }
    public function getTipoPago(){
        return $this->db->table('tipo_pago tp')
        ->where('tp.tp_estado', 1)
        ->get()->getResultArray();
    }
    public function getClientes(){
        return $this->db->table('clientes c')
        ->where('c.cl_estado', 1)
        ->get()->getResultArray();
    }

}