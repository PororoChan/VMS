<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use Irsyadulibad\DataTables\DataTables;

class Msusergroup extends Model
{
    protected $table = 'msusergroup as a';

    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            null,
            "a.groupname",
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
    public function get_one($id = '')
    {
        $x = $this->builder->get()->getRowArray();
        if ($id != '') {
            $x = $this->builder->where('a.groupid', $id)->get()->getRowArray();
        }
        return $x;
    }
    public function getSel2($searchTerm)
    {
        return $this->builder->where('isactive', 't')
            ->where("groupname like '%" . $searchTerm . "%'")->get()->getResultArray();
    }
    public function tambah($data)
    {
        return $this->builder->insert($data);
    }
    public function edit($data, $id)
    {
        return $this->builder->update($data, ['a.groupid' => $id]);
    }
    public function hapus($id)
    {
        return $this->builder->delete(['a.groupid' => $id]);
    }
}
