<?php
require_once('common.php');
$userdet = $userdet->row_array();
if(!$userdet['phone'] || !$userdet['email']){
	$this->session->set_flashdata('msg', 'EPlease complete your personal information before proceeding to payment');
	redirect('personal_info');
}

?>
<html lang="en">
<head>
	<?php require_once('inc/head.php'); ?>
    <!--<script type="text/javascript" src="https://login.remita.net/payment/v1/remita-pay-inline.bundle.js"></script>-->
	<script src="<?php print base_url('assets/js/jquery.js'); ?>"></script>
	<script type="text/javascript">
		/*$(document).ready(function(){
			$('#subjcheck').click(function() {
				var no = $('input:checkbox:checked').length;
				if(no==5){
					$("#loading").hide();
					$("#sbtn").show();
				}
				else{
					$("#loading").show();
					$("#sbtn").hide();
				}
			});
		});*/
	</script>
	<style type="text/css">
		.card-body p{
			margin: 5px;
		}
	</style>
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
									<i class="pe-7s-cash icon-gradient bg-premium-dark"></i>
								</div>
								<div>
									Payment
									<div class="page-title-subheading">Process your school fee payment</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="main-card mb-3 card">
								<div class="card-body">
									<div class="card-title">SCHOOL FEES PAYMENT DETAILS <?= (isset($selsess)) ? " - $selsess ACADEMIC SESSION" : ""; ?></div>
                                    <form action="<?= base_url('payment/index'); ?>" method="post">
                                        <div class="form-group">
                                            <select class="form-control-sm" name="sess" required>
                                                <option value="" <?= (!isset($selsess)) ? "selected" : ""; ?> disabled>-select academic session-</option>
                                                <?php
                                                if (isset($allsess)){
                                                    foreach ($allsess as $row){
                                                        $sess = $row['sess'];
                                                        ?><option <?= (isset($selsess) && $selsess==$sess) ? "selected" : ""; ?> value="<?= $sess; ?>"><?= $sess; ?></option> <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <button class="btn btn-primary btn-sm" type="submit" name="sbtn" value="sbtn">Select Academic Session</button>
                                        </div>
                                    </form>

									<?php
									sessAlert('msg');
                                    if (isset($resp) && isset($selsess)){
                                        $rrr = $resp['rrr'];
                                        $orderid = $resp['orderid'];
                                        $status = $resp['status'];
                                        $error = $resp['error'];
                                        $amount = $resp['amount'];
                                        $transdate = $resp['transdate'];
                                        if($defaulting){
                                            normAlert('EYou have not paid your fees for the previous academic session');
                                        }
                                        else{
                                            if($status=="paid"){
                                                normAlert('SYour payment has been confirmed successfully.<p><strong>Order ID:</strong> '.$orderid.'</p><p><strong>RRR:</strong> '.$rrr.'</p><p><strong>Amount:</strong> '.number_format($amount, 2).'</p><p><strong>Transaction Date:</strong> '.date("D M j, Y g:i a", $transdate).'</p>');
                                                ?>
                                                <strong>NOTE:</strong> Student Union and NAKOSS fee should be paid into the following account details:<br>
                                                <strong>Account Number:</strong> <br>
                                                Student Union: 2183336628<br>
                                                NAKOSS:2254152082<br>
                                                <strong>Bank:</strong> UBA
                                                <br>
                                                <form action="<?= base_url('receipt/index'); ?>" method="post" target="_blank">
                                                    <input type="hidden" name="sess" value="<?= $selsess; ?>">
                                                    <button type="submit" name="sbtn" value="sbtn" class="btn btn-lg btn-success">Print School Fees Receipt</button>
                                                </form>
                                                <?php
                                            }
                                            else{
                                                //normAlert("W<strong>NOTE:</strong> Fees will be increased from 1st June 2023</strong>");
                                                if($error){ normAlert('E'.$error); }
                                                ?>
                                                <h6><strong>Payment Details</strong></h6>
                                                <p>Order ID: <?php print $orderid; ?></p>
                                                <p style="font-weight: bold;">RRR: <?php print $rrr; ?></p>
                                                <p>Amount: <?php print number_format($amount, 2); ?></p>
                                                <form action="<?= base_url('fee_invoice/index'); ?>" method="post" target="_blank">
                                                    <input type="hidden" name="sess" value="<?= $selsess; ?>">
                                                    <button type="submit" name="sbtn" value="sbtn" class="btn btn-lg btn-primary">Print Payment Invoice</button>
                                                </form>
                                                <!--<a href="<?php /*print base_url('payment'); */?>" class="btn btn-lg btn-success">Confirm Payment</a>-->
                                                <a href="http://www.remita.net" target="_blank"><img height="80px" src="<?php print base_url('assets/images/remita.png'); ?>"> </a>
                                                <?php
                                            }
                                        }
                                        //print_r($resp);
                                    }
									?>
								</div>
							</div>
						</div>
						<?php
						//print "$cat - $activesess - $hcapacity - ".hostelCount($activesess);
						/*if(isset($hresp)){
							*/?><!--
							<div class="col-md-12">
								<div class="main-card mb-3 card">
									<div class="card-body">
										<div class="card-title">HOSTEL ACCOMMODATION FEE PAYMENT DETAILS</div>
										<?php
/*										sessAlert('hmsg');
										$hrrr = $hresp['rrr'];
										$horderid = $hresp['orderid'];
										$hstatus = $hresp['status'];
										$herror = $hresp['error'];
										$hamount = $hresp['amount'];
										$htransdate = $hresp['transdate'];
										if($hstatus=="paid"){
											normAlert('SYour accommodation fee payment has been confirmed successfully.<p><strong>Order ID:</strong> '.$horderid.'</p><p><strong>RRR:</strong> '.$hrrr.'</p><p><strong>Amount:</strong> '.number_format($hamount, 2).'</p><p><strong>Transaction Date:</strong> '.date("D M j, Y g:i a", $htransdate).'</p>');
											*/?>
                                            <form action="<?php /*= base_url('hreceipt/index'); */?>" method="post" target="_blank">
                                                <input type="hidden" name="sess" value="<?php /*= $selsess; */?>">
                                                <button type="submit" name="sbtn" value="sbtn" class="btn btn-lg btn-success">Print Accomodation Fee Receipt</button>
                                            </form>
                                            <?php
/*										}
										else{
											normAlert("I<strong>You have 48 hours to process your payment for accommodation fee, else it will be invalid and reset.</strong><br>Note: Hostel accommodation is first-come-first-serve");
											if($herror){ normAlert('E'.$herror); }
											*/?>
											<p>Order ID: <?php /*print $horderid; */?></p>
											<p style="font-weight: bold;">RRR: <?php /*print $hrrr; */?></p>
											<p>Amount: <?php /*print number_format($hamount, 2); */?></p>
											<a target="_blank" href="<?php /*print base_url('hfee_invoice'); */?>" class="btn btn-lg btn-primary">Print Payment Invoice</a><br>
											<a href="http://www.remita.net" target="_blank"><img height="80px" src="<?php /*print base_url('assets/images/remita.png'); */?>"> </a>
											<?php
/*										}
										*/?>
									</div>
								</div>
							</div>
							--><?php
/*						}*/
						?>
					</div>
				</div>
				<?php require_once('inc/footer.php'); ?>
			</div>
		</div>
	</div>
	<div class="app-drawer-overlay d-none animated fadeIn"></div>
	<?php require_once('inc/footerscript.php'); ?>
    <script>
        /*function makePayment() {
            event.preventDefault();
            var form = document.querySelector("#payment-form");
            var transactionId = $('#transactionId').val();
            var paymentEngine = RmPaymentEngine.init({
                key:"QzAwMDAyNzEyNTl8MTEwNjE4NjF8OWZjOWYwNmMyZDk3MDRhYWM3YThiOThlNTNjZTE3ZjYxOTY5NDdmZWE1YzU3NDc0ZjE2ZDZjNTg1YWYxNWY3NWM4ZjMzNzZhNjNhZWZlOWQwNmJhNTFkMjIxYTRiMjYzZDkzNGQ3NTUxNDIxYWNlOGY4ZWEyODY3ZjlhNGUwYTY=",
                processRrr: true,
                //transactionId: transactionId,
                transactionId: Math.floor(Math.random()*1101233),  //Replace with a reference you generated or remove the entire field for us to auto-generate a reference for you. Note that you will be able to check the status of this transaction using this transaction Id
                extendedData: {
                    customFields: [
                        {
                            name: "rrr",
                            value: form.querySelector('input[name="rrr"]').value
                        }
                    ]
                },
                onSuccess: function (response) {
                    console.log('callback Successful Response', response);
                    window.location.replace("payment");
                },
                onError: function (response) {
                    console.log('callback Error Response', response);
                },
                onClose: function () {
                    //alert("here");
                    console.log("closed");
                }
            });
            paymentEngine.showPaymentWidget();
        }*/
        /*hostel accomodation*/
        /*function makePaymentH() {
            event.preventDefault();
            var form = document.querySelector("#payment-formh");
            var transactionId = $('#transactionIdh').val();
            var paymentEngine = RmPaymentEngine.init({
                key:"U09MRHw0MDgxOTUzOHw2ZDU4NGRhMmJhNzVlOTRiYmYyZjBlMmM1YzUyNzYwZTM0YzRjNGI4ZTgyNzJjY2NjYTBkMDM0ZDUyYjZhZWI2ODJlZTZjMjU0MDNiODBlMzI4YWNmZGY2OWQ2YjhiYzM2N2RhMmI1YWEwYTlmMTFiYWI2OWQxNTc5N2YyZDk4NA==",
                processRrr: true,
                //transactionId: transactionId,
                transactionId: Math.floor(Math.random()*1101233),  //Replace with a reference you generated or remove the entire field for us to auto-generate a reference for you. Note that you will be able to check the status of this transaction using this transaction Id
                extendedData: {
                    customFields: [
                        {
                            name: "rrr",
                            value: form.querySelector('input[name="rrrh"]').value
                        }
                    ]
                },
                onSuccess: function (response) {
                    console.log('callback Successful Response', response);
                    window.location.replace("payment");
                },
                onError: function (response) {
                    console.log('callback Error Response', response);
                },
                onClose: function () {
                    //alert("here");
                    console.log("closed");
                }
            });
            paymentEngine.showPaymentWidget();
        }*/
    </script>
</body>
</html>
