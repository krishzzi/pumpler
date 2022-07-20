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
		$giftList = $this->giftModel->where('status',true)->all();
		if(!empty($giftList))
		{
			renderJson($giftList);
		}else{
			renderJsonError('no record found');
		}

	}







}
