<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Helpers\Datatables\Datatables;
use App\Models\Msconversion;

class Conversion extends BaseController
{
	public function __construct()
	{
		helper('form');
		$this->conv = new Msconversion();
	}

	public function index()
	{
		if (session()->get('id_user') == null) {
			return redirect()->to('login');
		}

		return view('master/convers/V_convers');
	}

	public function datatabel()
	{
		$datatables = Datatables::method([Msconversion::class, 'getAll'], 'searchable')
			->setParams(1, 'kedua')
			->make();

		$datatables->updateRow(function ($db, $no) {
			return [
				$no,
				$db->productcode,
				$db->productname,
				$db->converter,
				"<a class='btn btn-sm btn-warning' href='" . base_url('convers/EditViews/' . $db->productcode . '') . "'><i class='fas fa-pencil-alt'></i></a> 
					<button type='button' class='btn btn-sm btn-danger' onclick=\"deleteGlobal('VMS', 'Are you sure want to delete this item ?', 'modal-md', '" . $db->id . "', '" . base_url('convers/deleteData') . "', '" . base_url('convers') . "', 'Delete')\"><i class='fas fa-trash-alt'></i></button>"
			];
		});

		$datatables->toJson();
	}

	public function FormViews($id = '')
	{
		$ftype = 'Add';
		if ($id != '') {
			$ftype = 'Edit';
		}

		$data = [
			'form_type' => $ftype,
			'row' => $this->conv->getOne($id),
			'id' => $id,
		];

		return view('master/convers/V_form', $data);
	}

	public function addData()
	{
		$pcode = $this->request->getPost('productcode');

		$validation = \Config\Services::validation();

		$valid = $this->validate([
			'productcode' => [
				'rules' => 'required|is_unique[msconversions.productcode]',
				'label' => 'Product Code',
				'errors' => [
					'required' => '{field} cannot be empty',
					'is_unique' => '{field} already exist'
				]
			]
		]);

		if (!$valid) {
			$msg = [
				'error' => [
					'errorCode' => $validation->getError('productcode'),
				],
			];
		} else {
			$data = [
				'productcode' => $pcode,
				'productname' => $this->request->getPost('productname'),
				'converter' => $this->request->getPost('converter'),
			];

			$this->conv->tambah($data);
			$msg['success'] = 1;
		}
		echo json_encode($msg);
	}

	public function editData()
	{
		$id = $this->request->getPost('productid');
		$pcode = $this->request->getPost('productcode');
		$pname = $this->request->getPost('productname');
		$converter = $this->request->getPost('converter');

		$validation = \Config\Services::validation();

		$valid = $this->validate([
			'productcode' => [
				'rules' => 'required',
				'label' => 'Product Code',
				'errors' => [
					'required' => "{field} cannot be empty"
				],
			],
			'productname' => [
				'rules' => 'required',
				'label' => 'Product Name',
				'errors' => [
					'required' => "{field} cannot be empty"
				],
			],
		]);

		if (!$valid) {
			$msg = [
				'error' => [
					'errorCode' => $validation->getError('productcode'),
					'errorName' => $validation->getError('productname'),
				]
			];
		} else {
			$data = [
				'productcode' => $pcode,
				'productname' => $pname,
				'converter' => $converter,
			];

			$this->conv->edit($data, $id);
			$msg['success'] = 1;
		}

		echo json_encode($msg);
	}

	public function deleteData()
	{
		$id = $this->request->getPost('id');

		if ($id != '') {
			$this->conv->hapus($id);
			echo 1;
		} else {
			echo 0;
		}
	}
}
