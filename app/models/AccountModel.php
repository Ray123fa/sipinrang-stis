<?php
class AccountModel
{
	protected $table = 'user';
	protected $db;

	public function __construct()
	{
		$this->db = new Database();
	}

	public function login($data)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', strtolower($data['username']));
		$row = $this->db->single();

		if ($this->db->rowCount() > 0) {
			if (password_verify($data['password'], $row['password'])) {
				return true;
			}
			return false;
		}

		return false;
	}

	public function register($data)
	{
		$username = $data['username'];
		$email = $data['email'];
		$unit = $data['unit'];
		$password = $this->db->quote($data['password']);
		$repassword = $this->db->quote($data['repassword']);
		$level = $data['level'];

		// Cek apakah username sudah ada
		$this->db->query('SELECT username FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', $username);
		$this->db->single();

		if ($this->db->rowCount() > 0) {
			return "Username sudah terdaftar pada sistem!";
		}

		// Cek apakah email berdomain STIS
		$domain = explode('@', $email)[1];
		if ($domain != 'stis.ac.id') {
			return "Email harus berdomain STIS!";
		}

		// Cek apakah password dan repassword sama
		if ($password != $repassword) {
			return "Password dan konfirmasi password tidak sesuai!";
		}
		$password = password_hash($password, PASSWORD_DEFAULT);

		// Insert data ke database
		$this->db->query('INSERT INTO ' . $this->table . ' (username, email, unit, password, level) VALUES (:username, :email, :unit, :password, :level)');
		$this->db->bind(':username', $username);
		$this->db->bind(':email', $email);
		$this->db->bind(':unit', $unit);
		$this->db->bind(':password', $password);
		$this->db->bind(':level', $level);

		$this->db->execute();
		if ($this->db->rowCount() > 0) {
			return true;
		} else {
			return "Gagal menambahkan data!";
		}
	}
}
