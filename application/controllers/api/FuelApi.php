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
                $result = $this->fuelModel->todayPetrol();
                if(is_object($result))
                {
                    return renderJson(ObjectToArray($result));
                }

            }
        }

    }


    public function index()
    {
        renderJson($this->fuelModel->getall());

    }

    public function show()
    {
        $id = 1;
        renderJson($this->fuelModel->getSingle($id));

    }






}
