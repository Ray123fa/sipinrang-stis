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
		$query = "INSERT INTO " . $this->table . " VALUES (:id, :id_pinjam, :kegiatan, :dresscode, :unit, :dibuat_tanggal, :diperlukan_tanggal, :ruang, :sesi, :status, :keterangan, :last_update)";
		$this->db->query($query);
		$this->db->bind(':id', null);
		$this->db->bind(':id_pinjam', $this->generateId());
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

		return $this->db->rowCount();
	}
}
