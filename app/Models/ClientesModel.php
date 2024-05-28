<?php
namespace App\Models;
use CodeIgniter\Model;
class ClientesModel extends Model{
    protected $table = 'clientes';
    protected $primaryKey = 'cl_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'cl_nombre', 'cl_apellido', 'cl_dni', 'cli_numero', 'cli_email', 'cl_estado'
    ];

}