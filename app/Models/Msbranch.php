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
        //->join('vmsmssecurity as u', 'b.created_by=u.userid')
        //->join('vmsmssecurity as uu', 'b.updated_by=uu.userid');
        //->join('msuserdt as ba', 'b.userid=ba.msuserdt');
    }

    public function getSel2($searchTerm)
    {
        return $this->builder
            ->where("branchcode  like '%" . $searchTerm . "%'")->get()->getResultArray();
    }


    public function get_one($id = '')
    {
        $x = $this->builder->select('b.branchid, b.isactive, b.branchcode, b.branchname, b.areacode, b.aliascode, b.kasacabid, a.usercode')
            ->join('vmsmsuser as a', 'b.kasacabid = a.usercode');
        if ($id != '') {
            $x->where('b.branchid', $id);
        }
        return $x->get()->getRowArray();
    }
    public function tambah($data)
    {
        return $this->builder->insert($data);
    }
    public function edit($data, $id)
    {
        return $this->builder->update($data, ['branchid' => $id]);
    }
    public function hapus($id)
    {
        return $this->builder->delete(['branchid' => $id]);
    }
    //--------------------------------------------------------------------
}
