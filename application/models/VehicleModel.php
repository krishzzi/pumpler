<?php

class VehicleModel extends CI_Model
{

    protected $table = 'vehicles';

    const CLIENT_SERVICE = 'frontend-client';
    const API_KEY = 'abcd123abcd';


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



    public function login()
    {
        $exist = $this->db->where('vehicle_number', $this->input->get('vehicle_number') )->where('status',true)->get($this->table)->row();



        if ($exist) {

            if ($this->validClient() === true) {

                if (password_verify($this->input->get('password') , $exist->password)) {
                  ;
                    $last_login = date('Y-m-d H:i:s');
                    $token = token();
                    $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));

//					$this->db->trans_start();
//					$this->db->where('id',$exist->id)->update('users',['last_login' => $last_login]);
                    $existAccessToken = $this->db->where('user_id', $exist->id)->get('access_tokens');

//					dd($existAccessToken);

                    if (!$existAccessToken) {
                        if ($this->db->insert('access_tokens', [
                            'user_id' => $exist->id,
                            'token' => $token,
                            'last_used_at' => $last_login,
                            'expire_at' => $expired_at
                        ])) {
                            renderJson([
                                'status' => 200,
                                'message' => 'Successfully login first time.',
                                'id' => $exist->id,
                                'token' => $token
                            ], 200);
                        } else {
                            renderJsonError('Internal server error', 500);
                        }


                    } else {

                        if ($this->db->where('user_id', $exist->id)->update('access_tokens', [
                            'user_id' => $exist->id,
                            'token' => $token,
                            'last_used_at' => $last_login,
                            'expire_at' => $expired_at
                        ])) {
                            renderJson([
                                'status' => 200,
                                'message' => 'Successfully login.',
                                'id' => $exist->id,
                                'token' => $token
                            ], 200);
                        } else {
                            renderJsonError('Internal server error', 500);
                        }

                    }

                } else {
                    renderJsonError('Wrong Credential');
                }
            } else {
                renderJsonError('Bad Request!', 400);
            }


        } else {
            renderJsonError('Wrong Credential, No User Found With This Number', 204);
        }
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



    public function register($parent_id=null)
    {

        if(!$this->db->where('vehicle_number',$this->input->get('vehicle_number'))->get($this->table)->row())
        {
            $pp = $this->input->get('password') ?? 'password123';

            $user = $this->db->insert('users',[
                'username' => $this->input->get('username') ?? 'untitled User',
                'email' => $this->input->get('email') ?? '',
                'mobile' => $this->input->get('mobile') ?? '',
                'parent_id' => $parent_id,
                'has_role' => 'customer',
                'password' => password_hash($this->input->get('password') ?? 'password123',PASSWORD_DEFAULT),
            ]);

            $customerID = $this->db->insert_id();

            if(!empty($this->input->get('vehicle_number')))
            {
                $existVehicle = $this->db->where('vehicle_number',$this->input->get('vehicle_number'))->get('vehicles')->row();
                if(!$existVehicle)
                {
                    $this->db->insert('vehicles',[
                        'vehicle_number' => $this->input->get('vehicle_number'),
                        'vehicle_type' => $this->input->get('vehicle_type'),
                        'user_id' => $customerID,
                        'password' => password_hash($this->input->get('password') ?? 'password123',PASSWORD_DEFAULT),
                    ]);
                    $vehicleID = $this->db->insert_id();
                }
            }


            if(!empty($this->input->get('fuel_id')) && !empty($this->input->get('quantity')))
            {
                $fuelDetails = $this->db->where('id',$this->input->get('fuel_id'))->get('fuels')->row();

                $this->db->insert('user_fuels',[
                    'user_id' => $customerID,
                    'fuel_id' => $fuelDetails->id,
                    'vehicle_id' => $vehicleID,
                    'nozzle_id' => $this->input->get('nozzle_id') ?? null,
                    'quantity' => $this->input->get('quantity') ?? null,
                    'price' => $fuelDetails->price * $this->input->get('quantity'),
                    'discount' => $fuelDetails->price * $this->input->get('quantity') - ($fuelDetails->reward_value  * $this->input->get('quantity')),
                    'amount' => ($fuelDetails->price * $this->input->get('quantity')) - ($fuelDetails->price * $this->input->get('quantity') - ($fuelDetails->reward_value  * $this->input->get('quantity'))),
                ]);


                // update Reward

                $this->db->insert('user_rewards',[
                   'user_id' =>  $customerID,
                    'vehicle_number' => $this->input->get('vehicle_number'),
                    'reward_point' => $fuelDetails->reward_value  * $this->input->get('quantity'),
                    'action_type' => 'registration'
                ]);

            }





            renderJson([
                'customer_id' => $customerID,
                'vehicle_id' => $vehicleID
            ]);
        }else{
            renderJsonError('Vehicle Exist already!');
        }
    }



    public function getVehicleDetailViaNumber()
    {
        return $this->db->where('vehicle_number',$this->input->get('vehicle_number'))->get('vehicles')->row();
    }





    public function validClient()
    {
        $clientService = $this->input->get_request_header('Client-Service',true);
        $apiKey = $this->input->get_request_header('Api-Key',true);
        if(!empty($clientService) && !empty($apiKey))
        {
            return ($clientService == self::CLIENT_SERVICE && $apiKey == self::API_KEY) ? true : renderJsonError('unauthorized!',401);
        }else{
            return false;
        }

    }


    public function auth()
    {
        $users_id  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Auth-Token', TRUE);

        $this->db->select('expire_at');
        $existUser = $this->db->where('vehicle_id',$users_id)->where('token',$token)->get('access_tokens')->row();

        $q  = $this->db->select('expire_at')->from('access_tokens')->where('vehicle_id',$users_id)->where('token',$token)->get()->row();
        if($q == ""){
            renderJsonError('Unauthorized',401);
        } else {
            if($q->expired_at < date('Y-m-d H:i:s')){
                renderJsonError('Your session has been expired!',401);
            } else {
                $last_used_at = date('Y-m-d H:i:s');
                $expire_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->where('vehicle_id',$users_id)->where('token',$token)->update('access_tokens',array('expire_at' => $expire_at,'last_used_at' => $last_used_at));
                return array('status' => 200,'message' => 'Authorized.');
            }
        }
    }










}
