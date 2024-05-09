<?php
class NotFound extends Controller
{
	public function index()
	{
		$this->view("ErrorPage/404");
	}
}
