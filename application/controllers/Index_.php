<?php
class Index extends CI_Controller{
	//
	function __construct(){
		parent::__construct();
		$this->load->model('crud_model');
	}
	//
	function index(){
		if($this->session->userdata('sloggedin')){
			redirect('personal_info');
		}
		else{
			$this->load->view('index_view');
		}
	}
	//
	function login(){
		if($this->input->post('lbtn')){
			$appno = trim(strtoupper($this->input->post('appno')));
			if($appno){
				$where = ['appno'=>$appno];
				$val = $this->crud_model->get_where('student', $where);
				if($val->num_rows()>0){
					$data = $val->row_array();
					$fname = ucfirst(strtolower($data['firstname']));
					$mname = ucfirst(strtolower($data['middlename']));
					$lname = strtoupper($data['lastname']);
					$sessdata = array('appno'=>$appno, 'sloggedin'=>TRUE);
					$this->session->set_userdata($sessdata);
					redirect('personal_info');
				}
				else{
					$msg = "EInvalid Application Number";
					$this->session->set_flashdata('msg', $msg);
					redirect('index');
				}
			}
			else{
				$this->session->set_flashdata('msg', 'EApplication Number field cannot be empty');
				redirect('index');
			}
		}
		else{
			redirect('index');
		}
	}
}
