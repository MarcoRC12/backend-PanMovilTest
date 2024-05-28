<?php
namespace App\Models;
use CodeIgniter\Model;
class EstablecimientoModel extends Model{
    protected $table='establecimiento';
    protected $primaryKey='es_id';
    protected $returnType='array';
    protected $allowedFields =[
        'su_id', 'es_nombre', 'es_nombencargado', 'es_apencargado', 'es_estado'
    ];
    // Como es una tabla que tiene llaves foráneas vamos a crear
    // las relaciones en el modelo

    public function getEstablecimiento(){
        return $this->db->table('establecimiento es')
        ->where('es.es_estado',1)
        ->join('sucursal su','su.su_id = es.su_id')
        ->get()->getResultArray();
    }
    public function getId($id){
        return $this->db->table('establecimiento es')
        ->where('es.es_id', $id)
        ->where('es.es_estado',1)
        ->join('sucursal su','su.su_id = es.su_id')
        ->get()->getResultArray();
    }
}