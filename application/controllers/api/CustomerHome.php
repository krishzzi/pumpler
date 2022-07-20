<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CustomerHome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('userModel');
		$this->load->model('vehicleModel');
        $this->load->model('fuelModel');
		$this->load->helper('commons');
	}



	public function index()
	{

		$todayPetrol = $this->fuelModel->todayPetrol();

		$data = [
			'petrol' => [
				'price' => $todayPetrol[0]->price,
				'last_price' => $todayPetrol[1]->price,
				'difference' => ($todayPetrol[0]->price - $todayPetrol[1]->price)/100 . '%',
				'status' => $todayPetrol[0]->price > $todayPetrol[1]->price,
			],
			'about_us' => 'About us description',
		];

		return renderJson($data);


	}


    public function getMyRewards()
    {

        return renderJson($this->userModel->getMyRewards());


    }




}
