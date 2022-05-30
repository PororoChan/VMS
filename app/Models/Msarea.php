<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

class Msarea extends Model
{
    protected $table = 'vmsmsareacode as b';
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            null,
            "b.areaname",
            null,
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
        return $this->builder
            ->where("areacode like '%" . $searchTerm . "%'")->get()->getResultArray();
    }

    public function get_one($id = '')
    {
        $x = $this->builder;
        if ($id != '') {
            $x->where('b.areaid', $id);
        }
        return $x->get()->getRowArray();
    }
    public function tambah($data)
    {
        return $this->builder->insert($data);
    }
    public function edit($data, $id)
    {
        return $this->builder->update($data, ['areaid' => $id]);
    }
    public function hapus($id)
    {
        return $this->builder->delete(['areaid' => $id]);
    }
    //--------------------------------------------------------------------
}
