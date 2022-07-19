<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AccountController extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('userModel');
	}

	public function index()
	{
		dd($this->userModel->select()->where('mobile',662244)->where('status',true)->get());
//		$this->load->helper('url');
//		$this->load->view('admin/dashboard');
	}


	public function login()
	{
		echo "Hello Login";
	}



}
