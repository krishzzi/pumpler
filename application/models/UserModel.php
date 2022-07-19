<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__.'\DBModel.php';
class UserModel extends DBModel
{


	protected $table = 'users';



	public function login($mobile,$password)
	{
		$exist = $this->select()->from($this->table)->where('mobile',$mobile)->getDB()->get()->row();

		dd(hash_equals($exist->password,password_hash($password,PASSWORD_DEFAULT)));

		if($exist)
		{
			if($this->validClient() === true)
			{
				if(password_verify($password,$exist->password))
				{
					$last_login = date('Y-m-d H:i:s');
					$token = crypt(substr( md5(rand()), 0, 7));
					$expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));

					$this->db->trans_start();
					$this->db->where('id',$exist->id)->update('users',['last_login' => $last_login]);
					$this->db->insert('access_tokens',[
						'user_id' => $exist->id,
						'token' => $token,
						'last_used_at' => $last_login,
						'expired_at' => $expired_at
					]);
					if ($this->db->trans_status() === FALSE){
						$this->db->trans_rollback();
						 renderJsonError('Internal server error',500);
					} else {
						$this->db->trans_commit();
						return renderJson([
							'status' => 200,
							'message' => 'Successfully login.',
							'id' => $exist->id,
							'token' => $token
						],200);
					}


				}else{
					 renderJsonError('Wrong Credential');
				}
			}else{
				renderJsonError('Bad Request!',400);
			}


		}else{
			renderJsonError('Wrong Credential, No User Found With This Number',204);
		}

	}






}
