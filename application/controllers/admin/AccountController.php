<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AccountController extends CI_Controller
{


	public function index()
	{
		$this->load->view('admin/dashboard');
	}


	public function login()
	{
		echo "Hello Login";
	}



}
