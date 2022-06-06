<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Helpers\Datatables\Datatables;
use App\Models\Msaccessgroup;
use App\Models\Msmenu;
use App\Models\Msbranch;
use App\Models\Msusergroup;
use DateTime;

class Branch extends BaseController
{
    public function __construct()
    {
        $this->branch = new Msbranch();
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
        return view('master/branch/V_branch', $data);
    }
    public function datatabel()
    {
        $datatables = Datatables::method([Msbranch::class, 'getAllData'], 'searchable')
            ->setParams(1, 'kedua')
            ->make();
        //        echo db_connect()->showLastQuery();
        $datatables->updateRow(function ($db, $nomor) {
            return [
                $nomor,
                $db->branchcode,
                $db->branchname,
                $db->areacode,
                $db->aliascode,
                $db->kasacabid,
                "
                <a class='btn btn-sm btn-warning eee' href='" . base_url('branch/EditViews/' . $db->branchid . '') . "'><i class='fas fa-pencil-alt'></i></a> " .
                    " <button type='button' class='btn btn-sm btn-danger hhh' onclick=\"deleteGlobal('VMS', 'Anda yakin ingin hapus branch ini ?', 'modal-lg', '" . $db->branchid . "', '" . base_url('branch/deleteData') . "', '" . base_url('/branch') . "', 'Hapus')\"><i class='far fa-trash-alt'></i></button>",
            ];
        });
        $datatables->toJson();
    }

    public function getBranch()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $comp = $this->branch->getSel2($searchTerm);
        $response = array();
        foreach ($comp as $c) {
            $response[] = array("id" => $c['branchcode'], "text" => $c['branchname']);
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
            'row' => $this->branch->get_one($id),
            'branchid' => $id
        ];

        return view('master/branch/V_form', $data);
    }
    public function addData()
    {
        $date = new DateTime('NOW');
        $branch = $this->request->getPost('branchcode');
        $validation =  \Config\Services::validation();

        $valid = $this->validate([
            'branchcode' => [
                'rules' => 'required|is_unique[vmsmsbranch.branchcode]',
                'label' => 'Branchcode',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                    'is_unique' => "{field} sudah ada"
                ]
            ],
        ]);
        if (!$valid) {
            $msg = [
                'error' => [
                    'errorName' => $validation->getError('branchcode')
                ]
            ];
        } else {
            $data = [
                'branchcode' => $branch,
                'branchname' => $this->request->getPost('branchname'),
                'areacode' => $this->request->getPost('areacode'),
                'aliascode' => $this->request->getPost('aliascode'),
                'isactive' => 1,
                'kasacabid' => $this->request->getPost('kasacabid'),
                'createddate' => $date->format('Y-m-d H:i:s.u'),
                'createdby' => session()->get('nama'),
                'updateddate' => $date->format('Y-m-d H:i:s.u'),
                'updatedby' => session()->get('nama'),
            ];
            $this->branch->tambah($data);
            $msg['success'] = '1';
        }
        echo json_encode($msg);
    }

    public function editData()
    {
        $date = new DateTime('NOW');
        $branchid = $this->request->getPost('branchid');
        $branchcode = $this->request->getPost('branchcode');
        $code_lama = $this->request->getPost('code_lama');

        $rule_code = [
            'rules' => 'required|is_unique[vmsmsbranch.branchcode]',
            'label' => 'Branchcode',
            'errors' => [
                'required' => "{field} tidak boleh kosong",
                'is_unique' => "{field} sudah ada"
            ]
        ];
        if ($branchcode == $code_lama) {
            $rule_code = [
                'rules' => 'required',
                'label' => 'Branchcode',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ]
            ];
        }
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'branchcode' => $rule_code,
            'branchname' => [
                'rules' => 'required',
                'label' => 'Branchname',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ]
            ],
        ]);
        if (!$valid) {
            $msg =  [
                'error' => [
                    'errorName' => $validation->getError('branchcode'),
                    'errorBranch' => $validation->getError('branchname'),
                ]
            ];
        } else {
            $data = [
                'branchcode' => $branchcode,
                'branchname' => $this->request->getPost('branchname'),
                'areacode' => $this->request->getPost('areacode'),
                'aliascode' => $this->request->getPost('aliascode'),
                'kasacabid' => $this->request->getPost('kasacabid'),
                'isactive' => $this->request->getPost('isactive'),
                'updateddate' => $date->format('Y-m-d H:i:s.u'),
                'updatedby' => session()->get('nama'),
            ];
            $this->branch->edit($data, $branchid);
            $msg['success'] = '1';
        }
        echo json_encode($msg);
    }

    public function deleteData()
    {
        $id = $this->request->getPost('id');
        $query = $this->branch->hapus($id);
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
