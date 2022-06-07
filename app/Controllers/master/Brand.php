<?php

namespace App\Controllers\master;

use App\Controllers\BaseController;
use App\Helpers\Datatables\Datatables;
use App\Models\Msbrand;

class Brand extends BaseController
{
	public function __construct()
	{
		helper('form');
		$this->msbrand = new Msbrand();
	}
	public function index()
	{
		$session = session();

		if ($session->get('id_user') == null) {
			return redirect()->to('login');
		}

		return view('master/brand/V_msbrand');
	}

	public function datatabel()
	{
		$datatables = Datatables::method([Msbrand::class, 'getAll'], 'searchable')
			->setParams(1, 'kedua')
			->make();

		$datatables->updateRow(function ($db, $no) {
			return [
				$no,
				$db->itemno,
				$db->itemdesc,
				$db->brand,
				$db->bfbig,
				$db->bf,
				$db->bf2,
				$db->bf3,
				$db->cartypename,
				$db->cartypename2,
				"<a class='btn btn-sm btn-warning' href='" . base_url('brand/EditViews/' . $db->itemno . '') . "'><i class='fas fa-pen-alt'></i></a>" .
					"<button class='btn btn-sm btn-danger' onclick=\"deleteGlobal('VMS', 'Are you sure want to delete this brand ?', 'modal-md', '" . $db->itemno . "', '" . base_url('brand/deleteBrand') . "', '" . base_url('brand') . "', 'Delete')\"><i class='fas fa-trash-alt'></i></button>",
			];
		});

		$datatables->toJson();
	}

	public function FormViews($item = '')
	{
		$form_type = 'Add';
		if ($item != '') {
			$form_type = 'Edit';
		}

		$data = [
			'form_type' => $form_type,
			'row' => $this->msbrand->getOne($item),
			'itemno' => $item,
		];

		return view('master/brand/V_form', $data);
	}

	public function addBrand()
	{
		$data = [
			'itemno' => $this->request->getPost('itemno'),
			'itemdesc' => $this->request->getPost('itemdesc'),
			'brand' => $this->request->getPost('brand'),
			'bfbig' => $this->request->getPost('bfbig'),
			'bf' => $this->request->getPost('bf'),
			'bf2' => $this->request->getPost('bf2'),
			'bf3' => $this->request->getPost('bf3'),
			'cartypename' => $this->request->getPost('cartype'),
			'cartypename2' => $this->request->getPost('cartype2'),
		];

		$insert = $this->msbrand->tambah($data);
		if ($insert) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function editBrand()
	{
		$itemid = $this->request->getPost('itemno');

		$data = [
			'itemno' => $this->request->getPost('itemno'),
			'itemdesc' => $this->request->getPost('itemdesc'),
			'brand' => $this->request->getPost('brand'),
			'bfbig' => $this->request->getPost('bfbig'),
			'bf' => $this->request->getPost('bf'),
			'bf2' => $this->request->getPost('bf2'),
			'bf3' => $this->request->getPost('bf3'),
			'cartypename' => $this->request->getPost('cartype'),
			'cartypename2' => $this->request->getPost('cartype2'),
		];

		if ($itemid != '') {
			$this->msbrand->edit($data, $itemid);
			echo 1;
		} else {
			echo 0;
		}
	}

	public function deleteBrand()
	{
		$item = $this->request->getPost('id');

		if ($item != '') {
			$this->msbrand->hapus($item);
			echo 1;
		} else {
			echo 0;
		}
	}
}
