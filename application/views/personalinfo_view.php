<?php
require_once('common.php');
$userdet = $userdet->row_array();
?>
<html lang="en">
<head>
	<?php require_once('inc/head.php'); ?>
</head>

<body>
	<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
		<?php require_once('inc/header.php'); ?>
		<div class="app-main">
			<?php require_once('inc/sidebar.php'); ?>
			<div class="app-main__outer">
				<div class="app-main__inner">
					<div class="app-page-title">
						<div class="page-title-wrapper">
							<div class="page-title-heading">
								<div class="page-title-icon">
									<i class="pe-7s-id icon-gradient bg-premium-dark"></i>
								</div>
								<div>
									Personal Information
									<div class="page-title-subheading">Submit your personal information details</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="main-card mb-3 card">
								<div class="card-body">
									<?php sessAlert('msg'); ?>
									<form action="<?php print base_url('personal_info/submit'); ?>" method="post" enctype="multipart/form-data">
										<div class="form-row">
											<div class="form-group position-relative col-md-6">
												<label>Application No.</label>
												<input type="text" class="form-control" name="appno" value="<?php print $appno; ?>" readonly required>
											</div>
											<div class="form-group position-relative col-md-6">
												<label>First Name</label>
												<input type="text" class="form-control" name="fname" value="<?php print $userdet['firstname']; ?>">
											</div>
											<div class="form-group position-relative col-md-6">
												<label>Middle Name</label>
												<input type="text" class="form-control" name="mname" value="<?php print $userdet['middlename']; ?>">
											</div>
											<div class="form-group position-relative col-md-6">
												<label>Last Name</label>
												<input type="text" class="form-control" name="lname" value="<?php print $userdet['lastname']; ?>" readonly>
											</div>
											<div class="form-group position-relative col-md-6">
												<label>Department</label>
												<input type="text" class="form-control" name="dept" value="<?php print $userdet['dept']; ?>" readonly >
											</div>
											<div class="form-group position-relative col-md-6">
												<label>Faculty</label>
												<input type="text" class="form-control" name="faculty" value="<?php print $userdet['faculty']; ?>" readonly >
											</div>
											<div class="form-group position-relative col-md-6">
												<label>Level</label>
												<select name="level" class="form-control">
													<option value="" disabled <?php if(!$userdet['level']){ print "selected"; } ?>>-select-</option>
													<?php
													for($l=100; $l<=400; $l+=100){
														?><option value="<?php print $l; ?>" <?php if($userdet['level']==$l){ print "selected"; } ?>><?php print $l; ?></option><?php
													}
													?>
												</select>
											</div>
											<div class="form-group position-relative col-md-6">
												<label>Gender</label>
												<select name="gender" class="form-control" required>
													<option value="" disabled <?php if(!$userdet['gender']){ print "selected"; } ?>>-select-</option>
													<option value="Male" <?php if($userdet['gender']=="Male"){ print "selected"; } ?>>Male</option>
													<option value="Female" <?php if($userdet['gender']=="Female"){ print "selected"; } ?>>Female</option>
												</select>
											</div>
											<div class="form-group position-relative col-md-6">
												<label>Phone</label>
												<input type="text" class="form-control" name="phone" value="<?php print $userdet['phone']; ?>" required>
											</div>
											<div class="form-group position-relative col-md-6">
												<label>Email</label>
												<input type="text" class="form-control" name="email" value="<?php print $userdet['email']; ?>" required>
											</div>
											<div class="form-group position-relative col-md-6">
												<label>Date of Birth</label>
												<input type="date" class="form-control" name="dob" value="<?php print $userdet['dob']; ?>" required>
											</div>
											<div class="form-group position-relative col-md-6">
												<label>Indigene</label>
												<input type="text" class="form-control" name="indigene" value="<?php print $userdet['indigene']; ?>" readonly >
											</div>
											<div class="form-group position-relative col-md-6">
												<label>State of Origin</label>
												<input type="text" class="form-control" name="origin" value="<?php print $userdet['origin']; ?>" readonly >
											</div>
											<div class="form-group position-relative col-md-6">
												<label>LGA</label>
												<input type="text" class="form-control" name="lga" value="<?php print $userdet['lga']; ?>" readonly >
											</div>
											<div class="form-group position-relative col-md-12">
												<label>Address</label>
												<textarea class="form-control" name="address" required><?php print $userdet['address']; ?></textarea>
											</div>
											<div class="form-group position-relative col-md-12">
												<label>Upload Passport (.jpg or .png, max size 500kb)</label>
												<input type="file" class="form-control" name="userfile">
											</div>
											<div class="form-group position-relative col-md-12">
												<button class="btn btn-primary btn-lg" type="submit" name="sbtn" value="sbtn">Submit &amp; Proceed</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php require_once('inc/footer.php'); ?>
			</div>
		</div>
	</div>
	<div class="app-drawer-overlay d-none animated fadeIn"></div>
	<?php require_once('inc/footerscript.php'); ?>
</body>
</html>
