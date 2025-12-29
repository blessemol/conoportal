<?php
require_once('common.php');
$userdet = $userdet->row_array();
$coursesArr1 = isset($courses1) ? explode("@@@", $courses1) : "";
$coursesArr2 = isset($courses2) ? explode("@@@", $courses2) : "";
?>
<html lang="en">
<head>
	<?php require_once('inc/head.php'); ?>
	<style type="text/css">
		.card-body p{
			margin: 0px !important;
		}
		@media print{
			.noprint{ display: none; }
		}
	</style>
</head>

<body>
	<div class="app-container body-tabs-shadow">
		<div class="app-main">
			<div class="col-md-12">
					<div class="app-page-title">
						<div class="page-title-wrapper">
							<div class="page-title-heading">
								<div class="col-md-12" style="width: 100%;">
									<div style="float: left; padding-right: 15px; text-align: left !important;"><img height="75px" src="<?php print base_url('assets/images/logo.png'); ?>"></div>
									<div style="float: left; padding-right: 15px; text-align: left !important;">
										<h6 style="margin: 0px;"><strong>KOGI STATE</strong></h6>
										<h6 style="margin: 0px;">College of Nursing Sciences, Obangede</h6>
										<h6 style="margin: 0px;" class="font-weight-bold"><?= $sess; ?> Academic Session Course Form</h6>
									</div>
									<div style="float: right !important; padding-right: 0px; text-align: right;"><img style="border: #1e3f93 thin solid;" height="75px" src="<?php print $userdet['picpath']; ?>"></div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="main-card mb-3 card">
								<div class="card-body">
									<h6><strong>Candidate Information</strong></h6>
									<div style="width: 100%;">
										<div style="width: 50%; padding-right: 10px; float: left;">
											<p><strong>App./Reg. No:</strong> <?= $appno; ?></p>
											<p><strong>Department:</strong> <?= $userdet['dept']; ?></p>
											<p><strong>Level:</strong> <?= $level; ?></p>
										</div>
										<div style="width: 50%; padding-right: 10px; float: right;">
											<p><strong>Name:</strong> <?= $userdet['firstname']." ".$userdet['middlename']." ".$userdet['lastname']; ?></p>
											<p><strong>Faculty:</strong> <?= $userdet['faculty']; ?></p>
											<p><strong>Gender:</strong> <?= $userdet['gender']; ?></p>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="divider"></div>
									<h6><strong>Registered Courses</strong></h6>
									<table cellpadding="3px" class="table-bordered table-striped" style="font-size: 13px !important; width: 100% !important;">
										<thead>
										<th>#</th>
										<th>Code</th>
										<th>Title</th>
										<th>Category</th>
										<th>Unit</th>
										<th>Signature</th>
										</thead>
										<tbody>
										<tr><td class="font-weight-bold" colspan="6" align="left">1ST SEMESTER COURSES</td> </tr>
										<?php
										$sn = 0; $tot = 0;
										if($coursesArr1){
											foreach($coursesArr1 as $c){
												$sn+=1;
												$cdet = rowDet('courses', array('code'=>$c));
												$tot+=$cdet['unit'];
												?>
												<tr>
													<td><?php print "$sn."; ?></td>
													<td><?php print "$c"; ?></td>
													<td><?php print $cdet['title']; ?></td>
													<td><?php print $cdet['category']; ?></td>
													<td><?php print $cdet['unit']; ?></td>
													<td></td>
												</tr>
												<?php
											}
											?>
											<tr>
												<td colspan="4" align="right"><strong>Total:</strong></td>
												<td><strong><?php print $tot; ?></strong></td>
												<td></td>
											</tr>
											<?php
										}
										else{
											?><tr><td colspan="5"><?php normAlert('INo course registered'); ?></td></tr><?php
										}
										?><tr><td class="font-weight-bold" colspan="6" align="left">2ND SEMESTER COURSES</td> </tr><?php
										$sn = 0; $tot = 0;
										if($coursesArr2){
											foreach($coursesArr2 as $c){
												$sn+=1;
												$cdet = rowDet('courses', array('code'=>$c));
												$tot+=$cdet['unit'];
												?>
												<tr>
													<td><?php print "$sn."; ?></td>
													<td><?php print "$c"; ?></td>
													<td><?php print $cdet['title']; ?></td>
													<td><?php print $cdet['category']; ?></td>
													<td><?php print $cdet['unit']; ?></td>
													<td></td>
												</tr>
												<?php
											}
											?>
											<tr>
												<td colspan="4" align="right"><strong>Total:</strong></td>
												<td><strong><?php print $tot; ?></strong></td>
												<td></td>
											</tr>
											<?php
										}
										else{
											?><tr><td colspan="5"><?php normAlert('INo course registered'); ?></td></tr><?php
										}
										?>
										</tbody>
									</table>
									<div class="clearfix"></div>
									<div class="divider" style="margin-bottom: 5px;"></div>
									<br>___________________________________________<br>
									<strong>Student's Signature &amp; Date</strong>
									<div class="divider" style="margin-bottom: 5px;"></div>
									<strong>OFFICIAL USE (Deputy Provost):</strong><br><br>
									<a href="#" class="btn btn-lg btn-secondary noprint" onclick="window.print();">Send to Printer</a>
									<a href="#" class="btn btn-lg btn-light noprint" onclick="window.close();">Close</a>
								</div>
							</div>
						</div>
					</div>
				<?php require_once('inc/formfooter.php'); ?>
			</div>
		</div>
	</div>
	<?php /*require_once('inc/footerscript.php'); */?>
</body>
</html>
