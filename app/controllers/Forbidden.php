<?php
class Forbidden extends Controller
{
	public function index()
	{
		$this->view("ErrorPage/403");
	}
}
