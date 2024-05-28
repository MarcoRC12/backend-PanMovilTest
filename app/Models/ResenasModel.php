<?php
namespace App\Models;
use CodeIgniter\Model;
class ResenasModel extends Model{
    protected $table = 'resenas';
    protected $primaryKey = 're_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'usumo_id','re_estrellas','re_descripcion', 'pro_id', 're_estado'
    ];


    public function getResenas(){
        return $this->db->table('resenas re')
        ->where('re.re_estado',1)
        ->join('productos pro','pro.pro_id = re.pro_id')
        ->join('usuariosmovil usumo','usumo.usumo_id = re.usumo_id')
        ->get()->getResultArray();
    }

    public function getId($id){
        return $this->db->table('resenas re')
        ->where('re.re_id', $id)
        ->where('re.re_estado', 1)
        ->join('productos pro','pro.pro_id = re.pro_id')
        ->join('usuariosmovil usumo','usumo.usumo_id = re.usumo_id')
        ->get()->getResultArray();
    }

}