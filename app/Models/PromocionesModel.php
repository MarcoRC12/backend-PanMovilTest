<?php
namespace App\Models;
use CodeIgniter\Model;
class PromocionesModel extends Model{
    protected $table='promociones';
    protected $primaryKey='promo_id';
    protected $returnType='array';
    protected $allowedFields =[
        'tpromo_id', 'pro_id', 'promo_descuento', 'promo_fechaini', 'promo_fechafin', 'empresa','promo__estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getPromociones(){
        return $this->db->table('promociones promo')
        ->where('promo.promo__estado',1)
        ->join('tipo_promociones tpromo','promo.tpromo_id = tpromo.tpromo_id')
        ->join('productos pro','pro.pro_id = promo.pro_id')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('promociones promo')
        ->where('promo.promo_id', $id)
        ->where('promo.promo__estado', 1)
        ->join('tipo_promociones tpromo','promo.tpromo_id = tpromo.tpromo_id')
        ->join('productos pro','pro.pro_id = promo.pro_id')
        ->get()->getResultArray();
    }
    public function getTipoPromociones(){
        return $this->db->table('tipo_promociones tpromo')
        ->where('tpromo.tpromo__estado', 1)
        ->get()->getResultArray();
    }
}