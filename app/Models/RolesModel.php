<?php
namespace App\Models;
use CodeIgniter\Model;
class RolesModel extends Model{
    protected $table='roles';
    protected $primaryKey='ro_id';
    protected $returnType='array';
    protected $allowedFields =[
        'ro_nombrerol', 'ro_estado'
    ];

}