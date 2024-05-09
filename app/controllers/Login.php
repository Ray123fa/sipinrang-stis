<?php
class Login extends Controller
{
	private $call;

	public function __construct()
	{
		if (isset($_SESSION['user'])) {
			$this->redirect('user');
		}

		$this->call = $this->model('AccountModel');
	}

	public function index()
	{
		$data = [
			'title' => 'Login',
			'css' => [
				'Account/Style.css',
				'flasher.css'
			]
		];

		$this->partial('Account/Header', $data);
		$this->view('login');
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
			'password' => $_POST['pass']
		];

		$status = $this->call->login($data);
		if ($status) {
			$_SESSION['user'] = $data['username'];
			if (isset($_SESSION['link'])) {
				$this->redirect($_SESSION['link']);
			} else {
				$this->redirect('user'); // dashboard
			}
		} else {
			Flasher::setFlash('Username atau password salah!', 'warning');
			$this->redirect('login');
		}
	}
}
