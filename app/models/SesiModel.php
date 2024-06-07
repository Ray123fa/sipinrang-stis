<?php
class SesiModel
{
	protected $table = 'daftar_sesi_peminjaman';
	protected $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getAll()
	{
		$this->db->query('SELECT * FROM ' . $this->table);
		$rows = $this->db->resultSet();

		return $rows;
	}
}
