<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__.'\DBModel.php';
class UserModel extends DBModel
{


	protected $table = 'users';



	public function login($mobile,$password)
	{
		$exist = $this->select('id','vehicle_no','email','mobile')->where('mobile',$mobile)->getDB()->get()->row();

		if($exist)
		{
			if($this->validClient() === true)
			{
				if(password_verify($password,$exist->password))
				{

				}
			}else{
				renderJsonError('Bad Request!',400);
			}


		}else{

		}

	}






}
