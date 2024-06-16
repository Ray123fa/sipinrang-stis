<?php
class Dashboard extends Controller
{
	private $data;
	private $username;
	private $unit;
	private $level;

	public function __construct()
	{
		// Session Timeout
		$inactive = 60 * 60 * 12;
		if (isset($_SESSION['timeout'])) {
			$session_life = time() - $_SESSION['timeout'];
			if ($session_life > $inactive) {
				session_unset();
				Flasher::setFlash('Sesi telah berakhir, silakan login kembali!', 'danger');
				$this->redirect('login');
			}
		}
		$_SESSION['timeout'] = time();

		// Check if user is logged in
		$_SESSION['link'] = explode("=", $_SERVER['QUERY_STRING'])[1];
		if (!isset($_SESSION['user'])) {
			$this->redirect('login');
		} else {
			if (isset($_SESSION['link'])) {
				unset($_SESSION['link']);
			}
		}

		// Check if username is exist
		$existUsername = $this->model('UserModel')->isExistUsername($_SESSION['user']);
		if (!$existUsername) {
			$this->redirect('user/logout');
		}

		$this->username = $_SESSION['user'];
		$this->unit = $this->model('UserModel')->getUnitByUsername($this->username);
		$this->level = $this->model('UserModel')->getLevelByUsername($this->username);

		$this->data = [
			'css' => ['Dashboard/Style.css', 'flasher.css'],
			'js' => ['Dashboard/Main.js'],
			'user' => $this->username,
			'unit' => $this->unit,
			'level' => $this->level,
			'profile_img' => $this->model('UserModel')->getProfileImgPath($this->username),
		];
	}

	// Home Dashboard
	public function index()
	{
		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
		}
		if (isset($_SESSION['search_user'])) {
			unset($_SESSION['search_user']);
		}

		$this->data['title'] = 'Dashboard';

		$this->partial('Dashboard/Header', $this->data);
		$this->partial('Dashboard/Sidebar', $this->data);
		$this->view('Dashboard/index', $this->data);
		$this->partial('Dashboard/Footer', $this->data);
	}

	// Profil
	public function profile()
	{
		if ($this->level == 4) {
			$this->redirect('forbidden');
		}

		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
		}
		if (isset($_SESSION['search_user'])) {
			unset($_SESSION['search_user']);
		}

		$this->data['title'] = 'Profile';
		$this->data['profile'] = $this->model('UserModel')->getAllByUsername($this->username);
		$this->data['css'][2] = 'Dashboard/Form.css';
		$this->data['js'][1] = 'Dashboard/Profile.js';

		$this->partial('Dashboard/Header', $this->data);
		$this->partial('Dashboard/Sidebar', $this->data);
		$this->view('Dashboard/profile', $this->data['profile']);
		$this->partial('Dashboard/Footer', $this->data);
	}

	// Semua Peminjaman
	public function semua_peminjaman($page = 1)
	{
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
		}
		if (isset($_SESSION['search_user'])) {
			unset($_SESSION['search_user']);
		}

		$this->data['title'] = 'Semua Peminjaman';
		$this->data['css'][2] = 'Dashboard/Table.css';
		$this->data['js'][1] = 'Dashboard/semuaPeminjaman.js';

		// Pagination
		$start = 0;
		$limit = 7;
		$status = -1;

		if (isset($_POST['limit-all']) && isset($_POST['status-all'])) {
			$limit = (int) $_POST['limit-all'];
			$_SESSION['limit-all'] = $limit;

			$status = (int) $_POST['status-all'];
			$_SESSION['status-all'] = $status;
		}
		if (isset($_SESSION['limit-all']) && isset($_SESSION['status-all'])) {
			$limit = (int) $_SESSION['limit-all'];
			$status = (int) $_SESSION['status-all'];
		}

		$totalRows = (int) $this->model('PeminjamanModel')->countAll();
		if ($status != -1) {
			$totalRows = (int) $this->model('PeminjamanModel')->countAllByStatus($status);
		}
		if ($limit == -1) {
			$limit = $totalRows;
		}

		$totalHalaman = ceil($totalRows / $limit);
		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = $totalHalaman;

		if ($page < 1) {
			$this->redirect('dashboard/semua-peminjaman/1');
		} else if ($page > $totalHalaman && $totalHalaman != 0) {
			$this->redirect('dashboard/semua-peminjaman/' . $totalHalaman);
		}

		if ($page > 1) {
			$start = ($limit * $page) - $limit;
		}

		$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
		$this->data['currPage'] = $page;
		$this->data['peminjaman'] = $this->model('PeminjamanModel')->getAllByLimit($start, $limit, $status);

		if (isset($_SESSION['search_all'])) {
			$search = $_SESSION['search_all'];
			$totalRows = (int) $this->model('PeminjamanModel')->countSearchAllPeminjaman($search, $status);
			$totalHalaman = ceil($totalRows / $limit);
			$this->data['totalRows'] = $totalRows;
			$this->data['totalHalaman'] = $totalHalaman;
			$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
			$this->data['peminjaman'] = $this->model('PeminjamanModel')->searchAllPeminjaman($search, $start, $limit, $status);
		}

		$this->data['list-sesi'] = $this->model('SesiModel')->getAll();

		if (isset($_POST['limit-all']) && isset($_POST['status-all'])) {
			$this->helper('Dashboard/semuaPeminjaman', $this->data);
		} else {
			$this->partial('Dashboard/Header', $this->data);
			$this->partial('Dashboard/Sidebar', $this->data);
			$this->view('Dashboard/semuaPeminjaman', $this->data);
			$this->partial('Dashboard/Footer', $this->data);
		}
	}

	// Riwayat Peminjaman
	public function riwayat_peminjaman($page = 1)
	{
		if ($this->level == 4) {
			$this->redirect('forbidden');
		}

		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}
		if (isset($_SESSION['search_user'])) {
			unset($_SESSION['search_user']);
		}

		$this->data['title'] = 'Riwayat Peminjaman';
		$this->data['css'][2] = 'Dashboard/Table.css';
		$this->data['js'][1] = 'Dashboard/riwayatPeminjaman.js';

		$start = 0;
		$limit = 7;
		$status = -1;

		if (isset($_POST['limit-riwayat']) && isset($_POST['status-riwayat'])) {
			$limit = (int) $_POST['limit-riwayat'];
			$_SESSION['limit-riwayat'] = $limit;

			$status = (int) $_POST['status-riwayat'];
			$_SESSION['status-riwayat'] = $status;
		}
		if (isset($_SESSION['limit-riwayat']) && isset($_SESSION['status-riwayat'])) {
			$limit = (int) $_SESSION['limit-riwayat'];
			$status = (int) $_SESSION['status-riwayat'];
		}

		$totalRows = (int) $this->model('PeminjamanModel')->countMyPeminjaman($this->unit, $status);
		if ($limit == -1) {
			$limit = $totalRows;
		}

		$totalHalaman = ceil($totalRows / $limit);
		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = $totalHalaman;

		if ($page < 1) {
			$this->redirect('dashboard/riwayat-peminjaman/1');
		} else if ($page > $totalHalaman && $totalHalaman != 0) {
			$this->redirect('dashboard/riwayat-peminjaman/' . $totalHalaman);
		}

		if ($page > 1) {
			$start = ($limit * $page) - $limit;
		}

		$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
		$this->data['currPage'] = $page;
		$this->data['peminjaman'] = $this->model('PeminjamanModel')->getMyPeminjamanByLimit($start, $limit, $this->unit, $status);

		if (isset($_SESSION['search_my'])) {
			$search = $_SESSION['search_my'];
			$totalRows = (int) $this->model('PeminjamanModel')->countSearchMyPeminjaman($search, $this->unit, $status);
			$totalHalaman = ceil($totalRows / $limit);
			$this->data['totalRows'] = $totalRows;
			$this->data['totalHalaman'] = $totalHalaman;
			$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
			$this->data['peminjaman'] = $this->model('PeminjamanModel')->searchMyPeminjaman($search, $start, $limit, $this->unit, $status);
		}

		$this->data['list-sesi'] = $this->model('SesiModel')->getAll();

		if (isset($_POST['limit-riwayat'])) {
			$this->helper('Dashboard/riwayatPeminjaman', $this->data);
		} else {
			$this->partial('Dashboard/Header', $this->data);
			$this->partial('Dashboard/Sidebar', $this->data);
			$this->view('Dashboard/riwayatPeminjaman', $this->data);
			$this->partial('Dashboard/Footer', $this->data);
		}
	}

	// Detail Peminjaman
	public function detail_peminjaman($idpinjam = null)
	{
		if ($idpinjam == null) {
			$this->redirect('notfound');
		} else {
			$check = $this->model('PeminjamanModel')->getPeminjamanByIdPinjam($idpinjam);
			if ($check == null) {
				$this->redirect('notfound');
			}
		}

		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
		}
		if (isset($_SESSION['search_user'])) {
			unset($_SESSION['search_user']);
		}

		$this->data['title'] = 'Detail Peminjaman';
		$this->data['css'][2] = 'Dashboard/Form.css';
		$this->data['css'][3] = 'Dashboard/select2.min.css';
		$this->data['js'][1] = 'Dashboard/jquery.min.js';
		$this->data['js'][2] = 'Dashboard/select2.full.min.js';
		$this->data['js'][3] = 'Dashboard/detailPeminjaman.js';

		$this->data['list-status'] = $this->model('StatusModel')->getAll();
		$this->data['list-sesi'] = $this->model('SesiModel')->getAll();
		$this->data['peminjaman'] = $this->model('PeminjamanModel')->getPeminjamanByIdPinjam($idpinjam);

		$this->partial('Dashboard/Header', $this->data);
		$this->partial('Dashboard/Sidebar', $this->data);
		$this->view('Dashboard/detailPeminjaman', $this->data);
		$this->partial('Dashboard/Footer', $this->data);
	}

	// Tambah Peminjaman
	public function tambah_peminjaman()
	{
		if ($this->level == 4) {
			$this->redirect('forbidden');
		}

		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
		}
		if (isset($_SESSION['search_user'])) {
			unset($_SESSION['search_user']);
		}

		$this->data['title'] = 'Tambah Peminjaman';
		$this->data['css'][2] = 'Dashboard/Form.css';
		$this->data['css'][3] = 'Dashboard/select2.min.css';
		$this->data['js'][1] = 'Dashboard/tambahPeminjaman.js';
		$this->data['js'][2] = 'Dashboard/jquery.min.js';
		$this->data['js'][3] = 'Dashboard/select2.full.min.js';

		$this->partial('Dashboard/Header', $this->data);
		$this->partial('Dashboard/Sidebar', $this->data);
		$this->view('Dashboard/tambahPeminjaman', $this->data);
		$this->partial('Dashboard/Footer', $this->data);
	}

	// Daftar Pengguna
	public function daftar_pengguna($page = 1)
	{
		if ($this->level > 2) {
			$this->redirect('forbidden');
		}

		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
		}

		$this->data['title'] = 'Daftar Pengguna';
		$this->data['css'][2] = 'Dashboard/Table.css';
		$this->data['js'][1] = 'Dashboard/daftarPengguna.js';

		// Pagination
		$start = 0;
		$limit = 7;

		if (isset($_POST['limit-user'])) {
			$limit = (int) $_POST['limit-user'];
			$_SESSION['limit-user'] = $limit;
		}
		if (isset($_SESSION['limit-user'])) {
			$limit = (int) $_SESSION['limit-user'];
		}

		$totalRows = (int) $this->model("UserModel")->countGetAll();
		if ($limit == -1) {
			$limit = $totalRows;
		}

		$totalHalaman = ceil($totalRows / $limit);
		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = $totalHalaman;

		if ($page < 1) {
			$this->redirect('dashboard/daftar-pengguna/1');
		} else if ($page > $totalHalaman && $totalHalaman != 0) {
			$this->redirect('dashboard/daftar-pengguna/' . $totalHalaman);
		}

		if ($page > 1) {
			$start = ($limit * $page) - $limit;
		}

		$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
		$this->data['currPage'] = $page;
		$this->data['users'] = $this->model('UserModel')->getAllByLimit($start, $limit);

		if (isset($_SESSION['search_user'])) {
			$search = $_SESSION['search_user'];
			$totalRows = (int) $this->model('UserModel')->countSearchUser($search);
			$totalHalaman = ceil($totalRows / $limit);
			$this->data['totalRows'] = $totalRows;
			$this->data['totalHalaman'] = $totalHalaman;
			$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
			$this->data['users'] = $this->model('UserModel')->searchUser($search, $start, $limit);
		}

		if (isset($_POST['limit-user'])) {
			$this->helper('Dashboard/daftarPengguna', $this->data);
		} else {
			$this->partial('Dashboard/Header', $this->data);
			$this->partial('Dashboard/Sidebar', $this->data);
			$this->view('Dashboard/daftarPengguna', $this->data);
			$this->partial('Dashboard/Footer', $this->data);
		}
	}

	// Tambah Pengguna
	public function tambah_pengguna()
	{
		if ($this->level > 2) {
			$this->redirect('forbidden');
		}

		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
		}
		if (isset($_SESSION['search_user'])) {
			unset($_SESSION['search_user']);
		}

		$this->data['title'] = 'Tambah Pengguna';
		$this->data['css'][2] = 'Dashboard/Form.css';
		$this->data['js'][1] = 'Dashboard/tambahPengguna.js';

		$this->partial('Dashboard/Header', $this->data);
		$this->partial('Dashboard/Sidebar', $this->data);
		$this->view('Dashboard/tambahPengguna', $this->data);
		$this->partial('Dashboard/Footer', $this->data);
	}
}
