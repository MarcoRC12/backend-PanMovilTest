<?php
namespace App\Models;
use CodeIgniter\Model;
class EmpresaModel extends Model{
    protected $table='empresa';
    protected $primaryKey='em_id';
    protected $returnType='array';
    protected $allowedFields =[
        'em_dirección', 'em_razonsocial', 'em_ruc', 'em_dueñonombre', 'em_dueñoapellido', 'em_telefono', 'em_logo' ,'em_estado'
    ];

}