<?php

namespace App\Models;

use CodeIgniter\Model;

class Msbrand extends Model
{
	protected $table = 'linkitembrand as b';

	public function __construct()
	{
		$this->db = db_connect();
		$this->builder = $this->db->table($this->table);
	}

	public function searchable()
	{
		return [
			'b.itemno',
			null,
			'b.brand',
			null,
			null,
			null,
			null,
			null,
			null,
		];
	}

	public function getAll($param, $text)
	{
		return $this->builder
			->orderBy('b.itemno', 'asc');
	}

	public function getOne($id = '')
	{
		return $this->builder
			->where('itemno', $id)->get()->getRowArray();
	}

	public function tambah($data)
	{
		return $this->builder->insert($data);
	}

	public function edit($data, $id)
	{
		return $this->builder->update($data, ['itemno' => $id]);
	}

	public function hapus($item)
	{
		return $this->builder->delete(['itemno' => $item]);
	}
}
