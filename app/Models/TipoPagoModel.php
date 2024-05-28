<?php
namespace App\Models;
use CodeIgniter\Model;
class TipoPagoModel extends Model{
    protected $table = 'tipo_pago';
    protected $primaryKey = 'tp_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'tp_nombre', 'tp_estado'
    ];
}