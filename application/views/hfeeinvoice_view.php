<?php
require_once('common.php');
$userdet = $userdet->row_array();

?>
<html lang="en">
<head>
	<?php require_once('inc/head.php'); ?>
	<style type="text/css">
		.card-body p{
			margin: 7px;
		}
		@media print{
			.noprint{ display: none; }
		}
	</style>
</head>

<body>
	<div class="app-container body-tabs-shadow">
		<?php //require_once('inc/header.php'); ?>
		<div class="app-main">
			<?php //require_once('inc/sidebar.php'); ?>
			<div class="col-md-12">
					<div class="app-page-title">
						<div class="page-title-wrapper">
							<div class="page-title-heading">
								<div class="col-md-12">
									<div style="float: left; padding-right: 15px; text-align: left !important;"><img height="75px" src="<?php print base_url('assets/images/logo.png'); ?>"></div>
									<div style="float: left; text-align: left !important;">
										<h6 style="margin: 0px;"><strong>KOGI STATE</strong></h6>
										<h6 style="margin: 0px;">College of Nursing and Midwifery, Obangede</h6>
										<h6 style="margin: 0px;"><?php print $paydet['sess']; ?> Academic Session</h6>
										<div style="margin: 0px; font-size: 14px;"><strong>Accommodation Fee Invoice</strong></div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="main-card mb-3 card">
								<div class="card-body">
									<?php
									$appno = $paydet['matno'];
									$rrr = $paydet['rrr'];
									$orderid = $paydet['orderid'];
									$status = $paydet['status'];
									$amount = $paydet['amount'];
									$name = $paydet['name'];
									$phone = $paydet['phone'];
									$email = $paydet['email'];
									if($status=="paid"){
										redirect('payment');
									}
									else{
										?>
										<h6><strong>Payment Details</strong></h6>
										<p>Order ID: <?php print $orderid; ?></p>
										<p style="font-weight: bold;">RRR: <?php print $rrr; ?></p>
										<p>Amount: <?php print number_format($amount, 2); ?></p>
										<div class="divider"></div>
										<h6><strong>Personal Information</strong></h6>
										<p>Application No.: <?php print $appno; ?></p>
										<p>Name: <?php print $name; ?></p>
										<p>Phone: <?php print $phone; ?></p>
										<p>Email: <?php print $email; ?></p>
										<a href="#" class="btn btn-lg btn-secondary noprint" onclick="window.print();">Send to Printer</a>
										<a href="#" class="btn btn-lg btn-light noprint" onclick="window.close();">Close</a>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				<?php require_once('inc/footer.php'); ?>
			</div>
		</div>
	</div>
	<?php /*require_once('inc/footerscript.php'); */?>
</body>
</html>
