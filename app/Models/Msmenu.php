<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use Irsyadulibad\DataTables\DataTables;

class Msmenu extends Model
{
    protected $table = 'msmenu as a';
    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function searchable()
    {
        return [
            null,
            "a.menuname",
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,

        ];
    }
    public function datatable($param, $text)
    {
        return $this->builder->select('a.menuid, a.menuname, a.masterid, a.menulink, a.seq, a.menuicon, a.isactive, a.createddate, a.createdby, a.updateddate, a.updatedby, ms.menuname as master, ms.masterid as msid')
            ->join('msmenu as ms', 'ms.menuid = a.masterid', 'left');
    }
    public function getAllData($searchTerm = '')
    {
        return $this->builder
            ->select('a.menuid, a.menuname, a.masterid, a.menulink, a.seq, a.menuicon, a.isactive, a.createddate,  a.createdby, a.updateddate, a.updatedby, ms.menuname as master, ms.masterid as msid')
            ->join('msmenu as ms', 'ms.menuid=a.masterid', 'left')
            ->where("a.menuname like '%" . $searchTerm . "%'")
            ->get()->getResultArray();
    }
    public function get_one($id = '', $masterid = 0)
    {
        $x = $this->builder->select('a.menuid, a.menuname, a.masterid, a.menulink, a.seq, a.menuicon, a.isactive, a.createddate, a.updateddate, a.masterid as msid');
        if ($id != '') {
            if ($masterid != 0) {
                $x = $this->builder->select('a.menuid, a.menuname, a.masterid, a.menulink, a.seq, a.menuicon, a.isactive, a.createddate, a.updateddate, ms.menuname as master, ms.masterid as msid')
                    ->join('msmenu as ms', 'ms.menuid=a.masterid');
            }
            $x->where('a.menuid', $id);
        }
        return $x->get()->getRowArray();
    }
    public function get_master_sidebar($id_user)
    {
        return $this->builder
            ->select('a.menuid, a.menulink, a.menuname, a.menuicon')
            ->join('msaccessmenu', 'msaccessmenu.menuid=a.menuid')
            ->join('msusergroup', 'msusergroup.groupid=msaccessmenu.usergroupid')
            ->join('msaccessgroup', 'msaccessgroup.usergroupid=msusergroup.groupid')
            ->where('msaccessmenu.componentid', 1)
            ->where('a.masterid', 0)
            ->where('msaccessgroup.userid', $id_user)
            ->groupBy('msaccessmenu.menuid')
            ->groupBy('a.menuid')
            ->orderBy('a.seq', 'asc')->get()->getResultArray();
    }
    public function checkMenu_sidebar($masterid)
    {
        return $this->builder
            ->select('a.menuid, a.menulink, a.menuname, a.menuicon')
            ->join('msaccessmenu', 'msaccessmenu.menuid=a.menuid')
            ->join('msusergroup', 'msusergroup.groupid=msaccessmenu.usergroupid')
            ->join('msaccessgroup', 'msaccessgroup.usergroupid=msusergroup.groupid')
            ->where('msaccessmenu.componentid', 1)
            ->where('a.masterid', $masterid)
            ->where('msaccessgroup.userid', session()->get('id_user'))
            ->groupBy('msaccessmenu.menuid')
            ->groupBy('a.menuid')
            ->orderBy('a.seq', 'asc');
    }
    public function get_master()
    {
        return $this->builder->where('masterid', 0)
            ->orderBy('seq', 'asc')->get()->getResultArray();
    }

    public function checkMenu($masterid)
    {
        return $this->builder->where('masterid', $masterid)
            ->orderBy('seq', 'asc');
    }
    public function tambah($data)
    {
        return $this->builder->insert($data);
    }
    public function edit($data, $id)
    {
        return $this->builder->update($data, ['menuid' => $id]);
    }
    public function hapus($id)
    {
        return $this->builder->delete(['menuid' => $id]);
    }
}
