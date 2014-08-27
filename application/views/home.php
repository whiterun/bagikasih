<?php
	$cu = get_logged_in_user();
	$co = get_logged_in_organizer();
	$mdo = (!$cu) ? "disabled" : "" ;
?>
	<body>
		<div class="showcase" style="height:380px;">
			<div class="navbar navbar-static-top" style="margin: -1px 0px 15px;">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="<?=base_url()?>">BagiKasih</a>
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
									<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Bahasa <i class="caret"></i></a>
									<ul class="dropdown-menu pull-right" style="min-width:120px;">
										<li>
											<a href="<?=base_url('home/set_lang/id')?>"><div class="span1" style="margin-left:-5px;">Indonesia </div>&nbsp;&nbsp;&nbsp;<img src="<?=base_url('assets/img/flag_indonesia.png')?>"></a>
										</li>
										<li>
											<a href="<?=base_url('home/set_lang/en')?>"><div class="span1" style="margin-left:-5px;">English </div>&nbsp;&nbsp;&nbsp;<img src="<?=base_url('assets/img/flag_uk.png')?>"></a>
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
			<div class="top-logo text-center">
				<a href="#">
					<img src="<?=base_url('assets/img/bgcired.png')?>" class="img-circle">
				</a>
			</div>
			<div class="slider container" style="margin-top:30px;">
				<?php
					$tsl = OBanner::get_list(0, 5, 'id_banner ASC');
					foreach($tsl as $wor) {
				?>
					<div class="row">
						<div class="span8">
							<img src="<?=base_url('assets/images/'.$wor->image)?>" />
						</div>
						<div class="span4" style="margin-left:-25px;">
							<h4><?=$wor->title?></h4>
							<?=auto_tidy($wor->description)?>
						</div>
					</div>
				<? } ?>
				<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
				<a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
			</div>
		</div>
		<div class="action-text">
			<div class="container">
				<div class="row">
					<div class="span4">
						<h3><em>So, What do You Want?</em></h3>
					</div>
					<div class="span8">
						<ul class="unstyled inline pull-right">
							<li><a href="<?=base_url('fundraise')?>">Fundraising</a></li>
							<li><a href="<?=base_url('lsm')?>">Donate</a></li>
							<li><a href="<?=base_url('home/register')?>">Register</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Content section -->
		<div class="feature-description">
			<div class="container">
				<?php
					$wher1 = array(" featured = 1", " approved = 1");
					$wher2 = implode(" AND ",$wher1);
					
					$list = OLsmList::get_list(0, 3, 'id_lsm DESC', $wher2);
					$sp = (count($list) > 0) ? 'span7' : 'span12' ;
				?>
				<div class="row">
					<div class="<?=$sp?>">
						<h4><?=langtext('social_institute')?> <?php if(count($list) > 0) { ?><a href="<?=base_url('lsm')?>"><?=langtext('see_all')?></a><? } ?></h4>
						<p>
							At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint... 
						</p>
					</div>
					<?php if(count($list) > 0) { ?>
					<div class="span5">
						<?php
							foreach($list as $row) {
								if($row->image != '')
								{
									$img = base_url('assets/images/'.$row->image);
								} else {
									if($row->id_lsm_category == '1') $img = base_url('assets/img/panti asuhan.jpg');
									else if($row->id_lsm_category == '2') $img = base_url('assets/img/panti jompo.jpg');
									else if($row->id_lsm_category == '3') $img = base_url('assets/img/panti werdha.jpg');
								}
						?>
						<a href="<?=base_url($row->url_title)?>" title="<?=$row->name?>" style="text-decoration:none;">
							<img src="<?=$img?>" class="img-polaroid img-rounded" style="width:110px; height:80px;" />
						</a>
						<? } ?>
					</div>
					<? } ?>
				</div>
				<?php
					$wher1 = array(" featured = 1", " approved = 1");
					$wher2 = implode(" AND ",$wher1);
					
					$list = OLsmList::get_fundraise_list(0, 3, 'id_fundraise DESC', $wher2);
					$sp = (count($list) > 0) ? 'span7' : 'span12' ;
				?>
				<div class="row">
					<?php if(count($list) > 0) { ?>
					<div class="span5">
						<?php
							foreach($list as $row) {
							
							if(get_lsm($row->id_lsm)->image != '')
							{
								$img = base_url('assets/images/'.get_lsm($row->id_lsm)->image);
							} else {
								if(get_lsm($row->id_lsm)->id_lsm_category == '1') $img = base_url('assets/img/panti asuhan.jpg');
								else if(get_lsm($row->id_lsm)->id_lsm_category == '2') $img = base_url('assets/img/panti jompo.jpg');
								else if(get_lsm($row->id_lsm)->id_lsm_category == '3') $img = base_url('assets/img/panti werdha.jpg');
							}
						?>
						<a href="<?=base_url('fundpage/'.$row->url_title)?>" title="<?=$row->name?>" style="text-decoration:none;">
							<img src="<?=$img?>" class="img-polaroid img-rounded" style="width:110px; height:80px;" />
						</a>
						<? } ?>
					</div>
					<? } ?>
					<div class="<?=$sp?>">
						<h4><?=langtext('fundpage')?> <?php if(count($list) > 0) { ?><a href="<?=base_url('fundraise')?>"><?=langtext('see_all')?></a><? } ?></h4>
						<p>
							At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint... 
						</p>
					</div>
				</div>
				<div class="row">
					<div class="span4">
						<a class="twitter-timeline" href="https://twitter.com/bagi_kasih" data-widget-id="425573628625711104" data-chrome="nofooter">Tweets by @bagi_kasih</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</div>
					<div class="span4">
						<div class="thumbnail detail-boxes event-feed">
							<h4 class="subtitle">Our Blog</h4>
							<div class="media">
								<a class="pull-left" href="#">
								<img src="pixlholder.js/40x40">
								</a>
								<div class="media-body">
									<h5 class="media-heading"><a href="#">CARIF's Be Frank Campaign in The Star</a></h5>
								</div>
							</div>
							<div class="media">
								<a class="pull-left" href="#">
									<img src="pixlholder.js/40x40">
								</a>
								<div class="media-body">
									<h5 class="media-heading"><a href="#">Freedom Fighters in Campuslife.com.my</a></h5>
								</div>
							</div>
							<div class="media">
								<a class="pull-left" href="#">
									<img src="pixlholder.js/40x40">
								</a>
								<div class="media-body">
									<h5 class="media-heading"><a href="#">BagiKasih.com a 'hot find' in The Finder Singapore</a></h5>
								</div>
							</div>
							<div class="media">
								<a class="pull-left" href="#">
									<img src="pixlholder.js/40x40">
								</a>
								<div class="media-body">
									<h5 class="media-heading"><a href="#">Update on donations to overseas charities for ..</a></h5>
								</div>
							</div>
							<button class="btn btn-block btn-small">Veiw All</button>
						</div>
					</div>
					<div class="span4">
						<div class="thumbnail">
							<div id="fb-root"></div>
							<div class="fb-like-box" data-href="http://www.facebook.com/bagikasih.id" data-width="300px" data-height="310px" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end Content section -->