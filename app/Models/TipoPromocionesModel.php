<?php
namespace App\Models;
use CodeIgniter\Model;
class TipoPromocionesModel extends Model{
    protected $table = 'tipo_promociones';
    protected $primaryKey = 'tpromo_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'tpromo_nombre', 'tpromo_descripcion', 'tpromo__estado'
    ];
}