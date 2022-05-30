<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;

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
    public function cek($user)
    {
        return $this->builder
            ->where('b.user', $user)
            ->get()->getRowArray();
    }

    public function getSel2($searchTerm)
    {
        return $this->builder
            ->where("fullname like '%" . $searchTerm . "%'")->get()->getResultArray();
    }

    public function get_one($id = '')
    {
        $x = $this->builder->select('b.user, b.fullname as fulname, b.pass, b.ssn, b.group, b.area, s.id as usrcod, v.id as usrcode, a.usercode, a.fullname, v.fullname as fullnames, s.fullname as fullnamess, b.phone, b.spvid, b.kasacabid, b.is_active, b.is_loginable, b.is_spv')
            ->join('vmsmsuser as a', 'b.userid = a.usercode')
            ->join('vmsmssecurity as v', 'b.spvid = v.id')
            ->join('vmsmssecurity as s', 'b.kasacabid = s.id');

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
