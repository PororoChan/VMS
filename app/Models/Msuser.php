<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use PHPUnit\Framework\Constraint\IsNull;

use function PHPUnit\Framework\isNull;

class Msuser extends Model
{
    protected $table = 'vmsmssecurity as b';
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            null,
            "b.user",
            "b.fullname",
            "b.area",
            "b.phone",
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ];
    }

    public function getAll($param, $text)
    {
        return $this->builder->distinct()
            ->select('b.id as ids, b.userid, b.user, b.fullname, r.branchname, b.area, b.phone')
            ->join('vmsmsuser as u', 'u.usercode = b.userid')
            ->join('vmsmsbranch as r', 'u.branchid = r.branchcode');
    }

    public function cek($user)
    {
        return $this->builder
            ->where('b.user', $user)
            ->get()->getRowArray();
    }

    public function getSpv($searchTerm)
    {
        return $this->builder
            ->join('vmsmsuser as a', 'a.usercode = b.userid')
            ->where('a.usertype', 'SUPERVISOR')->get()->getResultArray();
    }

    public function getKasaca($searchTerm)
    {
        return $this->builder
            ->join('vmsmsuser as u', 'b.userid = u.usercode')
            ->where("b.fullname like '%" . $searchTerm . "%'")->where('u.usertype', 'KASACAB')
            ->get()->getResultArray();
    }

    public function get_one($id = '')
    {
        $x = $this->builder->distinct()
            ->select('b.id, b.user, b.fullname as fulname, b.pass, b.ssn, b.group, b.area, s.id as usrcod, v.id as usrcode, a.usercode, 
                        a.fullname, v.fullname as fullnames, s.fullname as fullnamess, b.phone, b.spvid, b.kasacabid, b.is_active, b.is_loginable, 
                        b.is_spv, r.branchcode as bc, r.branchname as bn')
            ->join('vmsmsuser as a', 'b.userid = a.usercode')
            ->join('vmsmsbranch as r', 'r.branchcode = a.branchid')
            ->join('vmsmssecurity as v', 'b.spvid = v.id', 'left')
            ->join('vmsmssecurity as s', 'b.kasacabid = s.id', 'left');

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
