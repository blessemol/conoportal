<?php
if(!$userdet['picpath']){
	$picpath = base_url('assets/images/user.jpg');
}
else{
	$picpath = $userdet['picpath'];
}
?>
<div class="app-header header-shadow">
	<div class="app-header__logo">
		<div class="logo-src"></div>
		<div class="header__pane ml-auto">
			<div>
				<button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
				</button>
			</div>
		</div>
	</div>
	<div class="app-header__mobile-menu">
		<div>
			<button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
			</button>
		</div>
	</div>
	<div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
	</div>
	<div class="app-header__content">
		<div class="app-header-right">
			<!--<div style="margin-right: 10px;"><strong>Current:</strong> <?php print $activesess; ?> session</div>-->
			<div class="header-dots">
				<a href="<?php print base_url('logout'); ?>" class="btn-shadow p-1 btn btn-primary btn-sm">
					Logout
				</a>
			</div>
			<div class="header-btn-lg pr-0">
				<div class="widget-content p-0">
					<div class="widget-content-wrapper">
						<div class="widget-content-left">
							<div class="btn-group">
								<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
									<img style="margin-right: 0px;" width="42" class="rounded-circle" src="<?php print $picpath; ?>" alt="">
								</a>
							</div>
						</div>
						<div class="widget-content-left  ml-3 header-user-info">
							<div class="widget-heading"> <?php print $userdet['firstname']." ".$userdet['lastname']; ?> </div>
							<div class="widget-subheading"> [App No: <?php print $appno; ?>] </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
