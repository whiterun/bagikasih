	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
	?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata('warning'))?>
			<?=print_success($this->session->flashdata('success'))?>
				<div class="row-fluid">
					<?=$this->load->view('user_sidebar')?>
					<!-- Right side of detail page -->
					<div class="span10 thumbnail detail-boxes">
                        <h4 class="subtitle"><?=langtext('volunteer_history')?></h4>
                        <?php
							$list = OLsmList::get_volunteer_list(0, 0, 'id_volunteer DESC', 'id_buyer = '.$cu->id_buyer.' AND cancel_stat = "0" AND suspend = "0"');
							if(count($list) > 0) {
						?>
							<h5><?=langtext('volunteer')?></h5>
							<table class="table table-hovered">
								<?php
									foreach($list as $row) {
									$now = new DateTime('now');
									$dac = new DateTime($row->date_activity);
								?>
								<tr>
									<td>
										Volunteer ke <span class="text-success"><em><?=get_lsm($row->id_lsm)->name?></em></span>
										<br>
										<?php if($row->on_behalf != '') { ?>
										Atas Nama <?=$row->on_behalf?></span>
										<br>
										<? } ?>
										<?php if($row->participant != '') { ?>
										<?=$row->participant?> Participant</span>
										<br>
										<? } ?>
										<?php if($row->activity != '') { ?>
										Dalam rangka kegiatan <?=$row->activity?></span>
										<br>
										<? } ?>
										<span class="muted"><i class="icon-calendar"></i> <?=parse_date2($row->date_activity)?></span>
										&emsp;
										<?php if($dac > $now) { ?>
												<a href="#modal3" data-toggle="modal" onclick="$('#volid').val('<?=$row->id_volunteer?>'); $('.hrf').attr('href','<?=base_url(get_lsm($row->id_lsm)->url_title)?>'); $('.hrf').text('<?=get_lsm($row->id_lsm)->name?>');">( <?=langtext('cancel')?> )</a>
										<? } ?>
									</td>
								</tr>
								<? } ?>
							</table>
						<? } ?>
                    </div>
					<!-- end Right side of detail page -->
				</div>
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
					<h5 style="margin-top:-5px;"><?=langtext('cancel_volunteer_to')?><a class="hrf" href="<?=base_url($lsm->url_title)?>"><?=$lsm->name?></a></h5>
						<input type="hidden" name="id_volunteer" id="volid" />
						<textarea class="span5" style="height:100px;" name="reason" id="rsn" placeholder="<?=langtext('please_write_reasons')?>" required></textarea>
						<button type="button" class="btn btn-warning" onclick="if($.trim($('#rsn').val()).length == 0) { alert('Write some reasons first!'); } else { $('#cvolf').submit(); }">Submit</button>
				<?=form_close()?>
			</div>
		</div>
	</body>