<?php
class Course_form extends CI_Controller {
	private $paytbl = "regcourses";
	public function __construct(){
		parent::__construct();
		$this->load->model('crud_model');
	}
	//
	function index(){
		$data['page'] = "courses";
		$appno = $this->session->userdata('appno');
		$where = array('appno'=>$appno);
		$data['userdet'] = $udet = $this->crud_model->get_where('student', $where);
		$udet = $udet->row_array();
		$admsess = $udet['admsess'];
		$cat = studentCat($admsess);
		$data['activesess'] = $activesess = activeSess($cat);
		$data['regcourses'] = $this->regCourses($appno, $activesess);
		//
		$this->load->view('courseform_view', $data);
	}
	//
	private function regCourses($appno, $sess){
		$where = array('matno'=>$appno, 'sess'=>$sess);
		return $this->crud_model->get_where('regcourses', $where);
	}
	//
	function courseDet($code){
		$where = array('code'=>$code);
		$det = $this->crud_model->get_where('courses', $where);
		return $det->row_array();
	}
}
