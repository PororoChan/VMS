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
				"<button class='btn btn-sm btn-warning'><i class='fas fa-pencil-alt'></i></button> 
					<button class='btn btn-sm btn-danger'><i class='fas fa-trash-alt'></i></button>"
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
	}
}
