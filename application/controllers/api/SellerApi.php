<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SellerApi extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('userModel');
		$this->load->helper('commons');
	}

	public function index ()
	{

		$data = $this->userModel->select()->where('role','seller')->where('is_admin',false)->all();
		renderJson($data);


	}



	public function login()
	{

		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			renderJsonError('Bad request',400);
		} else {
			if($this->userModel->validClient() == true)
			{
				$mobile = $_REQUEST['mobile'];
				$password = $_REQUEST['password'];
				$this->userModel->login($mobile,$password);
			}
		}

	}


}
