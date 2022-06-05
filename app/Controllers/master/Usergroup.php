<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Models\Msusergroup;
use App\Helpers\Datatables\Datatables;
use App\Models\Msaccessmenu;
use App\Models\Mscomponent;
use App\Models\Msmenu;

class Usergroup extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->group = new Msusergroup();
        $this->menu = new Msmenu();
        $this->component = new Mscomponent();
        $this->accessmenu = new Msaccessmenu();
    }
    public function index()
    {
        $data = [
            "sidebar" => $this->menu->get_master_sidebar(session()->get('id_user')),
            "menuside" => $this->menu,
        ];
        if (session()->get('id_user') == null) {
            return redirect()->to(base_url('login'));
        }

        return view('master/usergroup/V_usergroup', $data);
    }
    public function datatabel()
    {
        $datatables = Datatables::method([Msusergroup::class, 'getAllData'], 'searchable')
            ->setParams(1, 'kedua')
            ->make();
        //        echo db_connect()->showLastQuery();
        $datatables->updateRow(function ($db, $nomor) {
            return [
                $nomor,
                $db->groupname,
                $db->createddate,
                $db->createdby,
                $db->updateddate,
                $db->updatedby,
                $db->isactive,
                " <button type='button' class='btn btn-sm btn-success eee' onclick=\"modalGlobal('Akses Usergroup - " . $db->groupname . "', 'modal-xl', '" . base_url('usergroup/AccessViews/' . $db->groupid) . "')\"><i class='fas fa-user-cog'></i></button> " .
                    " <a class='btn btn-sm btn-warning eee' href='" . base_url('usergroup/EditViews/' . $db->groupid . '') . "'><i class='fas fa-pencil-alt'></i></a> " .
                    " <button type='button' class='btn btn-sm btn-danger hhh' onclick=\"deleteGlobal('VMS', 'Anda yakin ingin hapus usergroup ?', 'modal-md', '" . $db->groupid . "', '" . base_url('usergroup/deleteData') . "', '" . base_url('/usergroup') . "', 'Hapus')\"><i class='far fa-trash-alt'></i></button>",
            ];
        });
        $datatables->toJson();
    }
    public function FormViews($groupid = '')
    {
        $form_type = 'Add';
        if ($groupid != '') {
            $form_type = 'Edit';
        }
        $data = [
            'form_type' => $form_type,
            'row' => $this->group->get_one($groupid),
            'groupid' => $groupid
        ];

        return view('master/usergroup/v_form', $data);
    }
    // public function sidebar1($id_menu)
    // {
    //     echo "<li class='nav-item dropdown'>";
    //     if ($this->menu->checkMenu($id_menu)->countAllResults() > 0) {
    //     } else {
    //     }
    //     echo "</li>";
    // }
    public function addData()
    {
        $data = [
            'groupname' => $this->request->getPost('groupname'),
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => session()->get('id_user'),
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => session()->get('id_user'),
            'isactive' => $this->request->getPost('isactive')
        ];
        $query = $this->group->tambah($data);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function AccessViews($groupid)
    {
        $data = [
            "groupid" => $groupid,
            "menu" => $this->menu->get_master(),
            "msmenu" => $this->menu,
            "accessmenu" => $this->accessmenu,
            "component" => $this->component->getAllData(1, "text")->get()->getResultArray(),
        ];
        $tes['view'] = view('master/usergroup/V_access_form', $data);
        echo json_encode($tes);
    }
    public function editData()
    {
        $groupid = $this->request->getPost('groupid');
        $data = [
            'groupname' => $this->request->getPost('groupname'),
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => session()->get('id_user'),
            'isactive' => $this->request->getPost('isactive')
        ];
        $query = $this->group->edit($data, $groupid);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function accessData()
    {
        $groupid = $this->request->getPost('usergroupid');
        $akses = $this->request->getPost('access_input');
        $deleteQuery = $this->accessmenu->deleteUsergroup($groupid);
        if ($deleteQuery) {
            foreach ($akses as $key) {
                $dest = explode(", ", $key);
                $menuid = $dest[0];
                $componentid = $dest[1];
                $data = [
                    "usergroupid" => $groupid,
                    "menuid" => $menuid,
                    "componentid" => $componentid,
                    "createdby" => session()->get('id_user'),
                    "createddate" => date('Y-m-d H:i:s'),
                    "updatedby" => session()->get('id_user'),
                    "updateddate" => date('Y-m-d H:i:s'),
                ];
                $this->accessmenu->addAccess($data);
            }
            echo 1;
        } else {
            echo 0;
        }
    }
    public function deleteData()
    {
        $groupid = $this->request->getPost('id');
        $query = $this->group->hapus($groupid);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
