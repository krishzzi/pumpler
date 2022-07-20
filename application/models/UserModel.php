<?php


class UserModel extends CI_Model
{

    protected $table = 'users';

    const CLIENT_SERVICE = 'frontend-client';
    const API_KEY = 'abcd123abcd';


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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



    public function sellerLogin($mobile, $password)
    {
        return $this->login($mobile, $password,'seller');
    }

    public function customerLogin($mobile, $password)
    {
        return $this->login($mobile, $password,'customer');
    }

    public function adminLogin($mobile, $password)
    {
        return $this->login($mobile, $password,'admin');
    }


    public function register($role='customer',$parent_id=null)
    {

        if(!$this->db->where('mobile',$this->input->get('mobile'))->get('users')->row())
        {
            $pp = $this->input->get('password') ?? 'password123';

            $user = $this->db->insert($this->table,[
                'username' => $this->input->get('username') ?? 'untitled User',
                'email' => $this->input->get('email') ?? '',
                'mobile' => $this->input->get('mobile') ?? '',
                'parent_id' => $parent_id,
                'has_role' => $role,
                'password' => password_hash($this->input->get('password') ?? 'password123',PASSWORD_DEFAULT),
            ]);


            if(!empty($this->input->get('vehicle_number')))
            {
                $existVehicle = $this->db->where('vehicle_number',$this->input->get('vehicle_number'))->get('vehicles')->row();
                if(!$existVehicle)
                {
                    $this->db->insert('vehicles',[
                        'vehicle_number' => $this->input->get('vehicle_number'),
                        'vehicle_type' => $this->input->get('vehicle_type'),
                        'user_id' => $user->id,
                    ]);
                }
            }

            renderJson(['id' => $this->db->insert_id()]);
        }else{
            renderJsonError('User Exist already!');
        }
    }




    public function login($mobile, $password,$role)
    {
        $exist = $this->db->where('mobile', $mobile)->where('has_role',$role)->get()->row();


        if ($exist) {
            if ($this->validClient() === true) {
                if (password_verify($password, $exist->password)) {
                    $last_login = date('Y-m-d H:i:s');
                    $token = crypt(substr(md5(rand()), 5), 'addedSalt');
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





    public function getMyRewards()
    {

        if($this->input->get('User-ID'))
        {
             $result = $this->db->where('user_id',$this->input->get('User-ID'))->get('user_rewards');
             return $result->result();
        }else{
            return [];
        }

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
        $existUser = $this->db->where('user_id',$users_id)->where('token',$token)->get('access_tokens')->row();

        $q  = $this->db->select('expire_at')->from('access_tokens')->where('user_id',$users_id)->where('token',$token)->get()->row();
        if($q == ""){
            renderJsonError('Unauthorized',401);
        } else {
            if($q->expired_at < date('Y-m-d H:i:s')){
                renderJsonError('Your session has been expired!',401);
            } else {
                $last_used_at = date('Y-m-d H:i:s');
                $expire_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->where('user_id',$users_id)->where('token',$token)->update('access_tokens',array('expire_at' => $expire_at,'last_used_at' => $last_used_at));
                return array('status' => 200,'message' => 'Authorized.');
            }
        }
    }









}
