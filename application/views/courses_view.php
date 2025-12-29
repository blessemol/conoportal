<?php
require_once('common.php');
$userdet = $userdet->row_array();
?>
<html lang="en">
<head>
	<?php require_once('inc/head.php'); ?>
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
									<i class="pe-7s-notebook icon-gradient bg-premium-dark"></i>
								</div>
								<div>Courses</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="main-card mb-3 card">
								<div class="card-body">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold">Select Academic Session:</span>
                                        </div>
                                        <select onchange="loadCourses()" class="form-control" id="sess">
                                            <option value="" disabled selected>-select-</option>
                                            <?php
                                            if ($allsess){
                                                foreach ($allsess as $s){
                                                    echo "<option value='".$s['sess']."'>".$s['sess']."</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="button" onclick="loadCourses()">Load Courses</button>
                                        </div>
                                    </div>
                                    <div id="contentArea" class="mt-2"></div>
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
        //load courses
        function loadCourses(sess='') {
            if (!sess){
                if (!fieldsValidate(['sess'])) return;
                sess = $('#sess').val();
            }
            $('#contentArea').html(
                '<div class="col-md-12 text-center pt-5"><img src="<?= base_url('assets/images/ajax-loader.gif'); ?>" class="align-content-center" height="25" /></div>'
            );
            var obj = {
                sess: sess,
                cat: "LoadCourses"
            };
            $.ajax({
                type: "POST",
                url: "<?= base_url('courses/load'); ?>",
                data: obj,
                success: function(result) {
                    $('#contentArea').html(result);
                },
                error: function() {
                    AlertToastMaxi("error", "top right", "An error occurred");
                }
            });
        }
        //load register
        function loadRegister(sem, sess, level, appno){
            $('#LoadModal').modal('show');
            $('#FillModal').html(
                '<div class="col-md-12 text-center pt-5"><img src="<?= base_url('assets/images/ajax-loader.gif'); ?>" class="align-content-center" height="30" /></div>'
            );
            let obj = {
                sem: sem,
                sess: sess,
                level: level,
                appno: appno,
                cat: "LoadRegister"
            };
            $.ajax({
                type: "POST",
                url: "<?= base_url('courses/load'); ?>",
                data: obj,
                success: function(result) {
                    $('#FillModal').html(result);
                },
                error: function() {
                    AlertToastMaxi("error", "top right", "Processing error");
                }
            });
        }
        //register courses
        function registerCourses() {
            if (!fieldsValidate(['appno', 'sem', 'sess', 'level'])) return;
            let sess = $('#sess').val();
            var formData = $('#formData').serialize();
            $('#contentArea').html(
                '<div class="col-md-12 text-center pt-5"><img src="<?= base_url('assets/images/ajax-loader.gif'); ?>" class="align-content-center" height="25" /></div>'
            );
            $.ajax({
                type: "POST",
                url: "<?= base_url('courses/load'); ?>",
                data: formData,
                success: function(result) {
                    $('#contentArea').html(result);
                    loadCourses(sess);
                },
                error: function() {
                    AlertToastMaxi("error", "top right", "An error occurred");
                }
            });
        }
    </script>
</body>
</html>

<div id="LoadModal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div id="FillModal"></div>
    </div>
</div>
