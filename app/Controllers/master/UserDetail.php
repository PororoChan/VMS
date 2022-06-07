<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Helpers\Datatables\Datatables;
use App\Models\Msaccessgroup;
use App\Models\Msaccessmenu;
use App\Models\Mscompany;
use App\Models\Msmenu;
use App\Models\Msuser;
use App\Models\MsuserDetail;
use App\Models\Msusergroup;
use DateTime;

class UserDetail extends BaseController
{
    public function __construct()
    {
        $this->userdetail = new MsuserDetail();
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
        return view('master/userdetail/V_userdetail', $data);
    }
    public function datatabel()
    {
        $datatables = Datatables::method([MsuserDetail::class, 'getAllData'], 'searchable')
            ->setParams(1, 'kedua')
            ->make();
        //        echo db_connect()->showLastQuery();
        $datatables->updateRow(function ($db, $nomor) {
            return [
                $nomor,
                $db->usercode,
                $db->fullname,
                $db->usertype,
                $db->branchname,
                "
                <button type='button' class='btn btn-sm btn-success eee' onclick=\"modalGlobal('Usergroup Setting - " . $db->usercode . "', 'modal-lg', '" . base_url('user/Accessgroup/' . $db->usercode) . "')\"><i class='fas fa-users-cog'></i></button> 
                <a class='btn btn-sm btn-warning eee' href='" . base_url('userdetail/EditViews/' . $db->usercode . '') . "'><i class='fas fa-pencil-alt'></i></a> " .
                    " <button type='button' class='btn btn-sm btn-danger hhh' onclick=\"deleteGlobal('VMS', 'Are you sure want to delete this user ?', 'modal-lg', '" . $db->usercode . "', '" . base_url('userdetail/deleteData') . "', '" . base_url('/user') . "', 'Delete')\"><i class='far fa-trash-alt'></i></button>",
            ];
        });
        $datatables->toJson();
    }

    public function getUser()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $comp = $this->userdetail->getSel2($searchTerm);
        $response = array();
        foreach ($comp as $c) {
            $response[] = array("id" => $c['usercode'], "text" => $c['fullname']);
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
            'row' => $this->userdetail->get_one($id),
            'usercode' => $id
        ];

        return view('master/userdetail/V_form', $data);
    }
    public function addData()
    {
        $data = [
            'usercode' => $this->request->getPost('usercode'),
            'fullname' => $this->request->getPost('fullname'),
            'usertype' => $this->request->getPost('usertype'),
            'branchid' => $this->request->getPost('branch'),
            'activedate' => $this->request->getPost('activedate'),
            'isactive' => 1,
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => session()->get('nama'),
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => session()->get('nama'),
        ];
        $query = $this->userdetail->tambah($data);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function editData()
    {
        if ($this->request->getPost('isactive') == '') {
            $active = 0;
        } else if ($this->request->getPost('isactive') == '1') {
            $active = 1;
        }
        $userid = $this->request->getPost('usercode-old');
        $data = [
            'usercode' => $this->request->getPost('usercode'),
            'fullname' => $this->request->getPost('fullname'),
            'usertype' => $this->request->getPost('usertype'),
            'branchid' => $this->request->getPost('branch'),
            'activedate' => $this->request->getPost('activedate'),
            'isactive' => $active,
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => session()->get('nama'),
        ];
        $query = $this->userdetail->edit($data, $userid);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function deleteData()
    {
        $id = $this->request->getPost('id');
        $query = $this->userdetail->hapus($id);
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
