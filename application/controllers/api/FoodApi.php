<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class FoodApi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('userModel');
		$this->load->model('foodModel');
		$this->load->helper('commons');
	}




	public function index()
	{
        renderJson($this->foodModel->getall());


	}


    public function show()
    {
        $id = 1;
        renderJson($this->foodModel->getSingle($id));

    }




}
