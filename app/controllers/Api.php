<?php
class Api extends Controller
{
	private $data;
	private $username;
	private $unit;
	private $level;
	private $chatID;
	private $bot;

	public function __construct()
	{
		if (!isset($_SESSION['user'])) {
			$this->redirect('login');
		}

		$this->bot = $this->model('TelebotModel');
		$this->username = $_SESSION['user'];
		$this->unit = $this->model('UserModel')->getUnitByUsername($this->username);
		$this->level = $this->model('UserModel')->getLevelByUsername($this->username);
		$this->chatID = $this->model('UserModel')->getChatIdByUsername($this->username);

		$this->data = [
			'css' => ['Dashboard/Style.css', 'Dashboard/Peminjaman.css'],
			'js' => ['Dashboard/Main.js'],
			'user' => $this->username,
			'unit' => $this->unit,
			'level' => $this->level
		];
	}

	public function index()
	{
		$this->redirect('user');
	}

	public function search_semua_peminjaman()
	{
		if (!isset($_POST['search']) || !isset($_POST['limit'])) {
			$this->redirect('user/semua-peminjaman');
		}

		$search = $_POST['search'];
		$_SESSION['search_all'] = $search;

		$start = 0;
		$limit = (int) $_POST['limit'];
		$status = (int) $_POST['status'];
		$totalRows = (int) $this->model('PeminjamanModel')->countSearchAllPeminjaman($search, $status);

		if ($limit == -1) {
			$limit = $totalRows;
		}

		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = ceil($totalRows / $limit);
		$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
		$this->data['currPage'] = 1;
		$this->data['peminjaman'] = $this->model('PeminjamanModel')->searchAllPeminjaman($search, $start, $limit, $status);

		$this->data['list-sesi'] = $this->model('SesiModel')->getAll();

		$this->helper('Dashboard/semuaPeminjaman', $this->data);
	}

	public function search_riwayat_peminjaman()
	{
		if (!isset($_POST['search']) || !isset($_POST['limit'])) {
			$this->redirect('user/riwayat-peminjaman');
		}

		$search = $_POST['search'];
		$_SESSION['search_my'] = $search;

		$start = 0;
		$limit = (int) $_POST['limit'];
		$status = (int) $_POST['status'];
		$totalRows = (int) $this->model('PeminjamanModel')->countSearchMyPeminjaman($search, $this->unit, $status);

		if ($limit == -1) {
			$limit = $totalRows;
		}

		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = ceil($totalRows / $limit);
		$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
		$this->data['currPage'] = 1;
		$this->data['peminjaman'] = $this->model('PeminjamanModel')->searchMyPeminjaman($search, $start, $limit, $this->unit, $status);

		$this->data['list-sesi'] = $this->model('SesiModel')->getAll();

		$this->helper('Dashboard/riwayatPeminjaman', $this->data);
	}

	public function search_user()
	{
		if (!isset($_POST['search']) || !isset($_POST['limit-user'])) {
			$this->redirect('user/daftar-pengguna');
		}

		$search = $_POST['search'];
		$_SESSION['search_user'] = $search;

		$start = 0;
		$limit = (int) $_POST['limit-user'];
		$totalRows = (int) $this->model('UserModel')->countSearchUser($search);

		if ($limit == -1) {
			$limit = $totalRows;
		}

		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = ceil($totalRows / $limit);
		$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
		$this->data['currPage'] = 1;
		$this->data['users'] = $this->model('UserModel')->searchUser($search, $start, $limit);

		$this->helper('Dashboard/daftarPengguna', $this->data);
	}

	// Get Ruang Available
	public function get_avail_ruang($tgl = null, $sesi = null)
	{
		if (is_null($tgl) || is_null($sesi)) {
			$this->redirect("forbidden");
		}

		$ruang = $this->model('RuangModel')->getAvailRuang($tgl, $sesi);
		echo json_encode($ruang);
	}

	// Update Status Peminjaman
	public function update_status_peminjaman($idpinjam, $status)
	{
		if ($this->level != 1) {
			$this->redirect('forbidden');
		}

		$res = $this->model('PeminjamanModel')->updateStatusPeminjaman($idpinjam, $status);

		$listStatus = [
			1 => "Dalam Proses Persetujuan BAU",
			2 => "Disetujui",
			3 => "Ditolak"
		];
		if ($res > 0) {
			if ($this->chatID != null) {
				$detail = $this->model('PeminjamanModel')->getPeminjamanByIdPinjam($idpinjam);
				if ($detail['unit'] == $this->unit) {
					$this->bot->send("sendMessage", [
						"parse_mode" => "Markdown",
						"chat_id" => $this->chatID,
						"text" => "Peminjaman dengan ID *$idpinjam* telah diperbarui menjadi *" . $listStatus[$status] . "* dengan detail berikut.\nKegiatan: *$detail[kegiatan]*\nTanggal: *$detail[diperlukan_tanggal]*\nSesi: *$detail[sesi]*\nRuang: *$detail[ruang]*"
					]);
				}
			}
		}
	}
}
