<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Models\Msmenu;
use App\Helpers\Datatables\Datatables;

class Menu extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->msmenu = new Msmenu();
    }
    public function index()
    {
        $session = session();
        $data = [
            "sidebar" => $this->msmenu->get_master_sidebar($session->get('id_user')),
            "menuside" => $this->msmenu,
        ];
        if ($session->get('id_user') == null) {
            return redirect()->to(base_url('login'));
        }
        $data['dt'] = $this->msmenu->get_master_sidebar($session->get('id_user'));
        return view('master/msmenu/V_msmenu', $data);
    }

    public function datatabel()
    {
        $datatables = Datatables::method([Msmenu::class, 'datatable'], 'searchable')
            ->setParams(1, 'kedua')
            ->make();
        //        echo db_connect()->showLastQuery();
        $datatables->updateRow(function ($db, $nomor) {
            return [
                $nomor,
                $db->master,
                $db->menuname,
                $db->menulink,
                $db->seq,
                "<i class='btn-lg " . $db->menuicon . " '></i>",
                $db->createddate,
                $db->createdby,
                $db->updateddate,
                $db->updatedby,
                $db->isactive,
                "<a type='button' class='btn btn-sm btn-warning eee' href='" . base_url('menu/EditViews/' . $db->menuid . '/' . $db->masterid . '') . "'><i class='fas fa-pencil-alt'></i></a> " .
                    " <button type='button' class='btn btn-sm btn-danger hhh' onclick=\"deleteGlobal('VMS', 'Anda yakin ingin hapus menu ?', 'modal-lg', '" . $db->menuid . "', '" . base_url('menu/deleteData') . "', '" . base_url('/menu') . "', 'Hapus')\"><i class='far fa-trash-alt'></i></button>",
            ];
        });
        $datatables->toJson();
    }
    public function FormViews($menuid = '', $masterid = 0)
    {
        $form_type = 'Add';
        if ($menuid != '') {
            $form_type = 'Edit';
        }
        $data = [
            'form_type' => $form_type,
            'row' => $this->msmenu->get_one($menuid, $masterid),
            'menuid' => $menuid
        ];

        return view('master/msmenu/V_form', $data);
    }
    public function getMaster()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $menu = $this->msmenu->getAllData($searchTerm);
        $response = array();
        foreach ($menu as $c) {
            $response[] = array("id" => $c['menuid'], "text" => $c['menuname']);
        }

        echo json_encode($response);
    }
    public function addData()
    {
        $data = [
            'masterid' => $this->request->getPost('masterid'),
            'menuname' => $this->request->getPost('menuname'),
            'menulink' => $this->request->getPost('menulink'),
            'seq' => $this->request->getPost('seq'),
            'menuicon' => $this->request->getPost('menuicon'),
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => session()->get('id_user'),
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => session()->get('id_user'),
            'isactive' => $this->request->getPost('isactive')
        ];
        $query = $this->msmenu->tambah($data);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function editData()
    {
        $data = [
            'masterid' => $this->request->getPost('masterid'),
            'menuname' => $this->request->getPost('menuname'),
            'menulink' => $this->request->getPost('menulink'),
            'seq' => $this->request->getPost('seq'),
            'menuicon' => $this->request->getPost('menuicon'),
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => session()->get('id_user'),
            'isactive' => $this->request->getPost('isactive')
        ];
        $id = $this->request->getPost('menuid');
        $query = $this->msmenu->edit($data, $id);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
    public function deleteData()
    {
        $id = $this->request->getPost('id');
        $query = $this->msmenu->hapus($id);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
