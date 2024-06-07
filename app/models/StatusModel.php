<?php
class StatusModel
{
	private $table = 'kode_status_peminjaman';
	private $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getAll()
	{
		$this->db->query('SELECT * FROM ' . $this->table);
		$row = $this->db->resultSet();

		return $row;
	}
}
