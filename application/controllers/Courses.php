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
        $data['allsess']  = $this->crud_model->custom("select distinct sess from session where sess>='$admsess' order by sess DESC")->result_array();
        $this->load->view('courses_view', $data);
	}
	//
    function load(){
        $appno = $this->session->userdata('appno');
        $cat = ($this->input->post('cat')) ? $this->input->post('cat') : "";
        //load courses
        if ($cat == "LoadCourses") {
            $sess = $this->input->post('sess');
            $paid = rowDet('remita_payment_sf', array('matno'=>$appno, 'sess'=>$sess, 'status'=>'paid'));
            ?>
            <div class="divider row"></div>
            <?php
            if ($paid){
                $sDet = rowDet('student', array('appno'=>$appno));
                if ($sDet && $sDet['admsess']){
                    $admSess = $sDet['admsess'];
                    $level = getLevel($admSess, $sess);
                    print "<span class='font-weight-bold'>Level: $level</span>";
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <span class="font-weight-bold">1ST SEMESTER</span> ::
                            <a href="#" class="font-weight-bold text-info" onclick="loadRegister('1ST', '<?= $sess; ?>', '<?= $level; ?>', '<?= $appno; ?>')"><i class="fa fa-plus-circle"></i> Register Courses</a>
                            <table class="small table table-bordered table-striped mt-2">
                                <thead>
                                <th>#</th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Unit</th>
                                <th>Category</th>
                                </thead>
                                <tbody>
                                <?php
                                $courses1 = rowDetCol('regcourses', array('matno'=>$appno, 'sem'=>'1ST', 'sess'=>$sess), 'course');
                                if ($courses1){
                                    $totalUnit = 0;
                                    $sn = 0;
                                    $coursesArr1 = explode("@@@", $courses1);
                                    foreach ($coursesArr1 as $c){
                                        $row = rowDet('courses', array('code'=>$c));
                                        $sn+=1;
                                        $title = $row['title'];
                                        $unit = $row['unit'];
                                        $category = $row['category'];
                                        $totalUnit += $unit;
                                        echo "<tr>";
                                        echo "<td>$sn.</td>";
                                        echo "<td>$c</td>";
                                        echo "<td>$title</td>";
                                        echo "<td>$unit</td>";
                                        echo "<td>$category</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr>";
                                    echo "<td colspan='3' align='right' class='font-weight-bold'>Total Unit:</td>";
                                    echo "<td colspan='2' align='left' class='font-weight-bold'>$totalUnit</td>";
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <span class="font-weight-bold">2ND SEMESTER</span> ::
                            <a href="#" class="font-weight-bold text-info" onclick="loadRegister('2ND', '<?= $sess; ?>', '<?= $level; ?>', '<?= $appno; ?>')"><i class="fa fa-plus-circle"></i> Register Courses</a>
                            <table class="small table table-bordered table-striped mt-2">
                                <thead>
                                <th>#</th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Unit</th>
                                <th>Category</th>
                                </thead>
                                <tbody>
                                <?php
                                $courses2 = rowDetCol('regcourses', array('matno'=>$appno, 'sem'=>'2ND', 'sess'=>$sess), 'course');
                                if ($courses2){
                                    $totalUnit = 0;
                                    $sn = 0;
                                    $coursesArr2 = explode("@@@", $courses2);
                                    foreach ($coursesArr2 as $c){
                                        $row = rowDet('courses', array('code'=>$c));
                                        $sn+=1;
                                        $title = $row['title'];
                                        $unit = $row['unit'];
                                        $category = $row['category'];
                                        $totalUnit += $unit;
                                        echo "<tr>";
                                        echo "<td>$sn.</td>";
                                        echo "<td>$c</td>";
                                        echo "<td>$title</td>";
                                        echo "<td>$unit</td>";
                                        echo "<td>$category</td>";
                                        echo "</tr>";
                                    }
                                    echo "<tr>";
                                    echo "<td colspan='3' align='right' class='font-weight-bold'>Total Unit:</td>";
                                    echo "<td colspan='2' align='left' class='font-weight-bold'>$totalUnit</td>";
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                    if ($courses1 && $courses2){
                        ?>
                        <form action="<?= base_url('course_form'); ?>" method="post" target="_blank">
                            <input type="hidden" name="courses1" value="<?= $courses1; ?>">
                            <input type="hidden" name="courses2" value="<?= $courses2; ?>">
                            <input type="hidden" name="sess" value="<?= $sess; ?>">
                            <input type="hidden" name="level" value="<?= $level; ?>">
                            <button name="printBtn" value="printBtn" class="btn btn-success btn-block"><i class="fa fa-print"></i> Print Course Form</button>
                        </form>
                        <?php
                    }
                    else{
                        normAlert("EPlease complete your registration for both semesters to printout your course form");
                    }
                }
            }
            else{
                normAlert("EYou have not paid your school charges for the selected academic session (<strong>$sess</strong>)");
            }
        }
        //load register
        elseif ($cat == "LoadRegister"){
            $sem = $this->input->post('sem');
            $sess = $this->input->post('sess');
            $level = $this->input->post('level');
            $appno = $this->input->post('appno');
            $regCourses = rowDetCol('regcourses', array('matno'=>$appno, 'sem'=>$sem, 'sess'=>$sess), 'course');
            $regCoursesArr = $regCourses ? explode("@@@", $regCourses) : array();
            $allLevels = rowsDet('levels', "name <= '$level'", 'name DESC');
            ?>
            <div class="modal-content">
                <form id="formData">
                    <input type="hidden" name="appno" id="appno" value="<?= $appno; ?>">
                    <input type="hidden" name="sem" id="sem" value="<?= $sem; ?>">
                    <input type="hidden" name="sess" id="sess" value="<?= $sess; ?>">
                    <input type="hidden" name="level" id="level" value="<?= $level; ?>">
                    <input type="hidden" name="cat" id="cat" value="RegisterCourses">
                    <div class="modal-header">
                        <h5 class="modal-title fsize-1 font-weight-bold">Register Courses - <?= "$sem Semester, $sess ($level)" ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered small">
                            <thead>
                            <th></th>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Unit</th>
                            <th>Category</th>
                            </thead>
                            <tbody>
                            <?php
                            if ($allLevels){
                                foreach ($allLevels as $dbLevel){
                                    $l = $dbLevel['name'];
                                    echo "<tr><td colspan='5' class='font-weight-bold'>$l</td></tr>";
                                    $rows = rowsDet('courses', array('sem'=>$sem, 'level'=>$l, 'status'=>1), 'code ASC');
                                    if ($rows){
                                        foreach ($rows as $row){
                                            $code = $row['code'];
                                            $title = $row['title'];
                                            $unit = $row['unit'];
                                            $category = $row['category'];
                                            $checked = !empty($regCoursesArr) && in_array($code, $regCoursesArr) ? "checked" : "";
                                            echo "<tr>";
                                            echo "<td><input $checked type='checkbox' name='code[]' value='$code'></td>";
                                            echo "<td>$code</td>";
                                            echo "<td>$title</td>";
                                            echo "<td>$unit</td>";
                                            echo "<td>$category</td>";
                                            echo "</tr>";
                                        }
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="registerCourses()" data-dismiss="modal" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
            <?php
        }
        //register courses
        elseif ($cat == "RegisterCourses"){
            $appno = $this->input->post('appno');
            $sem = $this->input->post('sem');
            $sess = $this->input->post('sess');
            $level = $this->input->post('level');
            $code = $this->input->post('code') ? implode("@@@", $this->input->post('code')) : "";
            $wh = array('matno'=>$appno, 'sem'=>$sem, 'sess'=>$sess);
            if ($code){
                $maxUnit = rowDetCol('levels', array('name'=>$level), 'maxunit');
                $totalUnit = 0;
                $codeArr = explode("@@@", $code);
                foreach ($codeArr as $c){
                    $totalUnit += rowDetCol('courses', array('code'=>$c), 'unit');
                }
                if ($totalUnit > $maxUnit){
                    AlertToastMaxi("error", "top right", "You have exceeded the approved maximum total unit of <strong>$maxUnit</strong>, you selected <strong>$totalUnit</strong>");
                }
                else{
                    $this->crud_model->add_update('regcourses', array('course'=>$code, 'level'=>$level), $wh);
                    AlertToastMaxi("success", "top right", "Courses registered successfully");
                }
            }
            else{
                $this->crud_model->delete('regcourses', $wh);
                AlertToastMaxi("success", "top right", "Courses were completely removed successfully");
            }
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
