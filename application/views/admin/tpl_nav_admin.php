<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			</a>
			<a class="brand" href="#">Admin Panel</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li><?=anchor("admin/home", "Home")?></li>
					<li><?=anchor("admin/users", "Users")?></li>
					<li class="dropdown">
						<?=anchor("#", 'LSM <i class="caret"></i>', array('role' => 'button', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'))?>
						<ul class="dropdown-menu">
							<li><?=anchor("admin/lsm_list", "LSM List")?></li>
							<li><?=anchor("admin/lsm_category", "LSM Category")?></li>
							<li><?=anchor("admin/lsm_member", "LSM Member")?></li>
							<li><?=anchor("admin/lsm_organizer", "LSM Organizer")?></li>
							<li><?=anchor("admin/lsm_update", "LSM Blog Update")?></li>
							<li><?=anchor("admin/donation_list", "Donation List")?></li>
							<li><?=anchor("admin/volunteer_list", "Volunteer List")?></li>
							<li><?=anchor("admin/volunteer_report", "Volunteer Report")?></li>
						</ul>
					</li>
					<li><?=anchor("admin/fundpage", "Fundpage")?></li>
					<li><?=anchor("admin/locations", "Location")?></li>
					<li><?=anchor("admin/area", "Area")?></li>
					<li><?=anchor("admin/bank", "Bank")?></li>
					<li><?=anchor("admin/banner", "Banner")?></li>
					<li class="dropdown">
						<?=anchor("#", 'Information <i class="caret"></i>', array('role' => 'button', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'))?>
						<ul class="dropdown-menu">
							<li><?=anchor("admin/info/about_us", "About Us")?></li>
							<li><?=anchor("admin/info/contact_us", "Contact Us")?></li>
							<li><?=anchor("admin/info/faq", "F.A.Q")?></li>
							<li><?=anchor("admin/info/links", "Links")?></li>
						</ul>
					</li>
					<li><?=anchor("admin/home/logout", "Logout")?></li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>