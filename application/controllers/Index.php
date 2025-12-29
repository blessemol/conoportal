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
    function load(){
        $cat = ($this->input->post('cat')) ? $this->input->post('cat') : "";
		//load content
        if ($cat == "LoadContent") {
            ?>
            <h6 class="mt-3"><em>Login with your Application number</em></h6>
            <div class="divider row"></div>
            <div>
                <form id="formData">
					<input type="hidden" name="cat" value="Login">
					<div class="form-row">
						<div class="col-md-12">
							<div class="position-relative form-group">
								<input id="appno" name="appno" placeholder="Application Number" type="text" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="d-flex align-items-center">
						<button id="btnArea" onclick="login()" class="btn btn-block btn-primary btn-lg" type="button" name="lbtn" value="lbtn">Login</button>
					</div>
                </form>
                <?php normAlert('IFreshers should first login to their <a href="http://kgscnmobangede.com/application"><strong>Application Portal</strong></a> with their <strong>Email Address</strong> to confirm their <strong>Application Numbers</strong> before proceeding</strong>'); ?>
            </div>
            <?php
        }
		//login
		elseif ($cat == "Login") {
			$appno = trim(strtoupper($this->input->post('appno')));
            $val = $this->crud_model->get_where('student', array('appno'=>$appno));
            if($val->num_rows()>0){
                $sessdata = array('appno'=>$appno, 'sloggedin'=>TRUE);
                $this->session->set_userdata($sessdata);
                AlertToastMaxi("success", "top right", "Login successful");
                print "Login Successful";
                pageRedirect('personal_info');
            }
            else{
                AlertToastMaxi("error", "top right", "Invalid Application Number");
                print "Login";
            }
		}
    }
}
