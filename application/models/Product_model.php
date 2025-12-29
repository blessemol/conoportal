<?php
class Product_model extends CI_Model{
	function get_product(){
		$result = $this->db->get('product');
		return $result;
	}
	//
	function add($name, $price){
		$data = array('name'=>$name, 'price'=>$price);
		$this->db->insert('product', $data);
	}
	//
	function delete($id){
	    $sql = "delete from product where id = ?";
	    $this->db->query($sql, $id);
		/*$this->db->where('id', $id);
		$this->db->delete('product');*/
	}
	//
	function update($data, $where){
		$this->db->where($where);
		$this->db->update('product', $data);
	}
}