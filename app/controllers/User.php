<?php
class User extends Controller
{
	private $bot;
	private $data;
	private $username;
	private $unit;
	private $level;
	private $noWA;

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

		// Check remember me
		if (isset($_COOKIE['remember_me']) && !isset($_SESSION['user'])) {
			$cookie = $_COOKIE['remember_me'];
			$cookie = CookieHandler::decrypt($cookie, 'REMEMBER_ME');
			$_SESSION['user'] = $cookie;
		}

		// Check if user is logged in
		$_SESSION['link'] = explode("=", $_SERVER['QUERY_STRING'])[1];
		if (!isset($_SESSION['user'])) {
			$this->redirect('login');
		} else {
			if (isset($_SESSION['link'])) {
				unset($_SESSION['link']);
			}
		}

		$this->bot = $this->model('WhatsappModel');
		$this->username = $_SESSION['user'];
		$this->unit = $this->model('UserModel')->getUnitByUsername($this->username);
		$this->level = $this->model('UserModel')->getLevelByUsername($this->username);
		$this->noWA = $this->model('UserModel')->getWAByUnit($this->unit);

		$this->data = [
			'css' => ['Dashboard/Style.css', 'flasher.css'],
			'js' => ['Dashboard/Main.js'],
			'user' => $this->username,
			'unit' => $this->unit,
			'level' => $this->level,
			'profile_img' => $this->model('UserModel')->getProfileImgPath($this->username),
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
		if ($this->level == 4) {
			$this->redirect('forbidden');
		}

		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
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

	// Edit Profil
	public function edit_profile()
	{
		if (!isset($_POST['edit'])) {
			$this->redirect('forbidden');
		}

		$res = $this->model('UserModel')->editProfile($_POST);
		if ($res === true) {
			Flasher::setFlash('Profile berhasil diperbarui!', 'success', 'profile');
			$this->redirect('user/profile');
		} else {
			Flasher::setFlash($res, 'warning', 'profile');
			$this->redirect('user/profile');
		}
	}

	// Change Password
	public function change_password()
	{
		if (!isset($_POST['change'])) {
			$this->redirect('forbidden');
		}

		$res = $this->model('UserModel')->changePassword($_POST, $this->username);
		if ($res === true) {
			Flasher::setFlash('Password berhasil diperbarui!', 'success', 'change-password');
			$this->redirect('user/profile');
		} else {
			Flasher::setFlash($res, 'warning', 'change-password');
			$this->redirect('user/profile');
		}
	}

	// Semua Peminjaman
	public function semua_peminjaman($page = 1)
	{
		if (isset($_SESSION['search_my'])) {
			unset($_SESSION['search_my']);
		}

		$this->data['title'] = 'Semua Peminjaman';
		$this->data['css'][2] = 'Dashboard/Table.css';
		$this->data['js'][1] = 'Dashboard/semuaPeminjaman.js';

		// Pagination
		$start = 0;
		$limit = 7;
		$status = -1;

		if (isset($_POST['limit']) && isset($_POST['status'])) {
			$limit = (int) $_POST['limit'];
			$_SESSION['limit'] = $limit;

			$status = (int) $_POST['status'];
			$_SESSION['status'] = $status;
		}
		if (isset($_SESSION['limit']) && isset($_SESSION['status'])) {
			$limit = (int) $_SESSION['limit'];
			$status = (int) $_SESSION['status'];
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
			$this->redirect('user/semua-peminjaman/1');
		} else if ($page > $totalHalaman && $totalHalaman != 0) {
			$this->redirect('user/semua-peminjaman/' . $totalHalaman);
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

		if (isset($_POST['limit']) && isset($_POST['status'])) {
			$this->helper('Dashboard/semuaPeminjaman', $this->data);
		} else {
			$this->partial('Dashboard/Header', $this->data);
			$this->partial('Dashboard/Sidebar', $this->data);
			$this->view('Dashboard/semuaPeminjaman', $this->data);
			$this->partial('Dashboard/Footer', $this->data);
		}
	}

	// Peminjaman Saya
	public function riwayat_peminjaman($page = 1)
	{
		if ($this->level == 4) {
			$this->redirect('forbidden');
		}

		if (isset($_SESSION['search_all'])) {
			unset($_SESSION['search_all']);
		}

		$this->data['title'] = 'Riwayat Peminjaman';
		$this->data['css'][2] = 'Dashboard/Table.css';
		$this->data['js'][1] = 'Dashboard/riwayatPeminjaman.js';

		$start = 0;
		$limit = 7;
		$status = -1;

		if (isset($_POST['limit']) && isset($_POST['status'])) {
			$limit = (int) $_POST['limit'];
			$_SESSION['limit'] = $limit;

			$status = (int) $_POST['status'];
			$_SESSION['status'] = $status;
		}
		if (isset($_SESSION['limit']) && isset($_SESSION['status'])) {
			$limit = (int) $_SESSION['limit'];
			$status = (int) $_SESSION['status'];
		}

		$totalRows = (int) $this->model('PeminjamanModel')->countMyPeminjaman($this->unit, $status);
		if ($limit == -1) {
			$limit = $totalRows;
		}

		$totalHalaman = ceil($totalRows / $limit);
		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = $totalHalaman;

		if ($page < 1) {
			$this->redirect('user/riwayat-peminjaman/1');
		} else if ($page > $totalHalaman && $totalHalaman != 0) {
			$this->redirect('user/riwayat-peminjaman/' . $totalHalaman);
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

		if (isset($_POST['limit'])) {
			$this->helper('Dashboard/riwayatPeminjaman', $this->data);
		} else {
			$this->partial('Dashboard/Header', $this->data);
			$this->partial('Dashboard/Sidebar', $this->data);
			$this->view('Dashboard/riwayatPeminjaman', $this->data);
			$this->partial('Dashboard/Footer', $this->data);
		}
	}

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

	// Create Peminjaman
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

	public function do_tambah_peminjaman()
	{
		if (!isset($_POST['tambah'])) {
			$this->redirect('forbidden');
		}

		$res = $this->model('PeminjamanModel')->tambahPeminjaman($_POST, $this->unit);
		if ($res[0] === 1) {
			$msg = "Anda telah berhasil menambahkan peminjaman dengan detail berikut.\nID Pinjam: *$res[1]*.\nKegiatan: *$_POST[kegiatan]*\nTanggal: *$_POST[diperlukan_tanggal]*\nSesi: *$_POST[sesi]*\nRuang: *$_POST[ruang]*.";
			$reply = [
				"message" => $msg
			];
			$resp = $this->bot->sendFonnte($this->noWA, $reply);
			$resp = json_decode($resp, true);

			if ($resp['status']) {
				Flasher::setFlash('Peminjaman berhasil ditambahkan!', 'success', 'tambah-peminjaman');
				$this->redirect('user/tambah-peminjaman');
			} else {
				Flasher::setFlash('Peminjaman berhasil ditambahkan, tetapi notifikasi gagal dikirim!', 'warning', 'tambah-peminjaman');
				$this->redirect('user/tambah-peminjaman');
			}
		} else {
			Flasher::setFlash('Peminjaman gagal ditambahkan', 'warning', 'tambah-peminjaman');
			$this->redirect('user/tambah-peminjaman');
		}
	}

	// Edit Peminjaman
	public function do_edit_peminjaman($idpinjam = null)
	{
		if ($idpinjam == null) {
			$this->redirect('notfound');
		}

		if (!isset($_POST['simpan'])) {
			$this->redirect('forbidden');
		}

		$res = $this->model('PeminjamanModel')->editPeminjaman($_POST, $idpinjam, $this->level);
		if ($res === 1) {
			$this->noWA = $this->model('UserModel')->getWAByUnit($this->model('PeminjamanModel')->getUnitByIdPinjam($idpinjam));
			$listStatus = [
				1 => "Proses Persetujuan BAU",
				2 => "Disetujui",
				3 => "Ditolak"
			];

			$keterangan = ($_POST['keterangan'] == '') ? '-' : $_POST['keterangan'];
			if ($this->unit != $this->model('PeminjamanModel')->getUnitByIdPinjam($idpinjam)) {
				$msg = "Peminjaman dengan ID *$idpinjam* telah diperbarui oleh $this->unit dengan detail berikut.\nKegiatan: *$_POST[kegiatan]*\nTanggal: *$_POST[diperlukan_tanggal]*\nSesi: *$_POST[sesi]*\nRuang: *$_POST[ruang]*\nStatus: *" . $listStatus[$_POST['status']] . "*\nKeterangan: *$keterangan*";
			} else {
				$msg = "Peminjaman dengan ID *$idpinjam* telah diperbarui dengan detail berikut.\nKegiatan: *$_POST[kegiatan]*\nTanggal: *$_POST[diperlukan_tanggal]*\nSesi: *$_POST[sesi]*\nRuang: *$_POST[ruang]*\nStatus: *" . $listStatus[$_POST['status']] . "*\nKeterangan: *$keterangan*";
			}
			$reply = [
				"message" => $msg
			];
			$resp = $this->bot->sendFonnte($this->noWA, $reply);
			$resp = json_decode($resp, true);

			if ($resp['status']) {
				Flasher::setFlash('Peminjaman berhasil diperbarui!', 'success', 'semua-peminjaman');
				$this->redirect('user/semua-peminjaman');
			} else {
				Flasher::setFlash('Peminjaman berhasil diperbarui, tetapi notifikasi gagal dikirim!', 'warning', 'semua-peminjaman');
				$this->redirect('user/semua-peminjaman');
			}
		} else {
			Flasher::setFlash($res, 'warning', 'detail-peminjaman');
			$this->redirect('user/detail-peminjaman/' . $idpinjam);
		}
	}

	// Delete Peminjaman
	public function do_delete_peminjaman($idpinjam = null)
	{
		if ($idpinjam == null) {
			$this->redirect('notfound');
		}

		$detail = $this->model('PeminjamanModel')->getPeminjamanByIdPinjam($idpinjam);
		$this->noWA = $this->model('UserModel')->getWAByUnit($this->model('PeminjamanModel')->getUnitByIdPinjam($idpinjam));
		$res = $this->model('PeminjamanModel')->deletePeminjaman($idpinjam);
		if ($res === 1) {
			$listStatus = [
				1 => "Proses Persetujuan BAU",
				2 => "Disetujui",
				3 => "Ditolak"
			];

			if ($this->unit != $this->model('PeminjamanModel')->getUnitByIdPinjam($idpinjam)) {
				$msg = "Peminjaman dengan detail berikut telah dihapus oleh $this->unit.\nID Pinjam: *$idpinjam*.\nKegiatan: *$detail[kegiatan]*\nTanggal: *$detail[diperlukan_tanggal]*\nSesi: *$detail[sesi]*\nRuang: *$detail[ruang]*\nStatus: *" . $listStatus[$detail['status']] . "*";
			} else {
				$msg = "Peminjaman dengan detail berikut telah dihapus.\nID Pinjam: *$idpinjam*.\nKegiatan: *$detail[kegiatan]*\nTanggal: *$detail[diperlukan_tanggal]*\nSesi: *$detail[sesi]*\nRuang: *$detail[ruang]*\nStatus: *" . $listStatus[$detail['status']] . "*";
			}
			$reply = [
				"message" => $msg
			];
			$resp = $this->bot->sendFonnte($this->noWA, $reply);
			$resp = json_decode($resp, true);

			if ($resp['status']) {
				Flasher::setFlash('Peminjaman berhasil dihapus!', 'success', 'semua-peminjaman');
				$this->redirect('user/semua-peminjaman');
			} else {
				Flasher::setFlash('Peminjaman berhasil dihapus, tetapi notifikasi gagal dikirim!', 'warning', 'semua-peminjaman');
				$this->redirect('user/semua-peminjaman');
			}
		} else {
			Flasher::setFlash($res, 'warning', 'semua-peminjaman');
			$this->redirect('user/semua-peminjaman');
		}
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
			$this->redirect('user/daftar-pengguna/1');
		} else if ($page > $totalHalaman && $totalHalaman != 0) {
			$this->redirect('user/daftar-pengguna/' . $totalHalaman);
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

		$this->data['title'] = 'Tambah Pengguna';
		$this->data['css'][2] = 'Dashboard/Form.css';
		$this->data['js'][1] = 'Dashboard/tambahPengguna.js';

		$this->partial('Dashboard/Header', $this->data);
		$this->partial('Dashboard/Sidebar', $this->data);
		$this->view('Dashboard/tambahPengguna', $this->data);
		$this->partial('Dashboard/Footer', $this->data);
	}

	// Logout
	public function logout()
	{
		session_unset();
		session_destroy();
		setcookie('remember_me', '', time() - 2592000, '/');
		$this->redirect('login');
	}
}
