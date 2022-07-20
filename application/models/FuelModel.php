<?php



defined('BASEPATH') or exit('No direct script access allowed');


class FuelModel extends CI_Model
{

    protected $table = 'fuels';


    public function todayPetrol()
    {
        $date = new DateTime();
        $previousDay = $date->modify("-1 days")->format('Y-m-d');
        return $this->db->where('oil_type','petrol')->order_by('price','DESC')->get($this->table)->row();

    }

    public function getAll()
    {
        $this->db->select();
        return $this->db->get($this->table)->result();
    }


    public function getSingle($id)
    {
        $this->db->select();
        $this->db->where($id);
        return $this->db->get($this->table)->row();
    }


    public function placeOrder()
    {

        if($this->db->where('id',$this->input->get('customer_id'))->get('users')->row())
        {
            if($this->input->get('vehicle_number') !== null && $this->input->get('fuel_id') !== null && $this->input->get('customer_id') !== null)
            {
                $vehicleData = $this->db->where('vehicle_number',$this->input->get('vehicle_number'))->get('vehicles')->row();
                $fuelDetails = $this->db->where('id',$this->input->get('fuel_id'))->get('fuels')->row();

                $this->db->insert('user_fuels',[
                    'user_id' => $this->input->get('customer_id'),
                    'fuel_id' => $fuelDetails->id,
                    'vehicle_id' => $vehicleData->id,
                    'nozzle_id' => $this->input->get('nozzle_id') ?? null,
                    'quantity' => $this->input->get('quantity') ?? null,
                    'price' => $fuelDetails->price * $this->input->get('quantity'),
                    'discount' => $fuelDetails->price * $this->input->get('quantity') - ($fuelDetails->reward_value  * $this->input->get('quantity')),
                    'amount' => ($fuelDetails->price * $this->input->get('quantity')) - ($fuelDetails->price * $this->input->get('quantity') - ($fuelDetails->reward_value  * $this->input->get('quantity'))),
                ]);

                // update Reward

                $this->db->insert('user_rewards',[
                    'user_id' =>  $this->input->get('customer_id'),
                    'vehicle_number' => $this->input->get('vehicle_number'),
                    'reward_point' => $fuelDetails->reward_value  * $this->input->get('quantity'),
                    'action_type' => 'fuel_purchase'
                ]);

                //update Fuel Quantity

                $this->db->where('id',$fuelDetails->id)->update('fuels',[
                    'quantity' => $fuelDetails->quantity - $this->input->get('quantity')
                ]);


                sendJSON('Order Place Successfully');



            }else{
                renderJsonError('fuel_id,quantity,vehicle_number  fields are required');
            }
        }else{
            renderJsonError('invalid customer id');
        }












    }


}
