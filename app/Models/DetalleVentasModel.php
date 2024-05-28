<?php
namespace App\Models;
use CodeIgniter\Model;
class DetalleVentasModel extends Model{
    protected $table='detalle_ventas';
    protected $primaryKey='dv_id';
    protected $returnType='array';
    protected $allowedFields =[
        'dv_numero', 'dv_ordenVenta','ve_id', 'pro_id', 'tp_id', 'dv_cantidad', 'dv_subtotal', 'empresa',
        'dv_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getDetalleVentas(){
        return $this->db->table('detalle_ventas dv')
        ->where('dv.dv_estado',1)
        ->join('ventas v','dv.ve_id = v.ve_id')
        ->join('productos pro','dv.pro_id = pro.pro_id')
        ->join('tipo_pago tp','dv.tp_id = tp.tp_id')
        ->join('clientes cl', 'cl.cl_id=v.cl_id')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('detalle_ventas dv')
        ->where('dv.dv_id', $id)
        ->where('dv.dv_estado', 1)
        ->join('ventas v','dv.ve_id = v.ve_id')
        ->join('productos pro','dv.pro_id = pro.pro_id')
        ->join('tipo_pago tp','dv.tp_id = tp.tp_id')
        ->get()->getResultArray();
    }
    public function getVentas(){
        return $this->db->table('ventas v')
        ->where('v.ve_estado', 1)
        ->get()->getResultArray();
    }
    public function getProductos(){
        return $this->db->table('producto pro')
        ->where('pro.pro_estado', 1)
        ->get()->getResultArray();
    }
    public function getTipoPago(){
        return $this->db->table('tipo_pago tp')
        ->where('tp.tp_estado', 1)
        ->get()->getResultArray();
    }
}