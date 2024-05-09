<?php
class Telebot
{
	private $token;
	private $chat_id;
	private $message;
	private $api_url = 'https://api.telegram.org/bot';

	public function __construct($token, $chat_id, $message)
	{
		$this->token = $token;
		$this->chat_id = $chat_id;
		$this->message = $message;
	}

	public function sendMessage()
	{
		$url = $this->api_url . $this->token . '/sendMessage?chat_id=' . $this->chat_id . '&text=' . $this->message;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
}
