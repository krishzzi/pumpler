<?php
namespace App\Models\old;

use App\Models\Exception;
use App\Models\Throwable;

use function renderJsonError;

abstract class DBModel extends CI_Model
{
	const CLIENT_SERVICE = 'frontend-client';
	const API_KEY = 'abcd123abcd';
	protected  $table='';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}




	public function validClient()
	{
		$service = $this->input->get_request_header('Client-Service',true);
		$apiKey = $this->input->get_request_header('Api-Key',true);
		if(!empty($service) && !empty($apiKey))
		{
			return ($service == self::CLIENT_SERVICE && $apiKey == self::API_KEY) ? true : renderJsonError('unauthorized!',401);
		}else{
			return false;
		}


	}



	public function auth()
	{
		$users_id  = $this->input->get_request_header('User-ID', TRUE);
		$token     = $this->input->get_request_header('Auth-Token', TRUE);
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





	public function getTable()
	{
		try {
			if(empty($this->table))
			{
				throw new Exception('Model Name Missing!');
			}else{
				return $this->table;
			}
		}catch (Throwable $t)
		{
			$t->getMessage();
		}
	}



	public function create(array $data=[])
	{
		return $this->db->insert($this->getTable(),$data);
	}

	public function update(int $id,array $data=[])
	{
		return $this->db->where('id',$id)->update($this->getTable(),$data);
	}


	public function remove(int $id)
	{
		return $this->db->where('id',$id)->delete($this->getTable());
	}

	public function lastID()
	{
		return $this->db->insert_id();
	}


	/**
	 * @return array|array[]|object|object[]
	 */
	public function all()
	{
		return $this->db->get($this->getTable())->result();
	}

	public function getOnly(...$columns)
	{

		$this->db->select('"'.implode(',',$columns).'"');
		$this->db->from($this->getTable());
		return $this->db->get()->result();
	}


	public function select(...$fields)
	{
		if(!empty($fields))
		{
			$this->db->select('"'.implode(',',$fields).'"');
		}else{
			$this->db->select("*");
		}
		return $this;
	}

	public function from(string $table='')
	{
		$table = $table ?? $this->getTable();
		$this->db->from($table);
		return $this;
	}

	public function where($field, $value)
	{
		$this->db->where($field,$value);
		return $this;
	}

	public function limit(int $value=1,int $offset=20)
	{
		$this->db->limit($value,$offset);
		return $this;
	}

	public function get()
	{
		return $this->db->get()->row();
	}


	public function count()
	{
		return $this->db->count_all_results();
	}


	public function getDB()
	{
		return $this->db;
	}





}
