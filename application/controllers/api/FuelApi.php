<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class FuelApi extends CI_Controller
{



    public function __construct()
    {
        parent::__construct();
        $this->load->model('userModel');
        $this->load->model('fuelModel');
        $this->load->helper('commons');
    }



    public function todayRate()
    {

        if(!empty($this->input->get('oil_type')))
        {
            if(strtolower($this->input->get('oil_type')) === 'petrol'){
                return $this->fuelModel->todayPetrol();
            }
        }

    }







}
