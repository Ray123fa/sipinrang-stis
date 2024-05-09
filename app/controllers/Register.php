<?php
class Register extends Controller
{
	private $call;

	public function __construct()
	{
		$this->call = $this->model('AccountModel');
	}

	public function index()
	{
		$data = [
			'title' => 'Register',
			'css' => [
				'Account/Style.css',
				'flasher.css'
			]
		];

		$this->partial('Account/Header', $data);
		$this->view('register');
		$this->partial('Account/Footer');
	}

	public function do()
	{
		(!isset($_POST['register'])) ? $this->redirect('register') : null;

		$data = [
			'username' => strtolower(strip_tags(stripslashes($_POST['username']))),
			'email' => strip_tags($_POST['email']),
			'unit' => strtoupper(strip_tags(stripslashes($_POST['unit']))),
			'password' => $_POST['pass'],
			'repassword' => $_POST['repass'],
			'level' => (int) $_POST['level']
		];

		$status = $this->call->register($data);

		if ($status === true) {
			Flasher::setFlash('Registrasi berhasil!', 'success');
			$this->redirect('login');
		} else {
			Flasher::setFlash($status, 'warning');
			$this->redirect('register');
		}
	}
}
