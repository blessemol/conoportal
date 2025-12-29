<?php
class Login_model extends CI_Model{
	function validate($table, $data){
		$this->db->where($data);
		return $this->db->get($table, 1);
	}
	//update table
	function updateQry($table, $data, $where){
		$this->db->where($where);
		$this->db->update($table, $data);
	}
}