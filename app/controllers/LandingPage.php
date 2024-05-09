<?php
class LandingPage extends Controller
{
	public function index()
	{
		$data = [
			'css' => ['Welcome/Index.css'],
			'js' => ['Welcome.js'],
		];

		$this->partial('Welcome/Header', $data);
		$this->partial('Welcome/Navbar', $data);
		$this->view('welcome');
		$this->partial('Welcome/Footer');
		$this->partial('Welcome/Scripts', $data);
	}
}
