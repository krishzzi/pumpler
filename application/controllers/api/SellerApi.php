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

		$data = $this->userModel->getall();
		renderJson($data);


	}


    public function register()
    {
        if(request()->isPost && !empty($this->input->get('mobile')) && $this->input->get('password'))
        {
            return $this->userModel->register('seller');
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


    public function getAll()
    {
        return renderJson($this->userModel->getAll());
    }


    public function getDetails()
    {
        return renderJson(ObjectToArray($this->userModel->getSingle($this->input->get('User-ID'))));
    }




}
