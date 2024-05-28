<?php
namespace App\Models;
use CodeIgniter\Model;
class TiposProductosModel extends Model{
    protected $table = 'tipos_productos';
    protected $primaryKey = 'tpro_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'tpro_nombre', 'tpro_descripcion', 'tpro_estado'
    ];

}