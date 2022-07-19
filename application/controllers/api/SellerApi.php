<?php

class SellerApi extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('userModel');
	}

	public function index ()
	{
		$data = $this->userModel->select()->where('role','staff')->where('is_admin',false)->get();



		return renderJson($data);
	}



	public function login($mobile,$password)
	{

		$this->userModel->login($mobile,$password);

	}


}
