<?php
class Login extends Controller
{
	private $account;
	private $cookie;

	public function __construct()
	{
		// Check remember me
		if ((isset($_COOKIE['username']) && isset($_COOKIE['password'])) && !isset($_SESSION['user'])) {
			$this->cookie = [
				'username' => CookieHandler::decrypt($_COOKIE['username'], 'REMEMBER_ME'),
				'password' => CookieHandler::decrypt($_COOKIE['password'], 'REMEMBER_ME'),
				'remember' => 'checked'
			];
		}

		if (isset($_SESSION['user'])) {
			$this->redirect('user');
		}

		$this->account = $this->model('AccountModel');
	}

	public function index()
	{
		$data = [
			'title' => 'Login',
			'css' => [
				'Account/Style.css',
				'flasher.css'
			],
			'username' => (isset($this->cookie['username'])) ? $this->cookie['username'] : '',
			'password' => (isset($this->cookie['password'])) ? $this->cookie['password'] : '',
			'remember' => (isset($this->cookie['remember'])) ? $this->cookie['remember'] : ''
		];

		$this->partial('Account/Header', $data);
		$this->view('login', $data);
		$this->partial('Account/Footer');
	}

	public function do()
	{
		(!isset($_POST['login'])) ? $this->redirect('login') : null;

		if (!session_id()) {
			session_start();
		}

		$data = [
			'username' => strtolower($_POST['username']),
			'password' => $_POST['pass'],
			'remember' => isset($_POST['remember-me']) ? true : false
		];

		$status = $this->account->login($data);
		if ($status === true) {
			$_SESSION['user'] = $data['username'];
			if (isset($_SESSION['link'])) {
				$this->redirect($_SESSION['link']);
			} else {
				$this->redirect('dashboard');
			}
		} else {
			Flasher::setFlash('Username atau password salah!', 'warning');
			$this->redirect('login');
		}
	}

	public function guest()
	{
		if (!session_id()) {
			session_start();
		}

		$data = [
			'username' => 'guest',
			'password' => 'gueststis',
			'remember' => false
		];

		$status = $this->account->login($data);
		if ($status === true) {
			$_SESSION['user'] = $data['username'];
			$this->redirect('user');
		}
	}
}
