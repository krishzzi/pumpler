<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SellerApi extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('userModel');
		$this->load->helper('commons');
        $this->load->helper('tinkle');
	}

	public function index ()
	{

        return renderJson($this->userModel->getAll('seller'));


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
                $this->userModel->sellerLogin();
            }
        }

	}


    public function getAll()
    {
        return renderJson($this->userModel->getAll('seller'));
    }


    public function getDetails()
    {
        return renderJson(ObjectToArray($this->userModel->getSingle($this->input->get('User-ID'))));



    }




}
