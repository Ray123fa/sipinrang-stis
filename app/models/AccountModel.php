<?php
class AccountModel
{
	protected $table = 'user';
	protected $db;

	public function __construct()
	{
		$this->db = new Database();
	}

	public function isClickRemember($data, $remember)
	{
		if ($remember) {
			$cookieUsername = CookieHandler::encrypt($data['username'], 'REMEMBER_ME');
			$cookiePassword = CookieHandler::encrypt($data['password'], 'REMEMBER_ME');
			setcookie('username', $cookieUsername, time() + 60 * 60 * 24 * 30, '/');
			setcookie('password', $cookiePassword, time() + 60 * 60 * 24 * 30, '/');
		} else {
			setcookie('username', '', time() - 2592000, '/');
			setcookie('password', '', time() - 2592000, '/');
		}
	}

	public function login($data)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', strtolower($data['username']));
		$row = $this->db->single();

		if ($this->db->rowCount() > 0) {
			if (password_verify($data['password'], $row['password'])) {
				$this->isClickRemember($data, $data['remember']);
				return true;
			}
			return false;
		}

		return false;
	}
}
