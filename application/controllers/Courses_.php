<?php
class Courses extends CI_Controller {
	private $paytbl = "courses";
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
		$activesess = activeSess($cat);
		$data['activesess'] = $activesess;
		$wh = array('matno'=>$appno, 'sess'=>$activesess, 'status'=>'paid');
		$pdet = $this->crud_model->get_where('remita_payment_sf', $wh);
		if($pdet->num_rows()>0){
			//get courses
			$data['allcourses1'] = $this->allCourses('1ST', $udet['level']);
			$data['allcourses2'] = $this->allCourses('2ND', $udet['level']);
			$data['regcourses'] = $this->regCourses($appno, $activesess);
			//
			$this->load->view('courses_view', $data);
		}
		else{
			$this->session->set_flashdata('msg', 'EPlease pay your school charges before registering your courses');
			redirect('payment');
		}
	}
	//
	function allCourses($sem, $level){
		$sql = "select * from courses where sem = '".$sem."' and level = '".$level."'";
		return $this->crud_model->custom($sql);
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
	//
	function register(){
		$sem = $this->input->post('sem');
		if($this->input->post('regbtn')){
			$code = ($this->input->post('code')) ? $this->input->post('code') : array();
			$where = array('matno'=>$this->input->post('appno'), 'sess'=>$this->input->post('sess'));
			$det = $this->crud_model->get_where('regcourses', $where);
			if($det->num_rows()>0){
				$det = $det->row_array();
				$arr = explode("@@@", $det['course']);
				foreach ($arr as $c){
					$cdet = $this->courseDet($c);
					if($cdet['sem']!=$sem){
						$regarr[] = $c;
					}
				}
				$regarr = (isset($regarr)) ? $regarr : array();
			}
			else{
				$regarr = array();
			}
			$crsarr = array_unique(array_merge($code, $regarr));
			$course = implode("@@@", $crsarr);
			$data = array(
				'course'=>$course,
				'dept'=>'NMW',
				'level'=>$this->input->post('level'),
				'regat'=>time(),
				'regat2'=>date("Y/m/d H:i:s")
			);
			$this->crud_model->add_update('regcourses', $data, $where);
			$this->crud_model->add_update('eregcourses', $data, $where);
			$msg = "SCourses registered successfully";
		}
		else{
			$msg = "EPerform an action";
		}
		$this->session->set_flashdata('msg', $msg);
		redirect('courses');
	}
}
