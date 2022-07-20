<?php

namespace App\Models\old;

use function password_verify;
use function renderJson;
use function renderJsonError;

defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends DBModel
{


    protected $table = 'users';


    public function login($mobile, $password)
    {
        $exist = $this->select()->from($this->table)->where('mobile', $mobile)->getDB()->get()->row();


        if ($exist) {
            if ($this->validClient() === true) {
                if (password_verify($password, $exist->password)) {
                    $last_login = date('Y-m-d H:i:s');
                    $token = crypt(substr(md5(rand()), 5), 'addedSalt');
                    $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));

//					$this->db->trans_start();
//					$this->db->where('id',$exist->id)->update('users',['last_login' => $last_login]);
                    $existAccessToken = $this->select()->from('access_tokens')->where('user_id', $exist->id)->get();

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


}
