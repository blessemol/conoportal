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
    <script type="text/javascript" src="https://login.remita.net/payment/v1/remita-pay-inline.bundle.js"></script>
	<script src="<?php print base_url('assets/js/jquery.js'); ?>"></script>
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
                                    <form id="formData">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text font-weight-bold">Select Academic Session:</span>
                                            </div>
                                            <select class="form-control" id="sess" name="sess">
                                                <option value="" selected disabled>-select-</option>
                                                <?php
                                                if (isset($allsess)){
                                                    foreach ($allsess as $row){
                                                        $sess = $row['sess'];
                                                        ?><option <?= (isset($selsess) && $selsess==$sess) ? "selected" : ""; ?> value="<?= $sess; ?>"><?= $sess; ?></option> <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" onclick="loadPayment()" type="button">Load Payment Details</button>
                                            </div>
                                        </div>
                                    </form>

                                    <div id="contentArea"></div>

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
    <script>
        //load payment details
        function loadPayment(sess='') {
            if (!sess){
                if (!fieldsValidate(['sess'])) return;
                sess = $('#sess').val();
            }
            $('#contentArea').html(
                '<div class="col-md-12 text-center pt-5"><img src="<?= base_url('assets/images/ajax-loader.gif'); ?>" class="align-content-center" height="25" /></div>'
            );
            var obj = {
                sess: sess,
                cat: "LoadPayment"
            };
            $.ajax({
                type: "POST",
                url: "<?= base_url('payment/load'); ?>",
                data: obj,
                success: function(result) {
                    $('#contentArea').html(result);
                },
                error: function() {
                    AlertToastMaxi("error", "top right", "An error occurred");
                }
            });
        }
        function makePayment() {
            event.preventDefault();
            var form = document.querySelector("#payment-form");
            //var transactionId = $('#transactionId').val();
            var paymentEngine = RmPaymentEngine.init({
                key: '<?= PUBLIC_KEY; ?>',
                processRrr: true,
                transactionId: Math.floor(Math.random()*1101233),
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
                    console.log("closed");
                }
            });
            paymentEngine.showPaymentWidget();
        }
    </script>
</body>
</html>

<div id="LoadModal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div id="FillModal"></div>
    </div>
</div>
