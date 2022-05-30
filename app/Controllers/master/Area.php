<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Helpers\Datatables\Datatables;
use App\Models\Msaccessgroup;
use App\Models\Msaccessmenu;
use App\Models\Mscompany;
use App\Models\Msmenu;
use App\Models\Msarea;
use App\Models\Msuser;
use App\Models\MsuserDetail;
use App\Models\Msusergroup;

class Area extends BaseController
{
    public function __construct()
    {
        $this->area = new Msarea();
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
        return view('master/area/V_area', $data);
    }
    public function datatabel()
    {
        $datatables = Datatables::method([Msarea::class, 'getAllData'], 'searchable')
            ->setParams(1, 'kedua')
            ->make();
        //        echo db_connect()->showLastQuery();
        $datatables->updateRow(function ($db, $nomor) {
            return [
                $nomor,
                $db->areacode,
                $db->areaname,
                "
                <button type='button' class='btn btn-sm btn-warning eee' onclick=\"modalGlobal('Edit Data Area', 'modal-lg', '" . base_url('area/EditViews/' . $db->areaid) . "')\"><i class='fas fa-pencil-alt'></i></button> " .
                    " <button type='button' class='btn btn-sm btn-danger hhh' onclick=\"deleteGlobal('Hapus Data Area', 'modal-lg', '" . $db->areaid . "', '" . base_url('area/deleteData') . "', '" . base_url('/area') . "')\"><i class='far fa-trash-alt'></i></button>",
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
    public function getArea()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $comp = $this->area->getSel2($searchTerm);
        $response = array();
        foreach ($comp as $c) {
            $response[] = array("id" => $c['areacode'], "text" => $c['areacode']);
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
            'row' => $this->area->get_one($id),
            'areaid' => $id
        ];
        $tes['view'] = view('master/area/V_form', $data);
        echo json_encode($tes);
    }
    public function addData()
    {
        $areacode = $this->request->getPost('areacode');
        $validation =  \Config\Services::validation();

        $valid = $this->validate([
            'areacode' => [
                'rules' => 'required|is_unique[vmsmsareacode.areacode]',
                'label' => 'Areacode',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                    'is_unique' => "{field} sudah ada"
                ]
            ],
        ]);
        if (!$valid) {
            $msg = [
                'error' => [
                    'errorName' => $validation->getError('areacode')
                ]
            ];
        } else {
            $data = [
                'areacode' => $areacode,
                'areaname' => $this->request->getPost('areaname'),
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
        $userid = $this->request->getPost('areaid');
        $data = [
            'areacode' => $this->request->getPost('areacode'),
            'areaname' => $this->request->getPost('areaname'),
            'isactive' => $this->request->getPost('isactive'),
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => session()->get('nama'),
        ];
        $query = $this->area->edit($data, $userid);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function deleteData()
    {
        $id = $this->request->getPost('id');
        $query = $this->area->hapus($id);
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
