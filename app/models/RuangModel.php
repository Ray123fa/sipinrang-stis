<?php
class RuangModel
{
	protected $table = 'ruang';
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

	public function getAvailRuang($tgl, $sesi)
	{
		$this->db->query('SELECT ruang FROM ' . $this->table . ' WHERE ruang NOT IN (SELECT ruang FROM peminjaman WHERE diperlukan_tanggal = :tgl AND sesi = :sesi)');
		$this->db->bind('tgl', $tgl);
		$this->db->bind('sesi', $sesi);
		$rows = $this->db->resultSet();

		return $rows;
	}
}
