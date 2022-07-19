<?php

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

		return ($service == self::CLIENT_SERVICE && $apiKey == self::API_KEY) ? true : renderJsonError('unauthorized!',401);

	}





	protected function getTable()
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
		$this->db->select("*");
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
		$this->db->from($this->getTable());
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
		return $this->db->get()->result();
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
