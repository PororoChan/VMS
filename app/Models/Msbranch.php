<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

class Msbranch extends Model
{
    protected $table = 'vmsmsbranch as b';
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            null,
            "b.branchcode",
            "b.branchname",
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
        return $this->builder;
    }

    public function getSel2($searchTerm)
    {
        return $this->builder->distinct()
            ->select('b.branchcode, b.branchname')
            ->where("b.branchcode  like '%" . $searchTerm . "%'")->orderBy('b.branchname', 'asc')->get()->getResultArray();
    }

    public function get_one($id = '')
    {
        $x = $this->builder->select('b.id, b.branchid, b.isactive, b.branchcode, b.branchname, b.areacode, b.aliascode, b.kasacabid, a.usercode')
            ->join('vmsmsuser as a', 'b.kasacabid = a.usercode', 'left');
        if ($id != '') {
            $x->where('b.id', $id);
        }
        return $x->get()->getRowArray();
    }
    public function tambah($data)
    {
        return $this->builder->insert($data);
    }
    public function edit($data, $id)
    {
        return $this->builder->update($data, ['id' => $id]);
    }
    public function hapus($id)
    {
        return $this->builder->delete(['id' => $id]);
    }
}
