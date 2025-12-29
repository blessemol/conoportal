<?php
class Receipt extends CI_Controller {
	private $paytbl = "remita_payment_sf";
	public function __construct(){
		parent::__construct();
		$this->load->model('crud_model');
	}
	//
	function index(){
		$appno = $this->session->userdata('appno');
		$where = array('appno'=>$appno);
		$data['userdet'] = $udet = $this->crud_model->get_where('student', $where);
		$udet = $udet->row_array();
		$admsess = $udet['admsess'];
		$cat = studentCat($admsess);
		$activesess = activeSess($cat);
        $sess = ($this->input->post('sbtn')) ? $this->input->post('sess') : $activesess;
        $data['paydet'] = $this->fetchPayDet($appno, $sess);
		$data['page'] = "payment";
		//
		$this->load->view('receipt_view', $data);
	}
	//
	private function fetchPayDet($appno, $sess){
		$where = array('matno'=>$appno, 'sess'=>$sess);
		$data = $this->crud_model->get_where($this->paytbl, $where);
		return $data->row_array();
	}
}
