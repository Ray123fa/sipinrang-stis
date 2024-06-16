<?php
class Peminjaman extends Controller
{
	private $bot;
	private $username;
	private $unit;
	private $level;
	private $noWA;

	public function __construct()
	{
		if (!isset($_SESSION['user'])) {
			$this->redirect('login');
		}

		$this->bot = $this->model('WhatsappModel');
		$this->username = $_SESSION['user'];
		$this->unit = $this->model('UserModel')->getUnitByUsername($this->username);
		$this->level = $this->model('UserModel')->getLevelByUsername($this->username);
		$this->noWA = $this->model('UserModel')->getWAByUnit($this->unit);
	}

	public function index()
	{
		$this->redirect('dashboard');
	}

	public function tambah()
	{
		if (!isset($_POST['tambah'])) {
			$this->redirect('dashboard/tambah-peminjaman');
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
				$this->redirect('dashboard/tambah-peminjaman');
			} else {
				Flasher::setFlash('Peminjaman berhasil ditambahkan, tetapi notifikasi gagal dikirim!', 'warning', 'tambah-peminjaman');
				$this->redirect('dashboard/tambah-peminjaman');
			}
		} else {
			Flasher::setFlash('Peminjaman gagal ditambahkan', 'warning', 'tambah-peminjaman');
			$this->redirect('dashboard/tambah-peminjaman');
		}
	}

	public function edit($idpinjam = null)
	{
		if ($idpinjam == null) {
			$this->redirect('notfound');
		}

		if (!isset($_POST['simpan'])) {
			$this->redirect('dashboard/detail-peminjaman/' . $idpinjam);
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
				$this->redirect('dashboard/semua-peminjaman');
			} else {
				Flasher::setFlash('Peminjaman berhasil diperbarui, tetapi notifikasi gagal dikirim!', 'warning', 'semua-peminjaman');
				$this->redirect('dashboard/semua-peminjaman');
			}
		} else {
			Flasher::setFlash($res, 'warning', 'detail-peminjaman');
			$this->redirect('dashboard/detail-peminjaman/' . $idpinjam);
		}
	}

	public function delete($idpinjam = null)
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
				$this->redirect('dashboard/semua-peminjaman');
			} else {
				Flasher::setFlash('Peminjaman berhasil dihapus, tetapi notifikasi gagal dikirim!', 'warning', 'semua-peminjaman');
				$this->redirect('dashboard/semua-peminjaman');
			}
		} else {
			Flasher::setFlash($res, 'warning', 'semua-peminjaman');
			$this->redirect('dashboard/semua-peminjaman');
		}
	}
}
