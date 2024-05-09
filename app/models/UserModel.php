<?php
class UserModel
{
	protected $table = 'user';
	protected $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function getAllByUsername($username)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', $username);
		$row = $this->db->single();

		return $row;
	}

	public function getUnitByUsername($username)
	{
		$this->db->query('SELECT unit FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', $username);
		$row = $this->db->single();

		return $row['unit'];
	}

	public function getLevelByUsername($username)
	{
		$this->db->query('SELECT level FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', $username);
		$row = $this->db->single();

		return $row['level'];
	}

	public function editProfile($data, $username)
	{
		
	}
}
