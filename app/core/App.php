<?php
class App
{
	protected $controller = 'Notfound';
	protected $method = 'index';
	protected $params = [];

	public function __construct()
	{
		$url = $this->parseUrl();

		// Controller
		if (file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')) {
			$this->controller = ucfirst($url[0]);
			unset($url[0]);
		}
		require_once '../app/controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller;

		// Method
		if (isset($url[1])) {
			if (method_exists($this->controller, str_replace("-", "_", $url[1]))) {
				$this->method = str_replace("-", "_", $url[1]);
				unset($url[1]);
			}
		}

		// Params
		if (!empty($url)) {
			$this->params = array_values($url);
		}

		// Jalankan controller & method, serta kirimkan params jika ada
		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	public function parseUrl()
	{
		if (isset($_GET['url'])) {
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', $url);
			return $url;
		}
	}
}
