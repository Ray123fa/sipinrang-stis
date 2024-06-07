<?php
class UserModel
{
	protected $table = 'user';
	protected $db;

	public function __construct()
	{
		$this->db = new Database;
	}

	public function isExistUsername($username)
	{
		$this->db->query('SELECT username FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', $username);
		$row = $this->db->single();

		return ($row) ? true : false;
	}

	public function isEmailSTIS($email)
	{
		$domain = explode('@', $email)[1];
		return ($domain == 'stis.ac.id') ? true : false;
	}

	public function getAll()
	{
		$this->db->query('SELECT * FROM ' . $this->table);
		$row = $this->db->resultSet();

		return $row;
	}

	public function getAllByUsername($username)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', $username);
		$row = $this->db->single();

		return $row;
	}

	public function getIdByUsername($username)
	{
		$this->db->query('SELECT id FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', $username);
		$row = $this->db->single();

		return $row['id'];
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

	public function getProfileImgPath($username)
	{
		$this->db->query('SELECT profile_img_path FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', $username);
		$row = $this->db->single();

		return $row['profile_img_path'];
	}

	public function editProfile($data)
	{
		$tempUser = $_SESSION['user'];
		unset($_SESSION['user']);

		if ($this->isExistUsername($data['username']) && $data['username'] != $tempUser) {
			return "Username sudah terdaftar pada sistem!";
		}

		if ($this->isEmailSTIS($data['email']) == false) {
			return "Email harus berdomain STIS!";
		}

		if (!empty($_FILES['profile_img']['name'])) {
			$fileNameOld = basename($_FILES['profile_img']['name']);
			$fileType = strtolower(pathinfo($fileNameOld, PATHINFO_EXTENSION));

			$fileNameNew = $data['username'] . '.' . $fileType;
			$targetFile = 'upload/' . $fileNameNew;
			$sourceFile = $_FILES['profile_img']['tmp_name'];
			$allowedType = ['jpg', 'jpeg', 'png'];

			// Cek ekstensi file
			if (!in_array($fileType, $allowedType)) {
				return "Ekstensi file tidak diizinkan!";
			}

			// Cek ukuran file
			if ($_FILES['profile_img']['size'] > 2 * 1024 * 1024) {
				return "Ukuran file terlalu besar! Maksimal 2MB.";
			}

			// Hapus file lama
			foreach (glob('upload/' . $data['username'] . '.(jpg|jpeg|png)') as $file) {
				unlink($file);
			}

			// Pindahkan file ke folder upload
			if (move_uploaded_file($sourceFile, $targetFile)) {
				$this->db->query('UPDATE ' . $this->table . ' SET username = :username, email = :email, profile_img_path = :profile_img_path WHERE id = :id');
				$this->db->bind(':username', $data['username']);
				$this->db->bind(':email', $data['email']);
				$this->db->bind(':profile_img_path', $targetFile);
				$this->db->bind(':id', $data['id']);
				$this->db->execute();
			} else {
				return "Gagal mengubah profil!";
			}
		} else {
			$this->db->query('UPDATE ' . $this->table . ' SET username = :username, email = :email WHERE id = :id');
			$this->db->bind(':username', $data['username']);
			$this->db->bind(':email', $data['email']);
			$this->db->bind(':id', $data['id']);
			$this->db->execute();
		}
		unset($tempUser);
		$_SESSION['user'] = $data['username'];

		return true;
	}

	public function changePassword($data, $username)
	{
		$this->db->query('SELECT password FROM ' . $this->table . ' WHERE username = :username');
		$this->db->bind(':username', $username);
		$row = $this->db->single();

		if (password_verify($data['old-pass'], $row['password'])) {
			if ($data['new-pass'] == $data['renew-pass']) {
				$password = password_hash($data['new-pass'], PASSWORD_DEFAULT);

				$this->db->query('UPDATE ' . $this->table . ' SET password = :password WHERE username = :username');
				$this->db->bind(':password', $password);
				$this->db->bind(':username', $username);
				$this->db->execute();

				if ($this->db->rowCount() > 0) {
					return true;
				} else {
					return "Password gagal diubah";
				}
			} else {
				return "Konfirmasi password baru tidak sesuai";
			}
		} else {
			return "Password lama salah";
		}
	}

	public function addChatID($username, $chatID)
	{
		$this->db->query('UPDATE ' . $this->table . ' SET chat_id = :chat_id WHERE username = :username');
		$this->db->bind(':chat_id', $chatID);
		$this->db->bind(':username', $username);
		$this->db->execute();

		if ($this->db->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
}
