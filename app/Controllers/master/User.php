<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Helpers\Datatables\Datatables;
use App\Models\Msaccessgroup;
use App\Models\Msmenu;
use App\Models\Msuser;
use App\Models\Msusergroup;
use CodeIgniter\Entity\Cast\DatetimeCast;
use DateTime;

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
        $datatables = Datatables::method([Msuser::class, 'getAll'], 'searchable')
            ->setParams(1, 'kedua')
            ->make();

        $datatables->updateRow(function ($db, $nomor) {
            return [
                $nomor,
                $db->user,
                $db->fullname,
                $db->branchname,
                $db->area,
                $db->phone,
                "
                <button type='button' class='btn btn-sm btn-success eee' onclick=\"modalGlobal('Usergroup Setting - " . $db->user . "', 'modal-lg', '" . base_url('user/Accessgroup/' . $db->userid) . "')\"><i class='fas fa-users-cog'></i></button> 
                <a class='btn btn-sm btn-warning eee' href='" . base_url('user/EditViews/' . $db->ids . '') . "')\"><i class='fas fa-pencil-alt'></i></a> " .
                    " <button type='button' class='btn btn-sm btn-danger hhh' onclick=\"deleteGlobal('VMS', 'Anda yakin ingin menghapus user ?', 'modal-lg', '" . $db->ids . "', '" . base_url('user/deleteData') . "', '" . base_url('/user') . "', 'Hapus')\"><i class='far fa-trash-alt'></i></button>
                 <button type='button' class='btn btn-sm btn-primary hhh' onclick=\"deleteGlobal('VMS', 'Anda yakin ingin mereset device ?', 'modal-lg', '" . $db->ids . "', '" . base_url('user/resetData/') . "', '" . base_url('/user') . "', 'Reset')\"><i class='fas fa-sync'></button>",
            ];
        });

        $datatables->toJson();
    }
    public function getKasacabid()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $comp = $this->user->getKasaca($searchTerm);
        $response = array();
        foreach ($comp as $c) {
            $response[] = array("id" => $c['id'], "text" => $c['fullname']);
        }
        echo json_encode($response);
    }
    public function getSpv()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $comp = $this->user->getSpv($searchTerm);
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
        $form_type = 'Add';
        if ($id != '') {
            $form_type = 'Edit';
        }

        $data = [
            'form_type' => $form_type,
            'row' => $this->user->get_one($id),
            'id' => $id
        ];
        return view('master/user/V_form', $data);
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
        $date = new DateTime('NOW');
        $data = [
            'user' => $this->request->getPost('username'),
            'ssn' => $this->request->getPost('ssn'),
            'pass' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'group' => $this->request->getPost('groupnum'),
            'fullname' => $this->request->getPost('fullname'),
            'area' => $this->request->getPost('area'),
            'userid' => $this->request->getPost('userid'),
            'phone' => $this->request->getPost('phone'),
            'spvid' => $this->request->getPost('spvid'),
            'kasacabid' => $this->request->getPost('kasacabid'),
            'is_active' => 0,
            'is_loginable' => 0,
            'created_date' => $date->format("Y-m-d H:i:s.u"),
            'created_by' => session()->get('nama'),
            'updated_date' => $date->format("Y-m-d H:i:s.u"),
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
        $active = '';
        $loginable = '';
        $date = new DateTime('NOW');

        if ($this->request->getPost('pass') != '') {
            $password = password_hash($this->request->getPost('pass'), PASSWORD_BCRYPT);
        }
        if ($this->request->getPost('is_active') != '') {
            $active = 1;
        } else {
            $active = 0;
        }
        if ($this->request->getPost('is_loginable') != '') {
            $loginable = 1;
        } else {
            $loginable = 0;
        }
        $userid = $this->request->getPost('id');
        $data = [
            'user' => $this->request->getPost('username'),
            'pass' => $password,
            'ssn' => $this->request->getPost('ssn'),
            'group' => $this->request->getPost('groupnum'),
            'fullname' => $this->request->getPost('fullname'),
            'is_loginable' => $loginable,
            'is_active' => $active,
            'is_spv' => $this->request->getPost('is_spv'),
            'area' => $this->request->getPost('area'),
            'userid' => $this->request->getPost('userid'),
            'phone' => $this->request->getPost('phone'),
            'deviceid' => $this->request->getPost('deviceid'),
            'spvid' => (($this->request->getPost('spvid') != '') ? $this->request->getPost('spvid') : '0'),
            'kasacabid' => (($this->request->getPost('kasacabid') != '') ? $this->request->getPost('kasacabid') : '0'),
            'updated_date' => $date->format('Y-m-d H:i:s.u'),
            'updated_by' => session()->get('nama'),
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
        $accessgroupid = $this->request->getPost('accessgroupid');
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
