<?php

class CustomerApi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('userModel');
	}

	public function index ()
	{
		$data = $this->userModel->select()->where('role','customer')->where('is_admin',false)->all();
		if($data)
		{
			renderJson($data);
		}else{
			renderJsonError('Wrong Credential');
		}


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


	public function getDetails()
	{

		$user = $this->userModel->select()->from('users')->where('id',$_REQUEST['User-ID'])->where('role','customer')->get();
		if($user)
		{
			$user->password = null;
			renderJson(JsonToArray($user));
		}else{
			renderJsonError('Wrong id Provided!');
		}
	}

	public function getVehicleDetails()
	{

		$user = $this->userModel->select()->from('users')->where('vehicle_no',$_REQUEST['vehicle_no'])->get();
		if($user)
		{
			$user->password = null;
			renderJson(JsonToArray($user));
		}else{
			renderJsonError('Wrong id Provided!');
		}
	}



	public function register()
	{

		$inputs = $_REQUEST;


		if(!$this->userModel->select()->from('users')->where('vehicle_no',$inputs['vehicle_no'])->count())
		{
			$user = $this->userModel->create([
				'title' => $inputs['name'],
				'vehicle_no' => $inputs['vehicle_no'],
				'vehicle_type' => $inputs['vehicle_type'],
				'mobile' => $inputs['mobile'],
			]);


			renderJson(['id' => $this->userModel->lastID()]);
		}else{
			renderJsonError('User Exist already!');
		}

	}




}
