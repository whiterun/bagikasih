	<?php $co = get_logged_in_organizer(); ?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata('warning'))?>
			<?=print_success($this->session->flashdata('success'))?>
				<div class="row-fluid">
					<?=$this->load->view('organizer_sidebar')?>
					<!-- Right side of detail page -->
					<div class="span9 thumbnail detail-boxes">
                        <h4 class="subtitle"><?=langtext('volunteer_history')?></h4>
                        <?php
							$list = OLsmList::get_volunteer_list(0, 0, 'id_volunteer DESC', 'id_lsm = '.$co->id_lsm.' AND suspend = "0"');
							if(count($list) > 0) {
						?>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>ID</th>
										<th>User</th>
										<th>Volunteer Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>                
								<?php 
									$i = 1;
									foreach($list as $row) {
									extract(get_object_vars($row));
									$now = new DateTime('now');
									$dac = new DateTime($date_activity);
								?>
									<tr>
										<td><?=$i?></td>            
										<td>
											<?=get_buyer($id_buyer)->name?>
											<?php if($participant != '') { ?>(+<?=$participant?>)<? } ?>
											<?php if($on_behalf != '') { ?>
												<br>Atas Nama <?=$on_behalf?>
											<? } ?>
										</td>
										<td><?=parse_date2($date_activity)?></td>
										<td>
											<?php
												if($suspend == 1) {
														echo "<span class='red'>Suspended</span>";
												} else {
													if($cancel_stat == 0) {
														echo "<span class='green'>Active</span>";
													} else {
														echo "<span class='red'>Cancelled</span>";
													}
												}
											?>
										</td>
										<td>
											<div class="btn-group">
												<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
												<ul class="dropdown-menu" style="min-width:111px;">
												<?php if($activity != '') { ?>
													<li><a data-toggle="modal" href="<?=base_url('organizer/volunteer_detail/'.$id_volunteer)?>" data-target="#modal5">View Detail</a></li>
												<? } ?>
												<?php
													if($dac > $now) {
													if($cancel_stat == 0) {
												?>
													<li><a href="#modal3" data-toggle="modal" onclick="$('#volid').val('<?=$id_volunteer?>'); $('.hrf').attr('href','<?=base_url(get_lsm($id_lsm)->url_title)?>'); $('.hrf').text('<?=get_lsm($id_lsm)->name?>');"><?=langtext('cancel')?></a></li>
												<? } } ?>
												<?php
													if($dac > $now) {
													if($cancel_stat == 0) {
												?>
													<li><a href="#modal4" data-toggle="modal" onclick="$('#vlid').val('<?=$row->id_volunteer?>');"><?=langtext('report_this')?></a></li>
												<? } } ?>
													<li><?=anchor("organizer/volunteer_delete/".$id_volunteer, "Delete", array("onclick" => "return confirm('Are you sure?');"));?></li>
												</ul>
											</div>
										</td>
									</tr>
								<?php $i++; } ?>	
								</tbody>
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
		
		<div id="modal5" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="text-center">Detail Volunteer</h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</body>