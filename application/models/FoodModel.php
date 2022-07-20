<?php
defined('BASEPATH') or exit('No direct script access allowed');


class FoodModel extends CI_Model
{

    protected $table = 'foods';


    public function getAll()
    {
        $this->db->select();
        return $this->db->get($this->table)->result();
    }


    public function getSingle($id)
    {
        $this->db->select();
        $this->db->where('id',$id);
        return $this->db->get($this->table)->row();
    }







}
