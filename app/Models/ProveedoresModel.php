<?php
namespace App\Models;
use CodeIgniter\Model;
class ProveedoresModel extends Model{
    protected $table='proveedores';
    protected $primaryKey='pv_id';
    protected $returnType='array';
    protected $allowedFields =[
        'pv_RazonSocial', 'pv_ruc', 'pv_NombreEncargado', 'pv_ApellidoEncargado', 'pv_direccion', 'pv_telefono', 'empresa',
        'pv_estado'
    ];
}