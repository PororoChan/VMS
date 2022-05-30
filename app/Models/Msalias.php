<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

class Msalias extends Model
{
    protected $table = 'vmsmsaliascode as b';
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            null,
            "b.aliasname",
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
            ->where("aliascode like '%" . $searchTerm . "%'")->get()->getResultArray();
    }

    public function get_one($id = '')
    {
        $x = $this->builder;
        if ($id != '') {
            $x->where('b.aliasid', $id);
        }
        return $x->get()->getRowArray();
    }
    public function tambah($data)
    {
        return $this->builder->insert($data);
    }
    public function edit($data, $id)
    {
        return $this->builder->update($data, ['aliasid' => $id]);
    }
    public function hapus($id)
    {
        return $this->builder->delete(['aliasid' => $id]);
    }
    //--------------------------------------------------------------------
}
