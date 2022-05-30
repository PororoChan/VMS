<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use Irsyadulibad\DataTables\DataTables;

class Mscomponent extends Model
{
    protected $table = 'mscomponent as a';

    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            null,
            'a.componentname',
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
        return $this->builder->select('a.componentid, a.componentname, a.description, a.createddate, a.createdby, a.updateddate, a.updatedby')
            ->orderBy('a.componentid', 'asc');
    }
    public function get_one($id = '')
    {
        $x = $this->builder;
        if ($id != '') {
            $x->where('a.componentid', $id);
        }
        return $x->get()->getRowArray();
    }
    public function tambah($data)
    {
        return $this->builder->insert($data);
    }
    public function edit($data, $id)
    {
        return $this->builder->update($data, ['componentid' => $id]);
    }
    public function hapus($id)
    {
        return $this->builder->delete(['componentid' => $id]);
    }
}
