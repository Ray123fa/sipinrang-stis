<?php

class PeminjamanModel
{
	protected $table = 'peminjaman';
	protected $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	// Generate ID Peminjaman
	public function generateId($l = 5)
	{
		$str = "";
		$characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
		$max = count($characters) - 1;

		for ($i = 0; $i < $l; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}

		$this->db->query("SELECT * FROM " . $this->table . " WHERE id_pinjam = :id_pinjam");
		$this->db->bind(':id_pinjam', (string) $str);
		$this->db->execute();

		if ($this->db->rowCount() > 0) {
			return $this->generateId();
		}

		return $str;
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

	public function countAllByStatus($status)
	{
		$this->db->query("SELECT * FROM " . $this->table . " WHERE status = :status");
		$this->db->bind(':status', $status);
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getAllByLimit($startAt, $limit, $status)
	{
		if ($status == -1) {
			$this->db->query("SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT :startAt, :limit");
		} else {
			$this->db->query("SELECT * FROM " . $this->table . " WHERE status = :status ORDER BY id DESC LIMIT :startAt, :limit");
			$this->db->bind(':status', $status);
		}
		$this->db->bind('startAt', $startAt);
		$this->db->bind('limit', $limit);
		$rows = $this->db->resultSet();

		return $rows;
	}

	public function countSearchAllPeminjaman($search, $status)
	{
		if ($status == -1) {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE unit LIKE :search OR kegiatan LIKE :search OR ruang LIKE :search');
		} else {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE (unit LIKE :search OR kegiatan LIKE :search OR ruang LIKE :search) AND status = :status');
			$this->db->bind(':status', $status);
		}
		$this->db->bind(':search', "%$search%");
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function searchAllPeminjaman($search, $startAt, $limit, $status)
	{
		if ($status == -1) {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE unit LIKE :search OR kegiatan LIKE :search OR ruang LIKE :search ORDER BY id DESC LIMIT :startAt, :limit');
		} else {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE (unit LIKE :search OR kegiatan LIKE :search OR ruang LIKE :search) AND status = :status ORDER BY id DESC LIMIT :startAt, :limit');
			$this->db->bind(':status', $status);
		}
		$this->db->bind(':search', "%$search%");
		$this->db->bind(':startAt', $startAt);
		$this->db->bind(':limit', $limit);
		$rows = $this->db->resultSet();

		return $rows;
	}

	// Peminjaman Saya
	public function getMyPeminjaman($unit, $status)
	{
		if ($status == -1) {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE unit = :unit');
		} else {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE unit = :unit AND status = :status');
			$this->db->bind(':status', $status);
		}
		$this->db->bind(':unit', $unit);
		$rows = $this->db->resultSet();

		return $rows;
	}

	public function countMyPeminjaman($unit, $status)
	{
		return count($this->getMyPeminjaman($unit, $status));
	}

	public function getMyPeminjamanByLimit($startAt, $limit, $unit, $status)
	{
		if ($status == -1) {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE unit = :unit ORDER BY id DESC LIMIT :startAt, :limit');
		} else {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE unit = :unit AND status = :status ORDER BY id DESC LIMIT :startAt, :limit');
			$this->db->bind(':status', $status);
		}
		$this->db->bind(':unit', $unit);
		$this->db->bind(':startAt', $startAt);
		$this->db->bind(':limit', $limit);
		$rows = $this->db->resultSet();

		return $rows;
	}

	public function countSearchMyPeminjaman($search, $unit, $status)
	{
		if ($status == -1) {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE (kegiatan LIKE :search OR ruang LIKE :search) AND unit = :unit');
		} else {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE (kegiatan LIKE :search OR ruang LIKE :search) AND unit = :unit AND status = :status');
			$this->db->bind(':status', $status);
		}
		$this->db->bind(':search', "%$search%");
		$this->db->bind(':unit', $unit);
		$this->db->execute();

		return $this->db->rowCount();
	}

	public function searchMyPeminjaman($search, $startAt, $limit, $unit, $status)
	{
		if ($status == -1) {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE (kegiatan LIKE :search OR ruang LIKE :search) AND unit = :unit ORDER BY id DESC LIMIT :startAt, :limit');
		} else {
			$this->db->query('SELECT * FROM ' . $this->table . ' WHERE (kegiatan LIKE :search OR ruang LIKE :search) AND unit = :unit AND status = :status ORDER BY id DESC LIMIT :startAt, :limit');
			$this->db->bind(':status', $status);
		}
		$this->db->bind(':search', "%$search%");
		$this->db->bind(':unit', $unit);
		$this->db->bind(':startAt', $startAt);
		$this->db->bind(':limit', $limit);
		$rows = $this->db->resultSet();

		return $rows;
	}

	// Detail Peminjaman
	public function getPeminjamanById($id)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
		$this->db->bind(':id', $id);
		$row = $this->db->single();

		return $row;
	}

	public function getPeminjamanByIdPinjam($id_pinjam)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_pinjam = :id_pinjam');
		$this->db->bind(':id_pinjam', $id_pinjam);
		$row = $this->db->single();

		return $row;
	}

	// Tambah Peminjaman
	public function tambahPeminjaman($data, $unit)
	{
		$query = "SELECT * FROM " . $this->table . " WHERE diperlukan_tanggal = :diperlukan_tanggal AND sesi = :sesi AND ruang = :ruang";
		$this->db->query($query);
		$this->db->bind(':diperlukan_tanggal', $data['diperlukan_tanggal']);
		$this->db->bind(':sesi', $data['sesi']);
		$this->db->bind(':ruang', $data['ruang']);
		$this->db->single();
		if ($this->db->rowCount() > 0) {
			return "Ruang sudah dipesan pada tanggal dan sesi tersebut";
		}

		$id_pinjam = $this->generateId();
		$query = "INSERT INTO " . $this->table . " VALUES (:id, :id_pinjam, :kegiatan, :dresscode, :unit, :dibuat_tanggal, :diperlukan_tanggal, :ruang, :sesi, :status, :keterangan, :last_update)";
		$this->db->query($query);
		$this->db->bind(':id', null);
		$this->db->bind(':id_pinjam', $id_pinjam);
		$this->db->bind(':kegiatan', $data['kegiatan']);
		$this->db->bind(':dresscode', $data['dresscode']);
		$this->db->bind(':unit', $unit);
		$this->db->bind(':dibuat_tanggal', date('Y-m-d'));
		$this->db->bind(':diperlukan_tanggal', $data['diperlukan_tanggal']);
		$this->db->bind(':ruang', $data['ruang']);
		$this->db->bind(':sesi', $data['sesi']);
		$this->db->bind(':status', 1);
		$this->db->bind(':keterangan', '');
		$this->db->bind(':last_update', date('Y-m-d H:i:s'));
		$this->db->execute();

		return [$this->db->rowCount(), $id_pinjam];
	}

	// Edit Peminjaman
	public function editPeminjaman($data, $id_pinjam, $level)
	{
		$query = "SELECT * FROM " . $this->table . " WHERE id_pinjam = :id_pinjam";
		$this->db->query($query);
		$this->db->bind(':id_pinjam', $id_pinjam);
		$row = $this->db->single();
		if ($row['status'] != 1 && $level != 1) {
			return "Peminjaman tidak dapat diubah karena sudah disetujui atau ditolak";
		}

		$query = "UPDATE " . $this->table . " SET kegiatan = :kegiatan, dresscode = :dresscode, diperlukan_tanggal = :diperlukan_tanggal, ruang = :ruang, sesi = :sesi, status = :status, keterangan = :keterangan, last_update = :last_update WHERE id_pinjam = :id_pinjam";
		$this->db->query($query);
		$this->db->bind(':id_pinjam', $id_pinjam);
		$this->db->bind(':kegiatan', $data['kegiatan']);
		$this->db->bind(':dresscode', $data['dresscode']);
		$this->db->bind(':diperlukan_tanggal', $data['diperlukan_tanggal']);
		$this->db->bind(':ruang', $data['ruang']);
		$this->db->bind(':sesi', $data['sesi']);
		$this->db->bind(':status', $data['status']);
		$this->db->bind(':keterangan', $data['keterangan']);
		$this->db->bind(':last_update', date('Y-m-d H:i:s'));
		$this->db->execute();

		return $this->db->rowCount();
	}

	// Update Status Peminjaman
	public function updateStatusPeminjaman($id_pinjam, $status)
	{
		$query = "UPDATE " . $this->table . " SET status = :status WHERE id_pinjam = :id_pinjam";
		$this->db->query($query);
		$this->db->bind(':id_pinjam', $id_pinjam);
		$this->db->bind(':status', $status);
		$this->db->execute();

		return $this->db->rowCount();
	}

	// Delete Peminjaman
	public function deletePeminjaman($id_pinjam)
	{
		$query = "DELETE FROM " . $this->table . " WHERE id_pinjam = :id_pinjam";
		$this->db->query($query);
		$this->db->bind(':id_pinjam', $id_pinjam);
		$this->db->execute();

		return $this->db->rowCount();
	}
}
