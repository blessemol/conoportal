<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
	<title>:: Student Portal - Kogi State College of Nursing and Midwifery, Obangede</title>
	<link href="<?php print base_url('assets/css/main.css'); ?>" rel="stylesheet">
</head>

<body>
<div class="app-container app-theme-white body-tabs-shadow">
	<div class="app-container">
		<div class="h-100">
			<div class="h-100 no-gutters row">
				<div class="d-none d-lg-block col-lg-4">
					<div class="slider-light">
						<div class="slick-slider">
							<div>
								<div class="position-relative h-100 d-flex justify-content-center align-items-center bg-plum-plate" tabindex="-1">
									<div class="slide-img-bg" style="background-image: url(<?php print base_url('assets/images/originals/slide1.jpg'); ?>);"></div>
									<div class="slider-content">
										<!--<h3>Perfect Balance</h3>
										<p>ArchitectUI is like a dream. Some think it's too good to be true! Extensive
											collection of unified React Boostrap Components and Elements.
										</p>-->
									</div>
								</div>
							</div>
							<div>
								<div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
									<div class="slide-img-bg" style="background-image: url('assets/images/originals/slide2.jpg');"></div>
									<div class="slider-content">
										<!--<h3>Scalable, Modular, Consistent</h3>
										<p>Easily exclude the components you don't require. Lightweight, consistent
											Bootstrap based styles across all elements and components
										</p>-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
					<div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
						<div style="float: left; padding-right: 15px;"><img height="75px" src="<?php print base_url('assets/images/logo.png'); ?>"></div>
						<div style="float: left;">
							<h5 style="margin: 5px;"><strong>KOGI STATE</strong></h5>
							<h5 style="margin: 5px;">College of Nursing and Midwifery, Obangede</h5>
							<h6 style="margin: 5px;"><strong>Student Portal</strong></h6>
						</div>
						<div class="clearfix"></div>
						<h6 class="mt-3"><em>Login with your Application number</em></h6>
						<div class="divider row"></div>
						<div>
							<form action="<?php print base_url('index/login'); ?>" method="post">
								<?php sessAlert('msg'); ?>
								<div id="stage1">
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group">
												<!--<label for="exampleEmail" class="">JAMB Registration Number</label>-->
												<input name="appno" placeholder="Application Number" type="text" class="form-control" required>
											</div>
										</div>
									</div>
								</div>
								<div id="param1">
									<div class="d-flex align-items-center">
										<button class="btn btn-primary btn-lg" type="submit" name="lbtn" value="lbtn">Login</button>
									</div>
								</div>
							</form>
							<?php normAlert('IFreshers should first login to their <a href="http://kgscnmobangede.com/application"><strong>Application Portal</strong></a> with their <strong>Email Address</strong> to confirm their <strong>Application Numbers</strong> before proceeding</strong>'); ?>
						</div>
						<div class="divider row" style="margin-bottom: 2px; margin-top: 30px;"></div>
						Powered by <a href="http://blessemolconsult.com.ng">Blessemol Consult</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<script src="<?php print base_url('assets/js/main.js'); ?>"></script>
</body>
</html>
