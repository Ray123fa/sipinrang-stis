<?php
class Whatsapp extends Controller
{
	private $bot;
	private $json;
	private $data;
	private $device;
	private $sender;
	private $message;
	private $text;
	private $name;

	private $listStatus;
	private $peminjaman;

	public function __construct()
	{
		header('Content-Type: application/json; charset=utf-8');

		$this->json = file_get_contents('php://input');
		$this->data = json_decode($this->json, true);
		$this->device = $this->data['device'];
		$this->sender = $this->data['sender'];
		$this->message = $this->data['message'];
		$this->text = $this->data['text'];
		$this->name = $this->data['name'];

		$this->bot = $this->model('WhatsappModel');
		$this->listStatus = $this->model("StatusModel")->getAll();
		$this->peminjaman = $this->model("PeminjamanModel");
	}

	public function index()
	{
		if ($this->message == "!start") {
			$msg = "Halo, saya bot peminjaman ruang di STIS.\nSilahkan gunakan perintah !help untuk melihat daftar perintah yang tersedia.";
		} else if ($this->message == "!help") {
			$msg = "Berikut adalah daftar perintah yang tersedia:\n\n";
			$msg .= "*!start* - Menampilkan pesan selamat datang\n";
			$msg .= "*!help* - Menampilkan daftar perintah yang tersedia\n";
			$msg .= "*!cekstatus idpinjam* - Cek status peminjaman ruang";
		} else if (strpos($this->message, "!cekstatus") === 0) {
			$arr = explode(" ", $this->message);
			if (count($arr) < 2) {
				$msg = "Perintah tidak valid. Gunakan perintah !cekstatus disertai idpinjam";
			} else {
				$idpinjam = $arr[1];
				$res = $this->peminjaman->getPeminjamanByIdPinjam($idpinjam);
				if ($res) {
					$msg = "Status peminjaman ruang dengan ID Peminjaman *$idpinjam* adalah *" . $this->listStatus[$res["status"] - 1]["status"] . "*.";
				} else {
					$msg = "Peminjaman ruang dengan ID Peminjaman *$idpinjam tidak ditemukan*.";
				}
			}
		} else {
			$msg = "Perintah tidak dikenali. Silahkan gunakan perintah !help untuk melihat daftar perintah yang tersedia.";
		}

		$reply = [
			"message" => $msg
		];
		$this->bot->sendFonnte($this->sender, $reply);
	}
}
