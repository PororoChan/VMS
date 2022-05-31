<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Helpers\Datatables\Datatables;
use App\Models\Msaccessgroup;
use App\Models\Msaccessmenu;
use App\Models\Mscompany;
use App\Models\Msmenu;
use App\Models\Msuser;
use App\Models\Msusergroup;

class User extends BaseController
{
    public function __construct()
    {
        $this->user = new Msuser();
        $this->group = new Msusergroup();
        $this->msmenu = new Msmenu();
        $this->Msaccessgroup = new Msaccessgroup();
    }
    public function index()
    {
        $data = [
            "sidebar" => $this->msmenu->get_master_sidebar(session()->get('id_user')),
            "menuside" => $this->msmenu,
        ];
        if (session()->get('id_user') == null) {
            return redirect()->to(base_url('login'));
        }

        return view('master/user/V_user', $data);
    }
    public function datatabel()
    {
        $datatables = Datatables::method([Msuser::class, 'getAllData'], 'searchable')
            ->setParams(1, 'kedua')
            ->make();
        //        echo db_connect()->showLastQuery();
        $datatables->updateRow(function ($db, $nomor) {
            return [
                $nomor,
                $db->user,
                $db->fullname,
                $db->area,
                $db->phone,
                "
                <button type='button' class='btn btn-sm btn-success eee' onclick=\"modalGlobal('Usergroup Setting - " . $db->user . "', 'modal-lg', '" . base_url('user/Accessgroup/' . $db->userid) . "')\"><i class='fas fa-users-cog'></i></button> 
                <button type='button' class='btn btn-sm btn-warning eee' onclick=\"modalGlobal('Edit User', 'modal-lg', '" . base_url('user/EditViews/' . $db->id) . "')\"><i class='fas fa-pencil-alt'></i></button> " .
                    " <button type='button' class='btn btn-sm btn-danger hhh' onclick=\"deleteGlobal('Hapus User', 'modal-lg', '" . $db->id . "', '" . base_url('user/deleteData') . "', '" . base_url('/user') . "')\"><i class='far fa-trash-alt'></i></button>
                 <button type='button' class='btn btn-sm btn-primary hhh' onclick=\"deleteGlobal('Reset Deviceid', 'modal-lg', '" . $db->id . "', '" . base_url('user/resetData/') . "', '" . base_url('/user') . "')\"><i class='fas fa-sync'></button>",
            ];
        });
        $datatables->toJson();
    }
    public function getUser()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $comp = $this->user->getSel2($searchTerm);
        $response = array();
        foreach ($comp as $c) {
            $response[] = array("id" => $c['id'], "text" => $c['fullname']);
        }
        echo json_encode($response);
    }
    public function getUser1()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $comp = $this->user->getSel2($searchTerm);
        $response = array();
        foreach ($comp as $c) {
            $response[] = array("id" => $c['id'], "text" => $c['fullname']);
        }
        echo json_encode($response);
    }
    public function getGroup()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $usergroup = $this->group->getSel2($searchTerm);
        $response = array();
        foreach ($usergroup as $c) {
            $response[] = array("id" => $c['groupid'], "text" => $c['groupname']);
        }
        echo json_encode($response);
    }

    public function FormViews($id = '')
    {
        $form_type = 'add';
        if ($id != '') {
            $form_type = 'edit';
        }

        $data = [
            'form_type' => $form_type,
            'row' => $this->user->get_one($id),
            'id' => $id
        ];
        $tes['view'] = view('master/user/V_form', $data);
        echo json_encode($tes);
    }

    public function resetData()
    {
        $id = $this->request->getPost('id');
        $query = ['deviceid' => ''];
        $this->user->edit($query, $id);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function addData()
    {
        $data = [
            'user' => $this->request->getPost('username'),
            'ssn' => $this->request->getPost('ssn'),
            'pass' => $this->request->getPost('password'),
            'group' => $this->request->getPost('groupnum'),
            'fullname' => $this->request->getPost('fullname'),
            'area' => $this->request->getPost('area'),
            'userid' => $this->request->getPost('userid'),
            'phone' => $this->request->getPost('phone'),
            'spvid' => $this->request->getPost('spvid'),
            'kasacabid' => $this->request->getPost('kasacabid'),
            'is_active' => 0,
            'is_loginable' => 0,
            'created_date' => date("Y-m-d H:i:s"),
            'created_by' => session()->get('nama'),
            'updated_date' => date("Y-m-d H:i:s"),
            'updated_by' => session()->get('nama')
        ];
        $query = $this->user->tambah($data);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function editData()
    {
        $password = $this->request->getPost('password_lama');
        if ($this->request->getPost('pass') != '') {
            $password = password_hash($this->request->getPost('pass'), PASSWORD_BCRYPT);
        }
        $userid = $this->request->getPost('id');
        $data = [
            'user' => $this->request->getPost('user'),
            'pass' => $password,
            'ssn' => $this->request->getPost('ssn'),
            'group' => $this->request->getPost('group'),
            'fullname' => $this->request->getPost('fullname'),
            'is_loginable' => $this->request->getPost('is_loginable'),
            'is_active' => $this->request->getPost('is_active'),
            'area' => $this->request->getPost('area'),
            'userid' => $this->request->getPost('userid'),
            'phone' => $this->request->getPost('phone'),
            'deviceid' => $this->request->getPost('deviceid'),
            'is_spv' => $this->request->getPost('is_spv'),
            'spvid' => $this->request->getPost('spvid'),
            'kasacabid' => $this->request->getPost('kasacabid'),
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_by' => session()->get('id_user'),
        ];
        $query = $this->user->edit($data, $userid);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function deleteData()
    {
        $id = $this->request->getPost('id');
        $query = $this->user->hapus($id);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function Accessgroup($userid)
    {
        $data = [
            'userid' => $userid
        ];
        $tes['view'] = view('master/user/V_accessgroup', $data);
        echo json_encode($tes);
    }
    public function Addaccessgroup()
    {
        $data = [
            'userid' => $this->request->getPost('userid'),
            'usergroupid' => $this->request->getPost('usergroupid'),
            'isactive' => 't',
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => session()->get('id_user'),
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => session()->get('id_user'),
        ];
        $checkaccess = $this->Msaccessgroup
            ->checkAccessgroup($this->request->getPost('userid'), $this->request->getPost('usergroupid'))->countAllResults();
        if ($checkaccess == 0) {
            $this->Msaccessgroup->addAccess($data);
            echo 1;
        } else {
            echo "Usergroup sudah ditambahkan";
        }
    }
    public function GroupAccessTable($userid)
    {
        $datatables = Datatables::method([Msaccessgroup::class, 'datatabel'], 'searchable')
            ->setParams($userid)
            ->make();
        //        echo db_connect()->showLastQuery();
        $datatables->updateRow(function ($db, $nomor) {
            if ($db->activated != 't') {
                $check = '';
            } else {
                $check = 'checked';
            }
            $are = explode(';', $db->list_menu);
            $era = implode('<br>', $are);
            return [
                $nomor,
                $db->groupname,
                $era,
                "<i class=\"fas fa-trash text-danger\" onclick=\"deleteAccess('" . $db->accessgroupid . "')\"></i> " .
                    "<input type='checkbox' " . $check . " value='" . $db->activated . "' onclick=\"activated('" . $db->accessgroupid . "', '" . $db->activated . "')\">"
            ];
        });
        $datatables->toJson();
    }
    public function deleteaccessgroup()
    {
        $accessgroupid = $this->request->getPost('usergroupid');
        $this->Msaccessgroup->hapus($accessgroupid);
        echo 1;
    }
    public function Editaccessgroup()
    {
        $accessgroupid = $this->request->getPost('accessgroupid');
        $isactive = $this->request->getPost('active');
        $data = [
            'isactive' => $isactive,
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => session()->get('id_user'),
        ];
        $this->Msaccessgroup->edit($accessgroupid, $data);
        echo 1;
    }
}
