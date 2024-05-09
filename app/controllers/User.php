<?php
class User extends Controller
{
	private $data;
	private $username;
	private $unit;
	private $level;

	public function __construct()
	{
		$_SESSION['link'] = explode("=", $_SERVER['QUERY_STRING'])[1];
		if (!$_SESSION['user']) {
			$this->redirect('login');
		} else {
			if (isset($_SESSION['link'])) {
				unset($_SESSION['link']);
			}
		}

		$this->username = $_SESSION['user'];
		$this->unit = $this->model('UserModel')->getUnitByUsername($this->username);
		$this->level = $this->model('UserModel')->getLevelByUsername($this->username);

		$this->data = [
			'css' => ['Dashboard/Style.css'],
			'js' => ['Dashboard/Main.js'],
			'user' => $this->username,
			'unit' => $this->unit,
			'level' => $this->level
		];
	}

	public function index()
	{
		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
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
		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
		}

		$this->data['title'] = 'Profile';
		$this->data['profile'] = $this->model('UserModel')->getAllByUsername($this->username);
		$this->data['css'][1] = 'Dashboard/Profile.css';
		$this->data['js'][1] = 'Dashboard/Profile.js';

		$this->partial('Dashboard/Header', $this->data);
		$this->partial('Dashboard/Sidebar', $this->data);
		$this->view('Dashboard/profile', $this->data['profile']);
		$this->partial('Dashboard/Footer', $this->data);
	}

	// Edit Profil
	public function edit_profile()
	{
		if (!isset($_POST['edit'])) {
			$this->redirect('forbidden');
		}

		$this->model('UserModel')->editProfile($_POST, $this->username);
	}

	// Change Password
	public function change_password()
	{
		if (!isset($_POST['change'])) {
			$this->redirect('forbidden');
		}

		$this->model('UserModel')->changePassword($_POST, $this->username);
	}

	// Semua Peminjaman
	public function all_peminjaman($page = 1)
	{
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
		}

		$this->data['title'] = 'Semua Peminjaman';
		$this->data['css'][1] = 'Dashboard/Peminjaman.css';
		$this->data['js'][1] = 'Dashboard/allPeminjaman.js';

		$start = 0;
		$limit = 7;

		if (isset($_POST['limit'])) {
			$limit = (int) $_POST['limit'];
			$_SESSION['limit'] = $limit;
		}
		if (isset($_SESSION['limit'])) {
			$limit = (int) $_SESSION['limit'];
		}

		$totalRows = (int) $this->model('PeminjamanModel')->countAll();
		if ($limit == -1) {
			$limit = $totalRows;
		}

		$totalHalaman = ceil($totalRows / $limit);
		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = $totalHalaman;

		if ($page < 1) {
			$this->redirect('user/all-peminjaman/1');
		} else if ($page > $totalHalaman) {
			$this->redirect('user/all-peminjaman/' . $totalHalaman);
		}

		if ($page > 1) {
			$start = ($limit * $page) - $limit;
		}

		$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
		$this->data['currPage'] = $page;
		$this->data['peminjaman'] = $this->model('PeminjamanModel')->getAllByLimit($start, $limit);

		if (isset($_SESSION['search_all'])) {
			$search = $_SESSION['search_all'];
			$totalRows = (int) $this->model('PeminjamanModel')->countSearchAllPeminjaman($search);
			$totalHalaman = ceil($totalRows / $limit);
			$this->data['totalRows'] = $totalRows;
			$this->data['totalHalaman'] = $totalHalaman;
			$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
			$this->data['peminjaman'] = $this->model('PeminjamanModel')->searchAllPeminjaman($search, $start, $limit);
		}

		if (isset($_POST['limit'])) {
			$this->helper('Dashboard/allPeminjaman', $this->data);
		} else {
			$this->partial('Dashboard/Header', $this->data);
			$this->partial('Dashboard/Sidebar', $this->data);
			$this->view('Dashboard/allPeminjaman', $this->data);
			$this->partial('Dashboard/Footer', $this->data);
		}
	}

	// Peminjaman Saya
	public function my_peminjaman($page = 1)
	{
		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}

		$this->data['title'] = 'Peminjaman Saya';
		$this->data['css'][1] = 'Dashboard/Peminjaman.css';
		$this->data['js'][1] = 'Dashboard/myPeminjaman.js';

		$start = 0;
		$limit = 7;

		if (isset($_POST['limit'])) {
			$limit = (int) $_POST['limit'];
			$_SESSION['limit'] = $limit;
		}
		if (isset($_SESSION['limit'])) {
			$limit = (int) $_SESSION['limit'];
		}

		$totalRows = (int) $this->model('PeminjamanModel')->countMyPeminjaman($this->username);
		if ($limit == -1) {
			$limit = $totalRows;
		}

		$totalHalaman = ceil($totalRows / $limit);
		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = $totalHalaman;

		if ($page < 1) {
			$this->redirect('user/my_peminjaman/1');
		} else if ($page > $totalHalaman) {
			$this->redirect('user/my_peminjaman/' . $totalHalaman);
		}

		if ($page > 1) {
			$start = ($limit * $page) - $limit;
		}

		$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
		$this->data['currPage'] = $page;
		$this->data['peminjaman'] = $this->model('PeminjamanModel')->getMyPeminjamanByLimit($start, $limit, $this->unit);

		if (isset($_SESSION['search_my'])) {
			$search = $_SESSION['search_my'];
			$totalRows = (int) $this->model('PeminjamanModel')->countSearchMyPeminjaman($search, $this->unit);
			$totalHalaman = ceil($totalRows / $limit);
			$this->data['totalRows'] = $totalRows;
			$this->data['totalHalaman'] = $totalHalaman;
			$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
			$this->data['peminjaman'] = $this->model('PeminjamanModel')->searchMyPeminjaman($search, $start, $limit, $this->unit);
		}

		if (isset($_POST['limit'])) {
			$this->helper('Dashboard/myPeminjaman', $this->data);
		} else {
			$this->partial('Dashboard/Header', $this->data);
			$this->partial('Dashboard/Sidebar', $this->data);
			$this->view('Dashboard/myPeminjaman', $this->data);
			$this->partial('Dashboard/Footer', $this->data);
		}
	}

	// Logout
	public function logout()
	{
		session_destroy();
		$this->redirect('login');
	}
}
