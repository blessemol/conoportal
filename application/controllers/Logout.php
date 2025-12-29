<?php
class Logout extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	function index(){
		unset($this->session->userdata);
		$this->session->sess_destroy();
		redirect('index');
	}
}
