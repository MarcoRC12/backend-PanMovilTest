<?php
namespace App\Models;
use CodeIgniter\Model;
class ModulosModel extends Model{
    protected $table='modulos';
    protected $primaryKey='mo_id';
    protected $returnType='array';
    protected $allowedFields =[
        'mo_nombre', 'mo_descripcion', 'mo_estado'
    ];

}