<?php
class Personal_info extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('crud_model');
		$this->loggedin();
	}
	//
	private function loggedin(){
		if(!$this->session->userdata('sloggedin')){
			redirect('index');
		}
	}
	//
	function index(){
		$data['page'] = "personal_info";
		$appno = $this->session->userdata('appno');
		$where = array('appno'=>$appno);
		$data['userdet'] = $udet = $this->crud_model->get_where('student', $where);
		$udet = $udet->row_array();
		$admsess = $udet['admsess'];
		$cat = studentCat($admsess);
		$data['activesess'] = activeSess($cat);
		$this->load->view('personalinfo_view', $data);
	}
	//
	function submit(){
		//upload config
		$config['upload_path'] = "./uploads/passports/";
		$config['allowed_types'] = "gif|jpg|jpeg|png";
		$config['max_size'] = 500;
		if($this->input->post('sbtn')){
			$appno = $this->input->post('appno');
			$fname = ucfirst(strtolower($this->input->post('fname')));
			$mname = ucfirst(strtolower($this->input->post('mname')));
			$lname = strtoupper($this->input->post('lname'));
			$level = $this->input->post('level');
			$gender = $this->input->post('gender');
			$phone = $this->input->post('phone');
			$email = strtolower($this->input->post('email'));
			$dob = $this->input->post('dob');
			$address = $this->input->post('address');
			if($appno && $lname){
				//passport upload
				$config['file_name'] = $appno;
				$this->load->library('upload', $config);
				if($this->upload->do_upload('userfile')){
					$ret = $this->upload->data();
					$path = base_url().str_replace("./", "", $config['upload_path']).$ret['file_name'];
					$msg = "SPersonal information updated successfully";
					$data = array('firstname'=>$fname, 'middlename'=>$mname, 'level'=>$level, 'gender'=>$gender, 'phone'=>$phone, 'email'=>$email, 'dob'=>$dob, 'address'=>$address, 'picpath'=>$path);
				}
				else{
					$msg = "EPersonal information updated successfully, but...<br><strong>".$this->upload->display_errors()."</strong>";
					$data = array('firstname'=>$fname, 'middlename'=>$mname, 'level'=>$level, 'gender'=>$gender, 'phone'=>$phone, 'email'=>$email, 'dob'=>$dob, 'address'=>$address);
				}
				$where = array('appno'=>$appno);
				$this->crud_model->update('student', $data, $where);
				$this->session->set_flashdata('msg', $msg);
				redirect('payment');
			}
			else{
				$this->session->set_flashdata('msg', 'EAn error occurred while saving your personal information. Please try again');
				redirect('personal_info');
			}
		}
		else{
			redirect('personal_info');
		}
	}
}
