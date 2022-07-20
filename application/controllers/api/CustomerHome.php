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
        $this->load->helper('tinkle');
	}



	public function index()
	{

		$todayPetrol = $this->fuelModel->todayPetrol();



		$data = [
			'petrol' => [
				'price' => $todayPetrol->price,
				'last_price' => $todayPetrol->price,
				'difference' => ($todayPetrol->price - $todayPetrol->price)/100 . '%',
				'status' => $todayPetrol->price > $todayPetrol->price,
			],
			'about_us' => 'About us description',
            'myReward' => $this->userModel->getMyRewards()
		];

		return renderJson($data);


	}


    public function placeFuelOrder()
    {
        return $this->fuelModel->placeOrder();
    }


    public function getMyRewards()
    {

        return renderJson($this->userModel->getMyRewards());


    }




}
