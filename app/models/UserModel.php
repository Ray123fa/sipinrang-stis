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

		if (!empty($_FILES['profile_img']['name'])) {
			$fileNameOld = basename($_FILES['profile_img']['name']);
			$fileType = strtolower(pathinfo($fileNameOld, PATHINFO_EXTENSION));

			$fileNameNew = $data['username'] . '.' . $fileType;
			$targetFile = 'upload/' . $fileNameNew;
			$sourceFile = $_FILES['profile_img']['tmp_name'];
			$allowedType = ['jpg', 'jpeg', 'png'];

			// Cek ekstensi file
			if (!in_array($fileType, $allowedType)) {
				Flasher::setFlash('Ekstensi file tidak didukung', 'warning');
				header('Location: ' . BASE_URL . 'user/profile');
				exit;
			}

			// Cek ukuran file
			if ($_FILES['profile_img']['size'] > 2 * 1024 * 1024) {
				Flasher::setFlash('Ukuran file terlalu besar! Maksimal 2MB.', 'warning');
				header('Location: ' . BASE_URL . 'user/profile');
				exit;
			}

			// Hapus file lama
			foreach (glob('upload/' . $data['username'] . '.(jpg|jpeg|png)') as $file) {
				unlink($file);
			}

			// Pindahkan file ke folder upload
			if (move_uploaded_file($sourceFile, $targetFile)) {
				$this->db->query('UPDATE ' . $this->table . ' SET username = :username, email = :email, profile_img_path = :profile_img_path WHERE id = :id');

				if ($this->isExistUsername($data['username']) && $data['username'] != $tempUser) {
					Flasher::setFlash('Username sudah terdaftar pada sistem!', 'warning');
					header('Location: ' . BASE_URL . 'user/profile');
					exit;
				}

				if (!$this->isEmailSTIS($data['email'])) {
					Flasher::setFlash('Email harus berdomain STIS!', 'warning');
					header('Location: ' . BASE_URL . 'user/profile');
					exit;
				}

				$this->db->bind(':username', $data['username']);
				$this->db->bind(':email', $data['email']);
				$this->db->bind(':profile_img_path', $targetFile);
				$this->db->bind(':id', $data['id']);
				$this->db->execute();

				$_SESSION['user'] = $data['username'];
				Flasher::setFlash('Profil berhasil diubah', 'success');
				header('Location: ' . BASE_URL . 'user/profile');
				exit;
			} else {
				Flasher::setFlash('Profil gagal diubah', 'warning');
				header('Location: ' . BASE_URL . 'user/profile');
				exit;
			}
		} else {
			$this->db->query('UPDATE ' . $this->table . ' SET username = :username, email = :email WHERE id = :id');

			if ($this->isExistUsername($data['username']) && $data['username'] != $tempUser) {
				Flasher::setFlash('Username sudah terdaftar pada sistem!', 'warning');
				header('Location: ' . BASE_URL . 'user/profile');
				exit;
			}

			if (!$this->isEmailSTIS($data['email'])) {
				Flasher::setFlash('Email harus berdomain STIS!', 'warning');
				header('Location: ' . BASE_URL . 'user/profile');
				exit;
			}

			$this->db->bind(':username', $data['username']);
			$this->db->bind(':email', $data['email']);
			$this->db->bind(':id', $data['id']);
			$this->db->execute();

			$_SESSION['user'] = $data['username'];
			Flasher::setFlash('Profil berhasil diubah', 'success');
			header('Location: ' . BASE_URL . 'user/profile');
			exit;
		}
		unset($tempUser);
	}
}
