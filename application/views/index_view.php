<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
	<title>:: Student Portal - Kogi State College of Nursing Sciences, Obangede</title>
    <?php require_once('inc/head.php'); ?>
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
									<div class="slider-content"></div>
								</div>
							</div>
							<div>
								<div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
									<div class="slide-img-bg" style="background-image: url('assets/images/originals/slide2.jpg');"></div>
									<div class="slider-content"></div>
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
							<h5 style="margin: 5px;">College of Nursing Sciences, Obangede</h5>
							<h6 style="margin: 5px;"><strong>Student Portal</strong></h6>
						</div>
						<div class="clearfix"></div>
                        <div id="contentArea">

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
<?php require_once('inc/footerscript.php'); ?>
<script>
    loadContent();
    // load content
    function loadContent() {
        var obj = {
            cat: "LoadContent"
        };
        $('#contentArea').html(
            '<div class="col-md-12 text-center pt-5"><img src="<?= base_url('assets/images/ajax-loader.gif'); ?>" class="align-content-center" height="25" /></div>'
        );
        $.ajax({
            type: "POST",
            url: "<?= base_url('index/load'); ?>",
            data: obj,
            success: function(result) {
                $('#contentArea').html(result);
            },
            error: function() {
                AlertToastMaxi("error", "top right", "An error occurred");
            }
        });
    }
    //login
    function login(){
        if (!fieldsValidate(['appno'])) return;
        var formData = $('#formData').serialize();
        $('#btnArea').html(
            '<div text-center"><img src="<?= base_url('assets/images/bars.svg'); ?>" class="align-content-center" height="20" /></div>'
        );
        $.ajax({
            type: "POST",
            url: "<?= base_url('index/load'); ?>",
            data: formData,
            success: function(result) {
                $('#btnArea').html(result);
            },
            error: function() {
                AlertToastMaxi("error", "top right", "An error occurred");
            }
        });
    }
</script>

</body>
</html>
