<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Helpers\Datatables\Datatables;
use App\Models\Msaccessgroup;
use App\Models\Msaccessmenu;
use App\Models\Mscompany;
use App\Models\Msmenu;
use App\Models\Msalias;
use App\Models\Msuser;
use App\Models\MsuserDetail;
use App\Models\Msusergroup;
use CodeIgniter\Validation\Rules;
use CodeIgniter\Validation\Validation;

class Alias extends BaseController
{
    public function __construct()
    {
        $this->alias = new Msalias();
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
        return view('master/alias/V_alias', $data);
    }
    public function datatabel()
    {
        $datatables = Datatables::method([Msalias::class, 'getAllData'], 'searchable')
            ->setParams(1, 'kedua')
            ->make();
        //        echo db_connect()->showLastQuery();
        $datatables->updateRow(function ($db, $nomor) {
            return [
                $nomor,
                $db->aliascode,
                $db->aliasname,
                "
                <button type='button' class='btn btn-sm btn-warning eee' onclick=\"modalGlobal('Edit Data Alias', 'modal-lg', '" . base_url('alias/EditViews/' . $db->aliasid) . "')\"><i class='fas fa-pencil-alt'></i></button> " .
                    " <button type='button' class='btn btn-sm btn-danger hhh' onclick=\"deleteGlobal('Hapus User', 'modal-lg', '" . $db->aliasid . "', '" . base_url('alias/deleteData') . "', '" . base_url('/alias') . "')\"><i class='far fa-trash-alt'></i></button>",
            ];
        });
        $datatables->toJson();
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
    public function getAlias()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $comp = $this->alias->getSel2($searchTerm);
        $response = array();
        foreach ($comp as $c) {
            $response[] = array("id" => $c['aliascode'], "text" => $c['aliascode']);
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
            'row' => $this->alias->get_one($id),
            'aliascode' => $id
        ];
        $tes['view'] = view('master/alias/V_form', $data);
        echo json_encode($tes);
    }
    public function addData()
    {
        $aliascode = $this->request->getPost('aliascode');
        $validation =  \Config\Services::validation();

        $valid = $this->validate([
            'aliascode' => [
                'rules' => 'required|is_unique[vmsmsaliascode.aliascode]',
                'label' => 'Aliascode',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                    'is_unique' => "{field} sudah ada"
                ]
            ],
        ]);
        if (!$valid) {
            $msg = [
                'error' => [
                    'errorName' => $validation->getError('aliascode')
                ]
            ];
        } else {
            $data = [
                'aliascode' => $aliascode,
                'aliasname' => $this->request->getPost('aliasname'),
                'isactive' => $this->request->getPost('isactive'),
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => session()->get('nama'),
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => session()->get('nama'),
            ];
            $this->alias->tambah($data);
            $msg['success'] = '1';
        }
        echo json_encode($msg);
    }

    public function editData()
    {
        $aliasid = $this->request->getPost('aliasid');
        $aliascode = $this->request->getPost('aliascode');
        $code_lama = $this->request->getPost('code_lama');
        $aliasname = $this->request->getPost('aliasname');
        $isactive = $this->request->getPost('isactive');

        $rule_code = [
            'rules' => 'required|is_unique[vmsmsaliascode.aliascode]',
            'label' => 'Aliascode',
            'errors' => [
                'required' => "{field} tidak boleh kosong",
                'is_unique' => "{field} sudah ada"
            ]
        ];
        if ($aliascode == $code_lama) {
            $rule_code = [
                'rules' => 'required',
                'label' => 'Aliascode',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ]
            ];
        }
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'aliascode' => $rule_code,
            'aliasname' => [
                'rules' => 'required',
                'label' => 'Aliasname',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ]
            ],
        ]);
        if (!$valid) {
            $msg =  [
                'error' => [
                    'errorName' => $validation->getError('aliascode'),
                    'errorAlias' => $validation->getError('aliasname'),
                ]
            ];
        } else {
            $data = [
                'aliascode' => $aliascode,
                'aliasname' => $aliasname,
                'isactive' => $isactive,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => session()->get('nama'),
            ];
            $this->alias->edit($data, $aliasid);
            $msg['success'] = '1';
        }
        echo json_encode($msg);
    }

    public function deleteData()
    {
        $id = $this->request->getPost('id');
        $query = $this->alias->hapus($id);
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
