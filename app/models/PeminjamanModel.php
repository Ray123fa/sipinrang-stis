<?php
class PeminjamanModel
{
	protected $table = 'peminjaman';
	protected $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	// Semua Peminjaman
	public function getAll()
	{
		$this->db->query('SELECT * FROM ' . $this->table);
		$rows = $this->db->resultSet();

		return $rows;
	}

	public function countAll()
	{
		return count($this->getAll());
	}

	public function getAllByLimit($startAt, $limit)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' LIMIT :startAt, :limit');
		$this->db->bind('startAt', $startAt);
		$this->db->bind('limit', $limit);
		$rows = $this->db->resultSet();

		return $rows;
	}

	public function countSearchAllPeminjaman($search)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE unit LIKE :search OR kegiatan LIKE :search OR ruang LIKE :search');
		$this->db->bind(':search', "%$search%");
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function searchAllPeminjaman($search, $startAt, $limit)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE unit LIKE :search OR kegiatan LIKE :search OR ruang LIKE :search LIMIT :startAt, :limit');
		$this->db->bind(':search', "%$search%");
		$this->db->bind(':startAt', $startAt);
		$this->db->bind(':limit', $limit);
		$rows = $this->db->resultSet();

		return $rows;
	}

	// Peminjaman Saya
	public function getMyPeminjaman($unit)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE unit = :unit');
		$this->db->bind(':unit', $unit);
		$rows = $this->db->resultSet();

		return $rows;
	}

	public function countMyPeminjaman($unit)
	{
		return count($this->getMyPeminjaman($unit));
	}

	public function getMyPeminjamanByLimit($startAt, $limit, $unit)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE unit = :unit LIMIT :startAt, :limit');
		$this->db->bind(':unit', $unit);
		$this->db->bind(':startAt', $startAt);
		$this->db->bind(':limit', $limit);
		$rows = $this->db->resultSet();

		return $rows;
	}

	public function countSearchMyPeminjaman($search, $unit)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE (kegiatan LIKE :search OR ruang LIKE :search) AND unit = :unit');
		$this->db->bind(':search', "%$search%");
		$this->db->bind(':unit', $unit);
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function searchMyPeminjaman($search, $startAt, $limit, $unit)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE (kegiatan LIKE :search OR ruang LIKE :search) AND unit = :unit LIMIT :startAt, :limit');
		$this->db->bind(':search', "%$search%");
		$this->db->bind(':unit', $unit);
		$this->db->bind(':startAt', $startAt);
		$this->db->bind(':limit', $limit);
		$rows = $this->db->resultSet();

		return $rows;
	}

	// Detail Peminjaman
	public function getPeminjamanByIDPinjam($id_pinjam)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_pinjam = :id_pinjam');
		$this->db->bind(':id_pinjam', $id_pinjam);
		$row = $this->db->single();

		return $row;
	}
}
