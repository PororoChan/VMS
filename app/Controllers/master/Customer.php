<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Helpers\Datatables\Datatables;
use App\Models\Msaccessgroup;
use App\Models\Msmenu;
use App\Models\Mscustomer;
use App\Models\Msusergroup;

class Customer extends BaseController
{
    public function __construct()
    {
        $this->customer = new Mscustomer();
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
        return view('master/customer/V_customer', $data);
    }
    public function datatabel($branchid = '')
    {
        $datatables = Datatables::method([Mscustomer::class, 'getAllData'], 'searchable')
            ->setParams($branchid)
            ->make();
        //        echo db_connect()->showLastQuery();
        $datatables->updateRow(function ($db, $nomor) {
            return [
                $nomor,
                $db->custcode,
                $db->custname,
                $db->custtype,
                $db->custaddress,
                $db->custemail,
                $db->custphone,
                $db->branchid,
                "
                <button type='button' class='btn btn-sm btn-warning eee' onclick=\"modalGlobal('Edit Data Customer', 'modal-lg', '" . base_url('customer/EditViews/' . $db->custcode) . "')\"><i class='fas fa-pencil-alt'></i></button> " .
                    " <button type='button' class='btn btn-sm btn-danger hhh' onclick=\"deleteGlobal('Hapus Data Customer', 'modal-lg', '" . $db->custcode . "', '" . base_url('customer/deleteData') . "', '" . base_url('/customer') . "')\"><i class='far fa-trash-alt'></i></button>",
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

    public function FormViews($id = '')
    {
        $form_type = 'add';
        if ($id != '') {
            $form_type = 'edit';
        }
        $data = [
            'form_type' => $form_type,
            'row' => $this->customer->get_one($id),
            'custcode' => $id
        ];
        $tes['view'] = view('master/customer/V_form', $data);
        echo json_encode($tes);
    }
    public function getCustomer()
    {
        $searchTerm = $this->request->getPost('searchTerm');
        $comp = $this->customer->getSel2($searchTerm);
        $response = array();
        foreach ($comp as $c) {
            $response[] = array("id" => $c['custcode'], "text" => $c['custname']);
        }
        echo json_encode($response);
    }
    public function addData()
    {
        $validation =  \Config\Services::validation();

        $valid = $this->validate([
            'custcode'
            => [
                'rules' => 'required|is_unique[vmsmscustomer.custcode]',
                'label' => 'Customer code',
                'errors' => [
                    'required' => "{field} cant null",
                    'is_unique' => "{field} Cant be same"
                ]
            ],
            'custemail'
            => [
                'rules' => 'required|is_unique[vmsmscustomer.custemail]',
                'label' => 'Customer Email',
                'errors' => [
                    'required' => "{field} cant null",
                    'is_unique' => "{field} Cant be same"

                ]
            ],
        ]);
        if (!$valid) {
            $msg = [
                'error' => [
                    'errorName' => $validation->getError('custcode'),
                    'errorEmail' => $validation->getError('custemail')
                ]
            ];
        } else {
            $data = [
                'custcode' => $this->request->getPost('custcode'),
                'custname' => $this->request->getPost('custname'),
                'custtype' => $this->request->getPost('custtype'),
                'custaddress' => $this->request->getPost('custaddress'),
                'custemail' => $this->request->getPost('custemail'),
                'custphone' => $this->request->getPost('custphone'),
                'branchid' => $this->request->getPost('branchid'),
                'isactive' => $this->request->getPost('isactive'),
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => session()->get('nama'),
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => session()->get('nama'),
            ];
            $this->customer->tambah($data);
            $msg['success'] = '1';
        }
        echo json_encode($msg);
    }

    public function editData()
    {
        $userid = $this->request->getPost('custcode');
        $custdule = $this->request->getPost('custcode');
        $code_lama = $this->request->getPost('code_lama');

        $rule_code = [
            'rules' => 'required|is_unique[vmsmscustomer.custcode]',
            'label' => 'Customer code',
            'errors' => [
                'required' => "{field} cant null",
                'is_unique' => "{field} Cant be same"
            ]
        ];
        if ($custdule == $code_lama) {
            $rule_code = [
                'rules' => 'required',
                'label' => 'Customer code',
                'errors' => [
                    'required' => "{field} cant null",
                ]
            ];
        }
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'schecode' => $rule_code,
            'custname' => [
                'rules' => 'required',
                'label' => 'customer name',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ]
            ],
        ]);
        if (!$valid) {
            $msg =  [
                'error' => [
                    'errorName' => $validation->getError('custcode'),
                    'errorCust' => $validation->getError('custname'),
                ]
            ];
        } else {
            $data = [
                'custcode' => $this->request->getPost('custcode'),
                'custname' => $this->request->getPost('custname'),
                'custtype' => $this->request->getPost('custtype'),
                'custaddress' => $this->request->getPost('custaddress'),
                'custemail' => $this->request->getPost('custemail'),
                'custphone' => $this->request->getPost('custphone'),
                'branchid' => $this->request->getPost('branchid'),
                'isactive' => $this->request->getPost('isactive'),
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => session()->get('nama'),
            ];
            $this->customer->edit($data, $userid);
            $msg['success'] = '1';
        }
        echo json_encode($msg);
    }

    public function deleteData()
    {
        $id = $this->request->getPost('id');
        $query = $this->customer->hapus($id);
        if ($query) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
