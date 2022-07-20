	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class OrderController extends CI_Controller
	{


		public function __construct()
		{
			parent::__construct();
			$this->load->model('userModel');
			$this->load->model('fuelModel');
			$this->load->model('userFuelModel');
			$this->load->helper('tinkle');
		}



		public function createFuelOrder()
		{

		}

		public function createFoodOrder()
		{

		}

		public function createGiftOrder()
		{

		}



		public function getAllFuelTransaction()
		{

		}




	}
