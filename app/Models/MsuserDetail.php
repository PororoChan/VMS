<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

class MsuserDetail extends Model
{
    protected $table = 'vmsmsuser as b';
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            null,
            "b.usercode",
            "b.fullname",
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ];
    }
    public function getAllData($param, $text)
    {
        return $this->builder
            ->join('vmsmsbranch as u', 'b.branchid = u.branchcode');
    }
    public function cek($user)
    {
        return $this->builder
            ->where('b.usercode', $user)
            ->get()->getRowArray();
    }

    public function getSel2($searchTerm)
    {
        return $this->builder
            ->where("fullname like '%" . $searchTerm . "%'")->get()->getResultArray();
    }

    public function get_one($id = '')
    {
        $x = $this->builder;
        if ($id != '') {
            $x->where('b.usercode', $id);
        }
        return $x->get()->getRowArray();
    }
    public function tambah($data)
    {
        return $this->builder->insert($data);
    }
    public function edit($data, $id)
    {
        return $this->builder->update($data, ['usercode' => $id]);
    }
    public function hapus($id)
    {
        return $this->builder->delete(['usercode' => $id]);
    }
    //--------------------------------------------------------------------
}
