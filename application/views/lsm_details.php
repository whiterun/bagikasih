	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
		if($lsm->image != '')
		{
			$img = base_url('assets/images/'.$lsm->image);
		} else {
			if($lsm->id_lsm_category == '1') $img = base_url('assets/img/panti asuhan.jpg');
			else if($lsm->id_lsm_category == '2') $img = base_url('assets/img/panti jompo.jpg');
			else if($lsm->id_lsm_category == '3') $img = base_url('assets/img/panti werdha.jpg');
		}
		$adr = array('q' => $lsm->address.', '.get_city($lsm->id_kota)->name.', Indonesia');
	?>
	<body>
		<?=$this->load->view('head')?>
		<div class="content-wrap">
			<div class="container content detail">
				<?=print_error($this->session->flashdata('warning'))?>
				<?=print_success($this->session->flashdata('success'))?>
				<div class="row-fluid">
					<div class="span3 left-side">
						<center>
							<img src="<?=$img?>" class="img-polaroid" width="210">
						</center>
						<center>
							<!-- ShareThis Button BEGIN -->
							<span class='st_facebook_vcount' displayText='Facebook'></span>
							<span class='st_twitter_vcount' displayText='Tweet'></span>
							<span class='st_email_vcount' displayText='Email'></span>
							<!-- ShareThis Button END -->
						</center>
						<br>
						<?php if($lsm->volunteer == '1') { ?>
						<a href="#<?=(!$cu ? 'modal' : 'modal2' )?>" data-toggle="modal" class="btn btn-danger btn-block"><?=langtext('volunteer')?></a>
						<br>
						<? } ?>
						<iframe class="img-rounded" width="220" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&source=s_q&hl=id&geocode=&<?=http_build_query($adr)?>&ie=UTF8&z=17&t=m&iwloc=near&output=embed"></iframe><br /><small><a target="blank" href="http://maps.google.com/maps?f=q&source=s_q&hl=id&geocode=&<?=http_build_query($adr)?>&ie=UTF8&z=17&t=m&iwloc=near"><?=langtext('view_map_larger')?></a></small>
						<br><br>
						<?php
							$list = OLsmList::get_donation_list(0, 5, 'id_contribution DESC', 'id_lsm = '.$lsm->id_lsm.' AND currency = "IDR"');
							if(count($list) > 0) {
						?>
							<div class="thumbnail detail-boxes-left donasi">
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
									?>
									<tr>
										<td>
											<strong><?=$nm?></strong>
											<?php if($row->id_fundraise != '') { ?>
												<br><?=langtext('via')?> <a href="<?=base_url(get_fundraise($row->id_fundraise)->url_title)?>"><?=get_fundraise($row->id_fundraise)->name?></a>
											<? } ?>
											<span class="muted" ><p><i class="icon-calendar-empty"></i> <?=parse_date2($row->date_contribution)?></p></span>
											<p><h4><?=rupiah_format($row->amount)?></h4></p>
										</td>
									</tr>
									<? } ?>
								</table>
							</div>
							<br>
						<? } ?>
						<div class="thumbnail detail-boxes-left">
							<h4 class="subtitle"><?=langtext('statistics')?></h4>
							<p><?=langtext('volunteer')?> :<span class="pull-right"><?=count_volunteer($lsm->id_lsm)->volunteer?></span><br></p>
							<p><?=langtext('member')?> :<span class="pull-right"><?=count_member($lsm->id_lsm)->member?></span><br></p>
							<p>Fundraiser :<span class="pull-right"><?=count_funder($lsm->id_lsm)->funder?></span><br></p>
							<p><?=langtext('collected')?> :<span class="pull-right"><?=rupiah_format(get_funded($lsm->id_lsm)->amt)?></span><br></p>
						</div>
						<br>
					</div>
					<!-- Right side of detail page -->
					<div class="span9 right-side">
						<div class="row-fluid">
							<div class="span9 profile-title">
								<h3><?=$lsm->name?></h3>
								<span><i class="icon-map-marker"></i>&nbsp;<?=$lsm->address?>, <?=get_city($lsm->id_kota)->name?></span><br><br>
								<div class="fb-like" data-href="http://bagikasih.com/<?=uri_string()?>" data-send="true" data-width="500" data-show-faces="false"></div>
							</div>
							<div class="span3 text-center">
								<button type="button" class="btn btn-danger btn-block" onclick="location.href='<?=base_url('user/donate/'.$lsm->id_lsm)?>';"><h4><?=langtext('give_donation')?></h4></button>
								<?php if($cu) { ?>
									<button class="btn btn-danger btn-block" onclick="location.href='<?=base_url('fundraise/create/'.$lsm->id_lsm)?>';"><h4><?=langtext('fundraise')?></h4></button>
								<? } else { ?>
									<a href="#modal" data-toggle="modal" class="btn btn-danger btn-block"><h4><?=langtext('fundraise')?></h4></a>
								<? } ?>
							</div>
						</div>
						<hr>
						<?php
							$list = OLsmList::get_lgallery(0, 5, 'id_lgallery DESC', 'id_lsm = '.$lsm->id_lsm);
							if(count($list) > 0) {
						?>
						<div class="thumbnail detail-boxes">
							<div class="row-fluid">
								<?php foreach($list as $row) { ?>
									<a rel="group" class="fancybox" href="<?=base_url('assets/images/lsfund/600/'.$row->image_name)?>"><img src="<?=base_url('assets/images/lsfund/200/'.$row->image_name)?>" class="img-polaroid" style="height:64px;margin:1.5px 0;" /></a>
								<? } ?>
							</div>
						</div>
						<br>
						<? } ?>
						<?php
							$list = OLsmList::get_lupdate(0, 0, 'a.id_update DESC', 'b.id_lsm = '.$lsm->id_lsm);
							if(count($list) > 0) {
						?>
						<div class="thumbnail detail-boxes recent-update">
							<h4 class="subtitle"><?=langtext('recent_updates')?></h4>
							<table class="table table-hover">
								<?php foreach($list as $row) { ?>
								<tr>
									<td>
										<div class="row-fluid">
											<div class="span8"><h4 class="media-heading"><?=$row->title?></h4></div>
											<div class="span4"><span class="pull-right muted"><i class="icon-calendar-empty"></i> <?=parse_date2($row->dt)?></span></div>
										</div>
										<?=auto_tidy($row->content)?>
									</td>
								</tr>
								<? } ?>
							</table>
						</div><br>
						<? } ?>
						<div class="thumbnail detail-boxes">
							<h4 class="subtitle">Info</h4>
							<?=auto_tidy($lsm->deskripsi)?>
						</div><br>
						<?php
							$l = OLsmMember::get_list(0, 0, "id_member DESC", "id_lsm = ".$lsm->id_lsm);
							if(count($l) > 0) {
						?>
						<div class="thumbnail detail-boxes member">
							<h4 class="subtitle"><?=langtext('member')?>:</h4>
							<div class="media">
								<?php
									$a = 1;
									foreach($l as $r) {
									
									$ft = ($r->foto != '') ? $r->foto : 'no-photo.jpg' ;
									$ft2 = base_url('assets/images/'.$ft);
								?>
								<a href="#" class="pull-left">
									<img src="<?=$ft2?>" class="media-object img-rounded img-polaroid">
									<h6><?=$r->name?><br>(<?=$r->age?> Th)</h6>
								</a>
								<? } ?>
							</div>
						</div><br>
						<? } ?>
						<?php
							$list = OUser::get_fundpage_list(0, 5, 'id_fundraise DESC', 'end_date >= "'.date('Y-m-d').'" && id_lsm = '.$lsm->id_lsm);
							if(count($list) > 0) {
						?>
						<div class="thumbnail detail-boxes fundraiser">
							<h4 class="subtitle">Fundraiser</h4>
							<table class="table table-hover">
								<?php
									foreach($list as $row) {
									$don = get_funded('', $row->id_fundraise)->amt;
									$pro = ceil(($don / $row->fund_target * 100));
								?>
								<tr>
									<td>
										<div class="row-fluid">
											<div class="span8">
												<h4><a href="<?=base_url('fundpage/'.$row->url_title)?>"><?=$row->name?></a></h4>
												<span class="muted"><?=langtext('created_by')?> <a href="#"><?=get_buyer($row->id_buyer)->name?></a></span>
												<div style="margin-top:5px;">
													<h4><?=$pro?>% <small class="muted"><?=langtext('from_tgt')?></small> <?=rupiah_format($row->fund_target)?></h4>
												</div>
											</div>
											<div class="span4">
												<h4 class="text-right"><small><?=langtext('collected')?></small> <?=rupiah_format($don)?></h4>
												<div class="muted text-right"><strong><?=ddiff($row->end_date)?></strong> <?=langtext('day-s')?></div>
												<button onclick="location.href='<?=base_url('fundpage/'.$row->url_title)?>';" class="btn btn-danger span6 pull-right"><?=langtext('support')?></button>
											</div>
										</div>
									</td>
								</tr>
								<? } ?>
							</table>
						</div><br>
						<? } ?>
						<?php
							$list = OLsmList::get_volunteer_list(0, 0, 'id_volunteer DESC', 'id_lsm = '.$lsm->id_lsm.' AND cancel_stat = "0" AND suspend = "0"');
							if(count($list) > 0) {
						?>
						<div class="thumbnail detail-boxes volunteer">
							<h4 class="subtitle"><?=langtext('volunteer')?></h4>
							<table class="table table-hover">
								<?php
									foreach($list as $row) {
									$ano = ($row->on_behalf == '') ? get_buyer($row->id_buyer)->name : $row->on_behalf ;
									$now = new DateTime('now');
									$dac = new DateTime($row->date_activity);
								?>
								<tr>
									<td>
										<span class="muted pull-right"><i class="icon-calendar"></i> <?=parse_date2($row->date_activity)?></span>
										<h5><?=$ano?><a class="tooltip1" href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="Jumlah orang yang di bawa"> <?php if($row->participant != '') { ?>(+<?=$row->participant?>)<? } ?></a></h5>
										<blockquote>
											<?=$row->activity?>
										</blockquote>
										<div class="pull-right">
										<?php
											if($dac > $now) {
											if($row->id_buyer == $cu->id_buyer) { ?>
												<a href="#modal3" data-toggle="modal" onclick="$('#volid').val('<?=$row->id_volunteer?>');">( <?=langtext('cancel')?> )</a>
												&emsp;
										<? } } ?>
											<a href="#modal4" data-toggle="modal" onclick="$('#vlid').val('<?=$row->id_volunteer?>');">( <?=langtext('report_this')?> )</a>
										</div>
									</td>
								</tr>
								<? } ?>
							</table>
						</div>
						<br>
						<? } ?>
						<?php
							$list = OLsmList::get_lvideo(0, 5, 'id_lvideo DESC', 'id_lsm = '.$lsm->id_lsm);
							if(count($list) > 0) {
						?>
						<div class="thumbnail detail-boxes">
							<h4 class="subtitle">Video</h4>
							<div class="row-fluid">
								<center>
									<?php
										foreach($list as $row) {
										if($row->video_link != '') {
									?>
										<iframe width="475" height="375"
											src="<?=$row->video_link?>"
											allowfullscreen frameborder="0">
										</iframe>
									<? } } ?>
								</center>
							</div>
						</div>
						<br>
						<? } ?>
						<div class="fb-comments" data-href="http://bagikasih.com/<?=uri_string()?>" data-width="700" data-num-posts="10"></div>
						<br>
					</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
		
		<div style="width:411px; left:56%;" id="modal2" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="text-center"><?=langtext('volunteer_form')?></h4>
			</div>	
			<div class="modal-body">
				<?=form_open('lsm/volunteer', array('id'	=> 'vol_form'))?>
					<?=print_error($error_string)?>
					<?=print_error(validation_errors())?>
						<input type="hidden" name="id_lsm" value="<?=$lsm->id_lsm?>">
						<label>Volunteer Date</label>
						<input type="text" class="span3" id="dp3" value="<?=date('Y-m-d')?>" name="date_activity" readonly required /><br>
						<label class="help-inline">Participant : </label>
						<input type="text" name="participant" class="span1"/>
						<label class="checkbox"><input type="checkbox" id="ano" /> Atas Nama Organisasi</label>
						<input type="text" class="span4" id="on_behalf" name="on_behalf" disabled />
						<label class="checkbox"><input type="checkbox" id="nk" /> Nama Kegiatan</label>
						<textarea class="span5" style="height:100px;" id="activity" name="activity" disabled></textarea>
						<button type="button" class="btn btn-warning" onclick="$('#vol_form').submit();">Submit</button>
				<?=form_close()?>
			</div>
		</div>
		
		<div style="width:411px; left:55%;" id="modal3" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="text-center"><?=langtext('cancel_volunteer')?></h4>
			</div>	
			<div class="modal-body">
				<?=form_open('lsm/cancel_volunteer', array('id'	=> 'cvolf'))?>
					<?=print_error($error_string)?>
					<?=print_error(validation_errors())?>
					<h5 style="margin-top:-5px;"><?=langtext('cancel_volunteer_to')?><a href="<?=base_url($lsm->url_title)?>"><?=$lsm->name?></a></h5>
						<input type="hidden" name="id_volunteer" id="volid" />
						<textarea class="span5" style="height:100px;" name="reason" id="rsn" placeholder="<?=langtext('please_write_reasons')?>" required></textarea>
						<button type="button" class="btn btn-warning" onclick="if($.trim($('#rsn').val()).length == 0) { alert('Write some reasons first!'); } else { $('#cvolf').submit(); }">Submit</button>
				<?=form_close()?>
			</div>
		</div>
		
		<div style="width:480px; left:53%;" id="modal4" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="text-center"><?=langtext('report_volunteer')?></h4>
			</div>	
			<div class="modal-body">
				<?=form_open('lsm/report_volunteer', array('id'	=> 'rvolf'))?>
					<?=print_error($error_string)?>
					<?=print_error(validation_errors())?>
						<input type="hidden" name="id_volunteer" id="vlid" />
						<table width="100%">
							<tr>
								<td valign="top" width="35%"><b><?=langtext('report_as')?> : </b></td>
								<td>
									<label class="radio">
										<input type="radio" name="rep" value="1" checked>Spam or Scam
									</label>
									<label class="radio">
										<input type="radio" name="rep" value="2">Hate Speech
									</label>
									<label class="radio pull-left">
										<input type="radio" name="rep" value="0">Other
									</label>
									<div id="val_rep" style="display:none;">
										<br>
										<textarea class="span4" style="height:100px;" name="other" id="res" placeholder="<?=langtext('please_write_reasons')?>" required></textarea>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<button type="button" class="btn btn-warning" onclick="rvolf();">Submit</button>
								</td>
							</tr>
						</table>
				<?=form_close()?>
			</div>
		</div>
	</body>