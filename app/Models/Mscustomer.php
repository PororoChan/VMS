<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

class Mscustomer extends Model
{
    protected $table = 'vmsmscustomer as b';
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            "b.custcode",
            "b.custname",
            "b.custtype",
            "b.custaddress",
            "b.custemail",
            "b.custphone",
            "b.branchid",
            null,
            null,
            null,
            null
        ];
    }
    public function getAllData($branchid = '')
    {
        $x = $this->builder;
        if ($branchid != '') {
            $x->where('branchid', $branchid);
        }
        return $x;
        //->join('vmsmssecurity as u', 'b.created_by=u.userid')
        //->join('vmsmssecurity as uu', 'b.updated_by=uu.userid');
        //->join('msuserdt as ba', 'b.userid=ba.msuserdt');
    }

    public function getSel2($searchTerm)
    {
        return $this->builder
            ->where("custname like '%" . $searchTerm . "%'")->get()->getResultArray();
    }

    public function get_one($id = '')
    {
        $x = $this->builder->select('b.custcode, b.custname, b.custaddress, b.custtype, b.custemail, b.custphone, b.branchid, a.branchcode, b.isactive')
            ->join('vmsmsbranch as a', 'b.branchid = a.branchcode');
        if ($id != '') {
            $x->where('b.custcode', $id);
        }
        return $x->get()->getRowArray();
    }
    public function tambah($data)
    {
        return $this->builder->insert($data);
    }
    public function edit($data, $id)
    {
        return $this->builder->update($data, ['custcode' => $id]);
    }
    public function hapus($id)
    {
        return $this->builder->delete(['custcode' => $id]);
    }
    //--------------------------------------------------------------------
}
