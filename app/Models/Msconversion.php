<?php

namespace App\Models;

use CodeIgniter\Model;

class Msconversion extends Model
{
	protected $table = 'msconversions as c';
	public function __construct()
	{
		$this->db = db_connect();
		$this->builder = $this->db->table($this->table);
	}

	public function searchable()
	{
		return [
			'c.productcode',
			'c.productname',
			null,
			null,
		];
	}

	public function getAll($param, $text)
	{
		return $this->builder;
	}

	public function getOne($id = '')
	{
		return $this->builder
			->where('productcode', $id)->get()->getRowArray();
	}

	public function tambah($data)
	{
		return $this->builder->insert($data);
	}

	public function edit($data, $id)
	{
		return $this->builder->update($data, ['id' => $id]);
	}

	public function hapus($id)
	{
		return $this->builder->delete(['id' => $id]);
	}
}
