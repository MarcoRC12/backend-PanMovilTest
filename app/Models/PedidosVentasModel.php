<?php
namespace App\Models;
use CodeIgniter\Model;
class PedidosVentasModel extends Model{
    protected $table='pedidos_ventas';
    protected $primaryKey='pev_id';
    protected $returnType='array';
    protected $allowedFields =[
        've_id', 'pe_id', 'tp_id', 'pev_precioUnitario', 'pev_subtotal', 'pev_totalDeuda',
        'pev_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getPedidosVentas(){
        return $this->db->table('pedidos_ventas pev')
        ->where('pev.pev_estado',1)
        ->join('ventas v','pev.ve_id = v.ve_id')
        ->join('pedidos pe','pev.pe_id = pe.pe_id')
        ->join('tipo_pago tp','pev.tp_id = tp.tp_id')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('pedidos_ventas pev')
        ->where('pev.pev_id', $id)
        ->where('pev.pev_estado', 1)
        ->join('ventas v','pev.ve_id = v.ve_id')
        ->join('pedidos pe','pev.pe_id = pe.pe_id')
        ->join('tipo_pago tp','pev.tp_id = tp.tp_id')
        ->get()->getResultArray();
    }
    public function getVentas(){
        return $this->db->table('ventas v')
        ->where('v.ve_estado', 1)
        ->get()->getResultArray();
    }
    public function getPedidos(){
        return $this->db->table('pedidos pe')
        ->where('pe.pe_estado', 1)
        ->get()->getResultArray();
    }
    public function getTipoPago(){
        return $this->db->table('tipo_pago tp')
        ->where('tp.tp_estado', 1)
        ->get()->getResultArray();
    }
}