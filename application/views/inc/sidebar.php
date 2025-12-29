<div class="app-sidebar sidebar-shadow">
	<div class="app-header__logo">
		<div class="logo-src"><img src="<?php print base_url('assets/images/logo-inverse.png'); ?>" height="30px"></div>
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
	<div class="scrollbar-sidebar">
		<div class="app-sidebar__inner">
			<ul class="vertical-nav-menu">
				<li class="app-sidebar__heading">Menu</li>
				<li class="<?php if(isset($page) && $page=='personal_info'){ print 'mm-active'; } ?>">
					<a href="<?php echo base_url('personal_info'); ?>">
						<i class="metismenu-icon pe-7s-id"></i>Personal Info.
					</a>
				</li>
				<li class="<?php if(isset($page) && $page=='payment'){ print 'mm-active'; } ?>">
					<a href="<?php echo base_url('payment'); ?>">
						<i class="metismenu-icon pe-7s-cash"></i>Payment
					</a>
				</li>
				<li class="<?php if(isset($page) && $page=='courses'){ print 'mm-active'; } ?>">
					<a href="<?php echo base_url('courses'); ?>">
						<i class="metismenu-icon pe-7s-notebook"></i>Courses
					</a>
				</li>
				<li>
					<a href="<?php echo base_url('logout'); ?>">
						<i class="metismenu-icon pe-7s-power"></i>Logout
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>

