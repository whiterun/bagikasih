	<?php
		$bg  = '';
		$cu  = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
		$lsm = get_lsm($fra->id_lsm);
		$gsr = get_buyer($fra->id_buyer);
		$tdn = get_funded('', $fra->id_fundraise)->amt;
		if($gsr->fb_id == '') $fmg = base_url('assets/img/skas.png');
		else $fmg = "https://graph.facebook.com/".$gsr->fb_id."/picture?type=normal";
		
		if($fra->theme == 'dark') {
			$bg .= '#333 ';
		}
		if($fra->background == 'yes') {
			$bg .= 'url('.base_url('assets/images/'.get_bgimg($fra->id_fundraise)->img_name).')';
		}
		
		if($fra->theme == 'dark') {
			$th	= 'dark-theme';
			$dt['nav'] = 'navbar-inverse';
		}
	?>
	<style>
		body { background:<?=$bg?>; }
	</style>
	<body class="<?=$th?>">
		<?=$this->load->view('head', $dt)?>
		<!-- Content section -->
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata('warning'))?>
			<?=print_success($this->session->flashdata('success'))?>
				<div class="row-fluid">
					<div class="span8 left-side">
						<div class="thumbnail detail-boxes">
							<div class="row-fluid">
								<div class="span12 profile-title">
									<h3><?=$fra->name?></h3>
									<div class="fb-like" data-href="http://bagikasih.com/<?=uri_string()?>" data-send="true" data-width="500" data-show-faces="false" data-colorscheme="<?=$fra->theme?>"></div>
								</div>
							</div>
							<hr>
							<!-- ShareThis Button BEGIN -->
								<span class='st_facebook_vcount' displayText='Facebook'></span>
								<span class='st_twitter_vcount' displayText='Tweet'></span>
								<span class='st_linkedin_vcount' displayText='LinkedIn'></span>
								<span class='st_pinterest_vcount' displayText='Pinterest'></span>
								<span class='st_email_vcount' displayText='Email'></span>
							<!-- ShareThis Button END -->
						</div>
						<br>
						<?php
							$list = OUser::get_fundpage_update(0, 5, 'id_fupdate DESC', 'id_fundraise = '.$fra->id_fundraise);
							if(count($list) > 0) {
						?>
						<div class="thumbnail detail-boxes recent-update">
							<h4 class="subtitle"><?=langtext('recent_updates')?></h4>
							<table class="table table-hover">
								<?php foreach($list as $row) { ?>
								<tr>
									<td>
										<div class="row-fluid">
											<div class="span4"><span class="muted"><i class="icon-calendar-empty"></i> <?=parse_date2($row->date_created)?></span></div>
											<!--<div class="span8"><h4 class="media-heading"><?=get_buyer($row->id_buyer)->name?></h4></div>-->
										</div>
										<?=auto_tidy($row->description)?>
									</td>
								</tr>
								<? } ?>
							</table>
						</div><br>
						<? } ?>
						<div class="thumbnail detail-boxes">
							<h4 class="subtitle">Info</h4>
							<?=auto_tidy($fra->description)?>
						</div><br>
						<?php
							$list = OLsmList::get_fgallery(0, 5, 'id_fgallery DESC', 'id_fundraise = '.$fra->id_fundraise);
							if(count($list) > 0) {
						?>
						<div class="thumbnail detail-boxes">
							<h4 class="subtitle"><?=langtext('gallery')?></h4>
							<div class="row-fluid">
								<?php foreach($list as $row) { ?>
									<div class="span2"><a class="fancybox" rel="group" href="<?=base_url('assets/images/lsfund/600/'.$row->image_name)?>"><img src="<?=base_url('assets/images/lsfund/200/'.$row->image_name)?>" class="img-rounded" style="height:84px;"></a></div>
								<? } ?>
							</div>
						</div>
						<br>
						<? } ?>
						<?php
							$list = OLsmList::get_fvideo(0, 5, 'id_flvideo DESC', 'id_fundraise = '.$fra->id_fundraise);
							if(count($list) > 0) {
						?>
						<div class="thumbnail detail-boxes">
							<h4 class="subtitle"><?=langtext('videos')?></h4>
							<div class="row-fluid">
								<?php
									foreach($list as $row) {
									if($row->video_link != '') {
								?>
								<center>
									<iframe width="400" height="332"
										src="<?=$row->video_link?>"
										allowfullscreen frameborder="0">
									</iframe>
								</center>
								<!--<div class="span4"><a href="#"><img src="holder.js/190x100/#555:#ccc" class="img-rounded"></a></div>-->
								<? } } ?>
							</div>
						</div>
						<br>
						<? } ?>
						<div class="fb-comments" data-href="http://bagikasih.com/<?=uri_string()?>" data-colorscheme="<?=$fra->theme?>" data-width="620" data-num-posts="10"></div>
						<br>
					</div>
					<!-- Right side of detail page -->
					<div class="span4 right-side fundraiser-profile">
						<div class="thumbnail">
							<div class="row-fluid ">
								<div class="span5">
									<img src="<?=$fmg?>" class="img-rounded">
								</div>
								<div class="span7">
									<span class="muted"><?=ucfirst(langtext('created_by'))?></span>
									<h4><?=$gsr->name?></h4>
								</div>
							</div>
							<span class="lead muted"><?=langtext('raise_funds')?><br><a href="<?=base_url($lsm->url_title)?>"><?=$lsm->name?></a></span>
							<div class="bottom-section">
								<div class="row-fluid">
									<div class="input-append">
										<input id="uritex" style="height:16px; width:155px; font-size:12px;" id="appendedInputButtons" type="text" value="bagikasih.com/fundpage/<?=$fra->url_title?>" readonly>
										<a href="#" id="zcopy" class="btn btn-default btn-small" style="color:#333;" title="Copy to Clipboard"><i class="icon-share"></i></a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
										</script>
										<a href="#" onclick="send_message();" target="_blank" class="btn btn-sky btn-small"><i class="icon-facebook"></i> Facebook</a>
									</div>
								</div>
								<button class="btn btn-primary btn-large btn-block" onclick="location.href='<?=base_url('user/donate/'.$fra->id_lsm.'/'.$fra->id_fundraise)?>';"><?=langtext('give_donation')?></button>
							</div>
						</div>
						<br>
						<div class="thumbnail detail-boxes statistik">
							<div class="row-fluid">
								<h2><?=rupiah_format($fra->fund_target)?></h2>
								<span><?=langtext('fund_target')?></span>
								<h2><?=rupiah_format($tdn)?></h2>
								<span><?=langtext('coll_funds')?></span>
								<h2><?=ddiff($fra->end_date)?></h2>
								<span><?=langtext('day-s')?></span>
							</div>
						</div>
						<br>
						<?php
							$list = OLsmList::get_donation_list(0, 5, 'id_contribution DESC', 'id_fundraise = '.$fra->id_fundraise.' AND currency = "IDR"');
							if(count($list) > 0) {
						?>
						<div class="thumbnail detail-boxes donasi">
							<h4 class="subtitle"><?=langtext('donation')?></h4>
							<table class="table table-hover">
								<?php
									foreach($list as $row) {
									if($row->anonym == 'yes') {
										$nm = 'Anonymous';
									} else {
										if($row->id_buyer != '') {
											$nm = get_buyer($row->id_buyer)->name;
										} else {
											$nm = $row->name;
										}
									}
									// $mn = ($row->currency == 'USD') ? ceil($row->amount * 11532) : $row->amount ;
								?>
								<tr>
									<td><span class="muted pull-right" ><i class="icon-calendar-empty"></i> <?=parse_date2($row->date_contribution)?></span>
										<strong><?=$nm?></strong>
										<h4><?=rupiah_format($row->amount)?></h4>
										<!--<div class="comment-donator" style="position:relative;">
											<div class="arrow arrow-right"></div>
											vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.
										</div>-->
									</td>
								</tr>
								<? } ?>
							</table>
							<!--<center>
								<div class="pagination pagination-small">
									<ul>
										<li><a href="#">&larr;</a></li>
										<li><a href="#">1</a></li>
										<li><a href="#">2</a></li>
										<li><a href="#">3</a></li>
										<li><a href="#">&rarr;</a></li>
									</ul>
								</div>
							</center>-->
						</div>
						<br>
						<? } ?>
					</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>