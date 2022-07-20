<?php



defined('BASEPATH') or exit('No direct script access allowed');


class FuelModel extends CI_Model
{

    protected $table = 'fuels';


    public function todayPetrol()
    {
        $date = new DateTime();
        $previousDay = $date->modify("-1 days")->format('Y-m-d');

//		$result = $this->db->query("SELECT * FROM `fuels` WHERE `type` = 'petrol'  AND `status` = true  AND `quantity` > 0 AND `created_at` > $previousDay");
//		$result = $this->db->get($this->table)->row();


        return $this->db->order_by('price', 'desc')->get($this->table)->result();
        // need to filter with date
        //dd($dds[1]);
    }


}
