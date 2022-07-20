<?php


defined('BASEPATH') or exit('No direct script access allowed');


class GiftModel extends CI_Model
{

    protected $table = 'gifts';




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
