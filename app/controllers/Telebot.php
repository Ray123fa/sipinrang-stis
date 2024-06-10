<?php
class Telebot extends Controller
{
	private $bot;
	private $listStatus;
	private $peminjaman;
	private $account;
	private $user;

	public function __construct()
	{
		$this->bot = $this->model("TelebotModel");
		$this->listStatus = $this->model("StatusModel")->getAll();
		$this->peminjaman = $this->model("PeminjamanModel");
		$this->account = $this->model("AccountModel");
		$this->user = $this->model("UserModel");
	}

	public function index()
	{
		$this->bot->command("start", function ($ctx) {
			$respons = "Halo, saya bot peminjaman ruang di STIS.\nSilahkan gunakan perintah /help untuk melihat daftar perintah yang tersedia.";

			$opt = [
				"parse_mode" => "Markdown",
				"reply_to_message_id" => $ctx->messageId
			];
			$ctx->replyWithText($respons, $opt);
		});

		$this->bot->command("help", function ($ctx) {
			$respons = "Berikut adalah daftar perintah yang tersedia:\n\n";
			$respons .= "/start - Menampilkan pesan selamat datang\n";
			$respons .= "/help - Menampilkan daftar perintah yang tersedia\n";
			$respons .= "/cekstatus idpinjam - Cek status peminjaman ruang\n";
			$respons .= "/connect username_password - Menghubungkan akun Telegram dengan akun Sipinrang\n";
			$respons .= "/disconnect username_password - Memutuskan akun Telegram dengan akun Sipinrang\n";

			$opt = [
				"parse_mode" => "HTML",
				"reply_to_message_id" => $ctx->messageId
			];
			$ctx->replyWithText($respons, $opt);
		});

		$this->bot->command("cekstatus", function ($ctx) {
			$cmd = explode(" ", $ctx->text);
			if (count($cmd) < 2) {
				$respons = "Perintah tidak valid. Gunakan perintah /cekstatus disertai idpinjam";
			} else {
				$idpinjam = $cmd[1];
				$res = $this->peminjaman->getPeminjamanByIdPinjam($idpinjam);
				if ($res) {
					$respons = "Status peminjaman ruang dengan ID Peminjaman <b>$idpinjam</b> adalah <b>" . $this->listStatus[$res["status"] - 1]["status"] . "</b>.";
				} else {
					$respons = "Peminjaman ruang dengan ID Peminjaman <b>$idpinjam tidak ditemukan</b>.";
				}
			}

			$opt = [
				"parse_mode" => "HTML",
				"reply_to_message_id" => $ctx->messageId
			];
			$ctx->replyWithText($respons, $opt);
		});

		$this->bot->command("connect", function ($ctx) {
			$cmd = explode(" ", $ctx->text);
			if (count($cmd) < 2) {
				$respons = "Perintah tidak valid. Gunakan perintah /connect disertai username_password";
			} else {
				$auth = explode("_", $cmd[1], 2);
				if (count($auth) < 2) {
					$respons = "Perintah tidak valid. Gunakan perintah /connect disertai username_password";
				} else {
					$data = [
						"username" => $auth[0],
						"password" => $auth[1]
					];
					$res = $this->account->login($data);
					if ($res) {
						$respons = $this->user->addChatID($auth[0], $ctx->chatId);
					} else {
						$respons = "Username atau password yang dimasukkan salah.";
					}
				}
			}

			$opt = [
				"parse_mode" => "HTML",
				"reply_to_message_id" => $ctx->messageId
			];
			$ctx->replyWithText($respons, $opt);
		});

		$this->bot->command("disconnect", function ($ctx) {
			$cmd = explode(" ", $ctx->text);
			if (count($cmd) < 2) {
				$respons = "Perintah tidak valid. Gunakan perintah /disconnect disertai username_password";
			} else {
				$auth = explode("_", $cmd[1], 2);
				if (count($auth) < 2) {
					$respons = "Perintah tidak valid. Gunakan perintah /disconnect disertai username_password";
				} else {
					$data = [
						"username" => $auth[0],
						"password" => $auth[1]
					];
					$res = $this->account->login($data);
					if ($res) {
						$respons = $this->user->removeChatID($auth[0]);
					} else {
						$respons = "Username atau password yang dimasukkan salah.";
					}
				}
			}

			$opt = [
				"parse_mode" => "HTML",
				"reply_to_message_id" => $ctx->messageId
			];
			$ctx->replyWithText($respons, $opt);
		});

		$this->bot->run();
	}

	public function setWebhook()
	{
		$url = "";
		$res = $this->bot->setWebhook($url);
		echo $res;
	}

	public function deleteWebhook()
	{
		$res = $this->bot->deleteWebhook();
		echo $res;
	}
}
