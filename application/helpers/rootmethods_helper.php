<?php
//pswd encryption
function encryptPswd($username, $pswd){
	$salt = "bLeSsEmOl";
	$s=sha1($username.$salt);
	$m=md5($pswd);
	$s1=substr($s,0,20);
	$s2=substr($s,20,20);
	$m1=substr($m,0,2);
	$m2=substr($m,2,30);
	$p=$s1.$m2.$m1.$s2;
	return $p;
}

//notification
function sessAlert($msgname){
	if(isset($_SESSION[$msgname])){
		$msg = $_SESSION[$msgname];
		$char = strtoupper($msg[0]);
		$rest = substr($msg, 1);
		if($char=="S"){
			?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			    <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
			    <?php print $rest; ?>
			</div>
			<?php
		}
		elseif($char=="E"){
			?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			    <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
			    <?php print $rest; ?>
			</div>
			<?php
		}
		elseif($char=="W"){
			?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
			    <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
			    <?php print $rest; ?>
			</div>
			<?php
		}
		else{
			?>
			<div class="alert alert-info alert-dismissible fade show" role="alert">
			    <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
			    <?php print $rest; ?>
			</div>
			<?php
		}
	}
}

function normAlert($msg){
	if($msg){
		$char = strtoupper($msg[0]);
		$rest = substr($msg, 1);
		if($char=="S"){
			?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			    <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
			    <?php print $rest; ?>
			</div>
			<?php
		}
		elseif($char=="E"){
			?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
			    <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
			    <?php print $rest; ?>
			</div>
			<?php
		}
		elseif($char=="W"){
			?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
			    <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
			    <?php print $rest; ?>
			</div>
			<?php
		}
		else{
			?>
			<div class="alert alert-info alert-dismissible fade show" role="alert">
			    <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">×</span></button>
			    <?php print $rest; ?>
			</div>
			<?php
		}
	}
}
//empty Toster Javascript Alert
function AlertToastMaxi($type, $msgPosition, $msgNotif){
    echo '<script type="text/javascript">
            AlertToastMaxi("' . $type . '", "' . $msgPosition . '", "' . $msgNotif . '");
        </script>';
}
//javascript redirect
function pageRedirect($location)
{
    print "<script language='javascript'>window.location = '".base_url($location)."';</script>";
}

//DB related functions
//fetch row details
function rowDet($tbl, $where, $order='id ASC'){
    $CI = get_instance();
    $CI->load->model('crud_model');
    return $CI->crud_model->get_where($tbl, $where, $order)->row_array();
}
//fetch row details
function rowDetCol($tbl, $where, $col, $order='id ASC'){
    $CI = get_instance();
    $CI->load->model('crud_model');
    $obj = $CI->crud_model->get_where($tbl, $where, $order)->row_array();
    return $obj ? $obj[$col] : false;
}
//fetch all row details
function rowsDet($tbl, $where, $order='id ASC'){
    $CI = get_instance();
    $CI->load->model('crud_model');
    return $CI->crud_model->get_where($tbl, $where, $order)->result_array();
}
//table count
function tableCount($tbl, $where){
    $CI = get_instance();
    $CI->load->model('crud_model');
    return $CI->crud_model->get_where_count($tbl, $where);
}

//get active session
function activeSess($cat="returning"){
	$CI = get_instance();
	$CI->load->model('crud_model');
	if($cat=="old fresher") { $cat = "returning"; }
	$where = array($cat=>'yes');
	$data = $CI->crud_model->get_where('session', $where);
	if($data->num_rows()>0){
		$data = $data->row_array();
		return $data['sess'];
	}
	else{
		return false;
	}
}
//get active semester
function activeSem($cat="returning"){
	$CI = get_instance();
	$CI->load->model('crud_model');
	$where = array($cat=>'yes');
	$data = $CI->crud_model->get_where('session', $where);
	if($data->num_rows()>0){
		$data = $data->row_array();
		return $data['sem'];
	}
	else{
		return false;
	}
}
//get student category
function studentCat($admsess){
	$CI = get_instance();
	$CI->load->model('crud_model');
	$where = array('returning'=>'yes');
	$data = $CI->crud_model->get_where('session', $where);
	$data = $data->row_array();
	$s = $data['sess'];
	if($admsess>$s){
		$cat = "fresher";
	}
	elseif($admsess==$s){
		//$cat = "old fresher";
		$cat = "fresher";
	}
	else{
		$cat = "returning";
	}
	//$cat = ($admsess>=$s) ? "fresher" : "returning";
	return $cat;
}
//hostel fee count
function hostelCount($sess){
	$CI = get_instance();
	$CI->load->model('crud_model');
	$where = array('sess'=>$sess, 'status'=>'paid');
	return $CI->crud_model->get_where('remita_payment_ac', $where)->num_rows();
}
//get level
function getLevel($admSess, $currentSess){
    return $currentSess <= $admSess ? "ND 1" : "ND 2";
}