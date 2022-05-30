<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use Irsyadulibad\DataTables\DataTables;

class Mscompany extends Model
{
    protected $table = 'mscompany as a';

    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            null,
            'a.companyname',
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
        return $this->builder->select('a.companyid, a.companyname, a.address, a.createddate, u.username as createdby, a.updateddate, uu.username as updatedby')
            ->join('msuser as u', 'a.createdby=u.userid')
            ->join('msuser as uu', 'a.updatedby=uu.userid');
    }
    public function get_one($id = '')
    {
        $x = $this->builder->get()->getRowArray();
        if ($id != '') {
            $x = $this->builder->where('a.companyid', $id)->get()->getRowArray();
        }
        return $x;
    }
    public function getSel2($searchTerm)
    {
        return $this->builder
            ->where("companyname like '%" . $searchTerm . "%'")->get()->getResultArray();
    }
    public function tambah($data)
    {
        return $this->builder->insert($data);
    }
    public function edit($data, $id)
    {
        return $this->builder->update($data, ['companyid' => $id]);
    }
    public function hapus($id)
    {
        return $this->builder->delete(['companyid' => $id]);
    }
}
