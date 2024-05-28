<?php
namespace App\Models;
use CodeIgniter\Model;
class RegistrosModel extends Model{
    protected $table = 'registros';
    protected $primaryKey = 'idregistro';
    protected $returnType = 'array';
    protected $allowedFields = [
        'nombres', 'apellidos', 'email', 'cliente_id', 'llave_secreta', 'estado'
    ];

}