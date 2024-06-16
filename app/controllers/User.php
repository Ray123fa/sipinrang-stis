<?php
class User extends Controller
{
	private $bot;
	private $username;
	private $level;

	public function __construct()
	{
		if (!isset($_SESSION['user'])) {
			$this->redirect('login');
		}

		$this->bot = $this->model('WhatsappModel');
		$this->username = $_SESSION['user'];
		$this->level = $this->model('UserModel')->getLevelByUsername($this->username);
	}

	public function index()
	{
		$this->redirect('dashboard');
	}

	public function isValidNumber($number)
	{
		$response = $this->bot->validateNumber($number);
		if ($response['status']) {
			if (count($response['registered']) > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	// Edit Profil
	public function edit_profile()
	{
		if (!isset($_POST['edit'])) {
			$this->redirect('dashboard/profile');
		}

		if (!$this->isValidNumber($_POST['no_wa']) && $_POST['no_wa'] != '') {
			Flasher::setFlash('Nomor WhatsApp tidak valid atau tidak terdaftar!', 'warning', 'profile');
			$this->redirect('dashboard/profile');
		}

		$res = $this->model('UserModel')->editProfile($_POST);
		if ($res === true) {
			Flasher::setFlash('Profile berhasil diperbarui!', 'success', 'profile');
			$this->redirect('dashboard/profile');
		} else {
			Flasher::setFlash($res, 'warning', 'profile');
			$this->redirect('dashboard/profile');
		}
	}

	// Change Password
	public function change_password()
	{
		if (!isset($_POST['change'])) {
			$this->redirect('dashboard/profile');
		}

		$res = $this->model('UserModel')->changePassword($_POST, $this->username);
		if ($res === true) {
			Flasher::setFlash('Password berhasil diperbarui!', 'success', 'change-password');
			$this->redirect('dashboard/profile');
		} else {
			Flasher::setFlash($res, 'warning', 'change-password');
			$this->redirect('dashboard/profile');
		}
	}

	// Tambah User
	public function add()
	{
		if ($this->level > 2) {
			$this->redirect('forbidden');
		}
		if (!isset($_POST['tambah'])) {
			$this->redirect('dashboard/tambah-pengguna');
		}

		if (!$this->isValidNumber($_POST['no_wa']) && $_POST['no_wa'] != '') {
			Flasher::setFlash('Nomor WhatsApp tidak valid atau tidak terdaftar!', 'warning', 'tambah-pengguna');
			$this->redirect('dashboard/tambah-pengguna');
		}

		$data = [
			'username' => strtolower(strip_tags(stripslashes($_POST['username']))),
			'unit' => strtoupper(strip_tags(stripslashes($_POST['unit']))),
			'password' => $_POST['password'],
			'repassword' => $_POST['repassword'],
			'no_wa' => strip_tags($_POST['no_wa']),
			'level' => (int) $_POST['role']
		];

		$res = $this->model('UserModel')->addUser($data);
		if ($res === true) {
			Flasher::setFlash('Pengguna berhasil ditambahkan!', 'success', 'tambah-pengguna');
			$this->redirect('dashboard/tambah-pengguna');
		} else {
			Flasher::setFlash($res, 'warning', 'tambah-pengguna');
			$this->redirect('dashboard/tambah-pengguna');
		}
	}

	// Delete User
	public function delete($id = null)
	{
		if ($this->level > 2) {
			$this->redirect('forbidden');
		}
		if ($id == null) {
			$this->redirect('notfound');
		}

		$res = $this->model('UserModel')->deleteUser($id);
		if ($res === 1) {
			Flasher::setFlash('Pengguna berhasil dihapus!', 'success', 'daftar-pengguna');
			$this->redirect('dashboard/daftar-pengguna');
		} else {
			Flasher::setFlash($res, 'warning', 'daftar-pengguna');
			$this->redirect('dashboard/daftar-pengguna');
		}
	}

	// Logout
	public function logout()
	{
		session_unset();
		session_destroy();
		$this->redirect('login');
	}
}
