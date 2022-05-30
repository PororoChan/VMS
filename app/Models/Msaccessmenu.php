<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Session\Session;
use Irsyadulibad\DataTables\DataTables;

class Msaccessmenu extends Model
{
    protected $table = 'msaccessmenu';

    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    public function AccessCheck($menuid, $usergroupid, $componentid)
    {
        return $this->builder
            ->where('menuid', $menuid)
            ->where('usergroupid', $usergroupid)
            ->where('componentid', $componentid);
    }
    public function deleteUsergroup($usergroupid)
    {
        return $this->builder->delete(['usergroupid' => $usergroupid]);
    }
    public function addAccess($data)
    {
        return $this->builder->insert($data);
    }
}
