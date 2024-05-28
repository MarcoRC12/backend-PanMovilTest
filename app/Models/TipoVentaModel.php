<?php
namespace App\Models;
use CodeIgniter\Model;
class TipoVentaModel extends Model{
    protected $table = 'tipo_venta';
    protected $primaryKey = 'tv_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'tv_nombre', 'tv_estado'
    ];

}