<?php
class Crud_model extends CI_Model{
	//custom query
	function custom($sql){
		return $this->db->query($sql);
	}
	//get all table data
	function get($tbl, $order="id ASC"){
		$this->db->order_by($order);
		return $this->db->get($tbl);
	}
	//get table data with where clause
	function get_where($tbl, $where, $order="id ASC"){
		$this->db->where($where);
		$this->db->order_by($order);
		return $this->db->get($tbl);
	}
	//LIMIT
	//get all table data with limit
	function get_limit($tbl, $order="id ASC", $limit, $start){
		$this->db->order_by($order);
		$this->db->limit($limit, $start);
		return $this->db->get($tbl);
	}
	//get table data with where clause
	function get_where_limit($tbl, $where, $order="id ASC", $limit, $start){
		$this->db->where($where);
		$this->db->order_by($order);
		$this->db->limit($limit, $start);
		return $this->db->get($tbl);
	}
	//COUNT
	//count all rows
	function get_count($tbl){
		return $this->db->count_all($tbl);
	}
	//count all rows with where clause
	function get_where_count($tbl, $where){
		$this->db->where($where);
		return $this->db->count_all($tbl);
	}
	//
	//inserts data into table
	function add($tbl, $data){
		$this->db->insert($tbl, $data);
	}
	//updates table with where clause
	function update($tbl, $data, $where){
		$this->db->where($where);
		$this->db->update($tbl, $data);
	}
	//inserts data if where clause does not exist, else updates
	function add_update($tbl, $data, $where){
		$result = $this->get_where($tbl, $where);
		if($result->num_rows()>0){
			$this->update($tbl, $data, $where);
		}
		else{
			$newdata = array_merge($data, $where);
			$this->add($tbl, $newdata);
		}
	}
	//delete table data with where clause
	function delete($tbl, $where){
		$this->db->where($where);
		$this->db->delete($tbl);
	}
}
