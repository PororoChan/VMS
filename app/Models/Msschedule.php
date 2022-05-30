<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

class Msschedule extends Model
{
    protected $table = 'vmstrschedule as b';
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            null,
            "b.schecode",
            "b.salesmanid",
            "b.custid",
            null,
            "b.description",
            null,
            null,
        ];
    }
    public function getAllData($param, $text)
    {
        return $this->builder;
    }

    public function get_one($id = '')
    {
        $x = $this->builder;
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
    //--------------------------------------------------------------------
}
