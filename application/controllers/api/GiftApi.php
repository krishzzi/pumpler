<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GiftApi extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('userModel');
		$this->load->model('giftModel');
		$this->load->helper('commons');
	}


	public function index()
	{
        renderJson($this->giftModel->getall());

	}

    public function show()
    {
        $id = 1;
        renderJson($this->giftModel->getSingle($id));

    }







}
