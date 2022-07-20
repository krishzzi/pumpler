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

		$giftList = $this->foodModel->where('status',true)->all();
		if($giftList)
		{
			renderJson($giftList);
		}else{
			renderJsonError('no record found');
		}



	}





}
