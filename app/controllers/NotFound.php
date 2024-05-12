<?php
class Notfound extends Controller
{
	public function index()
	{
		$this->view("ErrorPage/404");
	}
}
