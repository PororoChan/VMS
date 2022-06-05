<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use Irsyadulibad\DataTables\DataTables;

class Msaccessgroup extends Model
{
    protected $table = 'msaccessgroup';

    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function addAccess($data)
    {
        return $this->builder->insert($data);
    }
    public function searchable()
    {
        return [
            null,
            "b.groupname",
            null,
            null,
        ];
    }
    public function datatabel($userid)
    {
        return $this->builder
            ->select("msaccessgroup.accessgroupid, b.groupname, string_agg(d.menuname, ';') as list_menu, msaccessgroup.isactive as activated")
            ->join('msusergroup as b', 'b.groupid=msaccessgroup.usergroupid')
            ->join('msaccessmenu as c', 'c.usergroupid=msaccessgroup.usergroupid', 'LEFT')
            ->join('msmenu as d', 'd.menuid=c.menuid', 'LEFT')
            ->where('msaccessgroup.userid', $userid)
            ->where('c.componentid', 1)
            ->groupBy('b.groupid')
            ->groupBy('msaccessgroup.accessgroupid');
    }
    public function checkAccessgroup($userid, $usergroupid)
    {
        return $this->builder->where('userid', $userid)
            ->where('usergroupid', $usergroupid);
    }
    public function edit($accessgroupid, $data)
    {
        return $this->builder->update($data, ['accessgroupid' => $accessgroupid]);
    }
    public function hapus($accessgroupid)
    {
        return $this->builder->delete(['accessgroupid' => $accessgroupid]);
    }
    public function check($userid, $usergroupid)
    {
        return $this->builder->where('userid', $userid)
            ->where('usergroupid', $usergroupid)
            ->get()->getResultArray();
    }
}
