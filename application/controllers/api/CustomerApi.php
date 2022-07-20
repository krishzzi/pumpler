<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CustomerApi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('vehicleModel');
		$this->load->helper('commons');
        $this->load->helper('tinkle');
	}

	public function index ()
	{
		$data = $this->vehicleModel->getall();
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
			if($this->vehicleModel->validClient() == true)
			{
				$this->vehicleModel->login();
			}
		}

	}


	public function getAll()
	{

		$user = $this->vehicleModel->getAll();

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

		$data = $this->vehicleModel->getVehicleDetailViaNumber();
		if($data)
		{
            $data->password = null;
			renderJson(ObjectToArray($data));
		}else{
			renderJsonError('Wrong id Provided!');
		}
	}



	public function register()
	{
        if(request()->isPost)
        {
            $this->vehicleModel->register();
        }else{
            renderJsonError('Method Not Supported');
        }

	}



	public function changePassword()
	{

		$inputs = $_REQUEST;
		$pp = $inputs['password'];
		$uid = $inputs['User-ID'];

		if($this->vehicleModel->select()->from('users')->where('id',$uid)->count())
		{



			if($this->vehicleModel->update($uid,[
				'password' => password_hash($pp,PASSWORD_DEFAULT)
			])){
				sendJSON('password changed successfully');
			}else{
				renderJsonError('Unexpected Error Happen');
			}



		}else{
			renderJsonError('User not Exist!');
		}


	}









}
