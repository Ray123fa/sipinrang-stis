<?php
class Controller
{
	public function view($view, $data = [])
	{
		require_once '../app/views/' . $view . '.php';
	}

	public function partial($partial, $data = [])
	{
		require_once '../app/partials/' . $partial . '.php';
	}

	public function helper($helper, $data = [])
	{
		require_once '../app/helpers/' . $helper . '.php';
	}

	public function model($model)
	{
		require_once '../app/models/' . $model . '.php';
		return new $model;
	}

	public function redirect($url)
	{
		header('Location: ' . BASE_URL . $url);
		exit;
	}
}
