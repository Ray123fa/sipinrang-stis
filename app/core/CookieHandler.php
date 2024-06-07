<?php
class CookieHandler {
	public static function encrypt($data, $key) {
		$method = "AES-256-CBC";
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
		$encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
		return base64_encode($encrypted . '::' . $iv);
	}

	public static function decrypt($data, $key) {
		$method = "AES-256-CBC";
		list($encrypted, $iv) = explode('::', base64_decode($data), 2);
		return openssl_decrypt($encrypted, $method, $key, 0, $iv);
	}
}