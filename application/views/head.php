<?php
	$cu = get_logged_in_user();
	$co = get_logged_in_organizer();
	$mdo = (!$cu) ? "disabled" : "" ;
?>
<div class="navbar navbar-fixed-top <?=$nav?>">
	<div class="navbar-inner">
		<div class="container container-fluid">
			<div class="span2" style="margin:7px 0px; width:115px;">
				<a href="<?=base_url()?>" style="color:#555555; text-decoration:none;"><img src="<?=base_url('assets/img/bgcired.png')?>" width="26" height="26">&nbsp;<strong>BagiKasih</strong></a>
			</div>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li class="dropdown">
						<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><?=langtext('social_institute')?> <i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?=base_url('lsm')?>"><?=langtext('search').' '.langtext('social_institute')?></a></li>
							<li><a href="<?=base_url('lsm/register_project')?>"><?=langtext('register_socials')?></a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><?=langtext('fundpage')?> <i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li><a href="<?=base_url('fundraise')?>"><?=langtext('search_fundpage')?></a></li>
							<li>
								<?php if(!$cu) { ?>
									<a href="#modal" data-toggle="modal"><?=langtext('create_fundpage')?></a>
								<? } else { ?>
									<a href="<?=base_url('fundraise/create')?>"><?=langtext('create_fundpage')?></a>
								<? } ?>
							</li>
						</ul>
					</li>
				</ul>
				<ul class="nav pull-right">
					<li class="dropdown">
						<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><?=langtext('language')?> <i class="caret"></i></a>
						<ul class="dropdown-menu pull-right" style="min-width:120px;">
							<li>
								<a href="<?=base_url('home/set_lang/id')?>"><div class="span1" style="margin-left:-5px;">Indonesia </div>&emsp;<img src="<?=base_url('assets/img/flag_indonesia.png')?>"></a>
							</li>
							<li>
								<a href="<?=base_url('home/set_lang/en')?>"><div class="span1" style="margin-left:-5px;">English </div>&emsp;<img src="<?=base_url('assets/img/flag_uk.png')?>"></a>
							</li>
						</ul>
					</li>
				</ul>
				<ul class="nav pull-right">
					<?php if($cu) { ?>
						<li class="dropdown">
							<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><?=$cu->name?> <i class="caret"></i></a>
							<ul class="dropdown-menu pull-right">
								<li><a href="<?=base_url('user')?>"><?=langtext('my_account')?></a></li>
								<li><a href="<?=base_url('user/security')?>"><?=langtext('password')?></a></li>
								<li><a href="<?=base_url('user/donation_history')?>"><?=langtext('donation_history')?></a></li>
								<li><a href="<?=base_url('user/volunteer_history')?>"><?=langtext('volunteer_history')?></a></li>
								<li><a href="<?=base_url('user/fundpage_list')?>"><?=langtext('fundpage_list')?></a></li>
								<!--<li><a href="<?=base_url('user/fundpage_update')?>"><?=langtext('fundpage_update')?></a></li>-->
								<li class="divider"></li>
								<li><a href="<?=base_url('home/logout')?>">Log Out</a></li>
							</ul>
						</li>
					<? } else if($co) { ?>
						<li class="dropdown">
							<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><?=$co->name?> <i class="caret"></i></a>
							<ul class="dropdown-menu pull-right">
								<li><a href="<?=base_url('organizer')?>"><?=langtext('my_account')?></a></li>
								<li><a href="<?=base_url('organizer/edit_lsm')?>"><?=langtext('edit_soc')?></a></li>
								<li><a href="<?=base_url('organizer/edit_bank_account')?>"><?=langtext('edit_bacc')?></a></li>
								<li><a href="<?=base_url('organizer/donation_history')?>"><?=langtext('donation_history')?></a></li>
								<li><a href="<?=base_url('organizer/volunteer_history')?>"><?=langtext('volunteer_history')?></a></li>
								<li><a href="<?=base_url('organizer/fundpage_list')?>"><?=langtext('fundpage_list')?></a></li>
								<li><a href="<?=base_url('organizer/lsm_update')?>"><?=langtext('lsm_update')?></a></li>
								<li><a href="<?=base_url('organizer/security')?>"><?=langtext('password')?></a></li>
								<li class="divider"></li>
								<li><a href="<?=base_url('home/logout')?>">Log Out</a></li>
							</ul>
						</li>
					<? } else { ?>
						<li><a href="#modal" data-toggle="modal"><?=langtext('sign_in')?></a></li>
					<? } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<br><br>
<?=print_error($this->session->flashdata("err_login"))?>
<?=print_error($this->session->flashdata("login_err"))?>