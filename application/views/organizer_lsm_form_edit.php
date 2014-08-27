	<?php
		if($row)
		{
			extract(get_object_vars($row));	
			$P = new OLsmList();
			$P->setup($row);
		}
		$exp = ($fund_target == 0.00) ? '' : str_replace('.00', '', $fund_target) ;
		extract($_POST);
	?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
				<?=print_error($error_string)?>
				<?=print_error(validation_errors())?>
				<?=print_error($this->session->flashdata('warning'))?>
				<?=print_success($this->session->flashdata('success'))?>
				<div class="row-fluid">
					<?=$this->load->view('organizer_sidebar')?>
					<!-- Right side of detail page -->
						<div class="span9 thumbnail detail-boxes">
							<h4 class="subtitle"><?=langtext('edit_soc')?></h4>
							<?=form_open()?>
								<table cellpadding="4">
									<tr>
										<td>LSM Name <span class="red">*</span></td>
										<td>
											<div class="span5"><input id="lname" name="lname" type="text" value="<?=$name?>" required /></div>
											<div class="span7" id='lname_result' style="height:40px;"></div>
										</td>
									</tr>
									<tr>
										<td>LSM Url <span class="red">*</span></td>
										<td><label class="checkbox" style="padding-left:0;">http://bagikasih.com/ <input id="urlname" name="urlname" type="text" value="<?=$url_title?>" required /></label></td>
									</tr>
									<tr>
										<td>Category <span class="red">*</span></td>
										<td><?=OLsmCategory::drop_down_select("category", $id_lsm_category)?></td>
									</tr>
									<tr>
										<td>Location <span class="red">*</span></td>
										<td><?=OLocation::drop_down_select("kota", $id_kota, 'onchange="show_drop_area();"')?></td>
									</tr>
									<input type="hidden" id="tarea" value="<?=$id_area?>" />
									<tr>
										<td id="get_area" colspan="2"></td>
									</tr>
									<tr>
										<td>Address <span class="red">*</span></td>
										<td><input name="address" type="text" value="<?=$address?>" required /></td>
									</tr>
									<tr>
										<td valign="top">Description <span class="red">*</span></td>
										<td><textarea id="mce" name="deskripsi" class="input-xxlarge" rows="3"><?=auto_tidy($deskripsi)?></textarea></td>
									</tr>
									<tr>
										<td>Expense</td>
										<td>
											<div class="input-prepend">
												<span class="add-on">RP</span>
												<input type="text" name="target" value="<?=$exp?>" class="currfix" />
											</div>
										</td>
									</tr>
									<tr>
										<td>Volunteer Form</td>
										<td>
											<label class="checkbox">
												<input type="checkbox" name="volunteer" value="1" <?=($volunteer == 1 ? 'checked' : '' )?> />
												If checked, mean people can volunteer to your LSM
											</label>
										</td>
									</tr>
									<tr>
										<td valign="top">Profile Picture</td>
										<td>
											<input name="userfile" type="file" id="userfile" />
											<p>Image types allowed (jpg, png, gif), having maximum size of 1 MB &amp; minimum resolution 150px x 150px</p>
											<?php if($image != '') { ?>
												<img src="<?=base_url('assets/images/'.$image)?>" width="150" class="img-polaroid" />
											<? } ?>
										</td>
									</tr>
									<?php
										if($act == 'edit') {
										$l = OLsmList::get_lgallery(0, 5, 'id_lgallery DESC', 'id_lsm = '.$id_lsm);
										if(count($l) > 0) {
									?>
									<tr>
										<td valign="top">Recent Galleries</td>
										<td>
											<?php foreach($l as $r) { ?>
												<div class="i-thumb">
													<img src="<?=base_url('assets/images/lsfund/200/'.$r->image_name)?>" class="img-polaroid" style="height:64px;" />
													<a href="<?=base_url("organizer/delete_photo/{$r->id_lgallery}")?>" class="cl-fav btn btn-mini btn-danger" title="remove" onclick="return confirm('Delete this photo ?');"><i class="icon-remove"></i></a>
												</div>
											<? } ?>
										</td>
									</tr>
									<? } } ?>
									<tr>
										<td valign="top">Galleries</td>
										<td>
											<div style="display:block;" id="last-photo"><?=$images?></div>
											<div style="display:block;" id="preview-photo"><?=$img_preview?></div><br>
											<div id="swfupload-control-photo" class="clear">
												<input type="button" id="button-photo" />
												<p id="queuestatus-photo" ></p>
												<ol id="log-photo"></ol>
											</div>
										</td>
									</tr>
									<?php
										if($act == 'edit') {
										$l = OLsmList::get_lvideo(0, 5, 'id_lvideo DESC', 'id_lsm = '.$id_lsm);
										if(count($l) > 0) {
									?>
									<tr>
										<td valign="top">Recent Videos</td>
										<td>
											<?php foreach($l as $r) { ?>
												<div class="input-append">
													<input type="text" class="span10" value="<?=$r->video_link?>" readonly />
													<button type="button" class="btn btn-default"><i class="icon-film"></i></button>
													<a href="<?=base_url("organizer/delete_video/{$r->id_lvideo}")?>" class="btn btn-danger" title="remove" onclick="return confirm('Delete this photo ?');"><i class="icon-remove"></i></a>
												</div>
											<br>
											<? } ?>
										</td>
									</tr>
									<? } } ?>
									<tr>
										<td valign="top">Videos</td>
										<td>
											<table class="tabel">
												<tbody>
													<tr class="contoh">
														<td>
															<div class="input-append">
																<input type="url" class="span10" name="video[]" placeholder="Paste YouTube embed link here..." />
																<button type="button" class="btn btn-default"><i class="icon-film"></i></button>
																<button type="button" class="add btn btn-info" title="Add"><i class="icon-plus"></i></button>
															</div>
														</td>
													</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<button type="submit" class="btn btn-success">Edit</button>
										</td>
									</tr>
								</table>
								<span class="set"><?=implode("", $input_file)?></span>
							<?=form_close()?>
						</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>