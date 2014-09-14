	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
		$bmg = get_bgimg($fra->id_fundraise)->img_name;
	?>
	<body>
		<?=$this->load->view('head')?>
		
		<!-- Content section -->
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata("warning"))?>
			<?=print_success($this->session->flashdata("success"))?>
				<div class="row-fluid">
					<?=$this->load->view('user_sidebar')?>
					<!-- Right side of detail page -->
					<div class="span10 thumbnail detail-boxes">
						<h4 class="subtitle">Edit Fundpage <?=$fra->name?></h4>
							<?=form_open_multipart()?>
							<input type="hidden" name="id_lsm" value="<?=$ils?>"/>
							<div class="row-fluid">
								<div class="span12">
									<fieldset>
										<table width="100%" cellpadding="4">
											<tr>
												<td><?=langtext('name')?> <span class="red">*</span></td>
												<td><input name="name" type="text" value="<?=$fra->name?>" required /></td>
											</tr>
											<tr>
												<td><?=langtext('fund_target')?> <span class="red">*</span></td>
												<td>
													<div class="input-prepend">
														<span class="add-on">RP</span>
														<input type="text" name="target" value="<?=$fra->fund_target?>" required />
													</div>
												</td>
											</tr>
											<tr>
												<td><?=langtext('page_color')?> <span class="red">*</span></td>
												<td>
													<select name="pcolor" class="span2">
														<option value="light" <?php if($fra->theme == 'light') { echo "selected"; } ?>>Light</option>
														<option value="dark" <?php if($fra->theme == 'dark') { echo "selected"; } ?>>Dark</option>
													</select>
												</td>
											</tr>
											<tr>
												<td valign="middle"><?=langtext('background')?> <span class="red">*</span></td>
												<td valign="top">
													<label class="radio inline"><input type="radio" name="bgc" value="no" <?=($fra->background == 'no' ? 'checked' : '' )?> required /> <?=langtext('accor_theme')?></label>
													<label class="radio inline"><input type="radio" name="bgc" value="yes" <?=($fra->background == 'yes' ? 'checked' : '' )?> required /> <?=langtext('image')?></label>
												</td>
											</tr>
											<tr>
												<td></td>
												<td>
													<div id="div_name" style="display:<?=($fra->background == 'no' ? 'none' : 'block')?>;">
														<div class="input-append">
															<input class="span9" id="fname" type="text" readonly />
															<div class="fileUpload btn btn-default">
															<span>Upload</span>
															<input type="file" name="fpfile" class="upload" onchange="$('#fname').val($(this).val());" />
															</div>
														</div>
														<?php if($bmg != '') { ?>
														<br>
														<img src="<?=base_url('assets/images/'.$bmg)?>" id="tooltip" width="200" class="img-polaroid" data-placement="right" title="Current Background" />
														<? } ?>
													</div>
												</td>
											</tr>
											<tr>
												<td valign="top"><?=langtext('description')?> <span class="red">*</span></td>
												<td><textarea class="span12" rows="3" name="description" placeholder="<?=langtext('plh_desc_fund')?>"><?=$fra->description?></textarea></td>
											</tr>
											<tr>
												<td><?=langtext('end_date')?> <span class="red">*</span></td>
												<td><input type="text" id="dp3" name="end_date" value="<?=$fra->end_date?>" readonly required /></td>
											</tr>
											<?php
												$l = OLsmList::get_fgallery(0, 5, 'id_fgallery DESC', 'id_fundraise = '.$fra->id_fundraise);
												if(count($l) > 0) {
											?>
											<tr>
												<td valign="top"><?=langtext('recent_gallery')?></td>
												<td>
													<?php foreach($l as $r) { ?>
														<div class="i-thumb">
															<img src="<?=base_url('assets/images/lsfund/200/'.$r->image_name)?>" class="img-polaroid" style="height:64px;" />
															<a href="<?=base_url("user/delete_photo/{$fra->id_fundraise}/{$r->id_fgallery}")?>" class="cl-fav btn btn-mini btn-danger" title="remove" onclick="return confirm('Delete this photo ?');"><i class="icon-remove"></i></a>
														</div>
													<? } ?>
												</td>
											</tr>
											<? } ?>
											<tr>
												<td valign="top"><?=langtext('gallery')?></td>
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
												$l = OLsmList::get_fvideo(0, 5, 'id_flvideo DESC', 'id_fundraise = '.$fra->id_fundraise);
												if(count($l) > 0) {
											?>
											<tr>
												<td valign="top"><?=langtext('recent_videos')?></td>
												<td>
													<?php foreach($l as $r) { ?>
														<div class="input-append">
															<input type="text" class="span10" value="<?=$r->video_link?>" readonly />
															<button type="button" class="btn btn-default"><i class="icon-film"></i></button>
															<a href="<?=base_url("user/delete_video/{$fra->id_fundraise}/{$r->id_flvideo}")?>" class="btn btn-danger" title="remove" onclick="return confirm('Delete this photo ?');"><i class="icon-remove"></i></a>
														</div>
													<br>
													<? } ?>
												</td>
											</tr>
											<? } ?>
											<tr>
												<td valign="top"><?=langtext('videos')?></td>
												<td>
													<table class="tabel">
														<tbody>
															<tr class="contoh">
																<td>
																	<div class="input-append">
																		<input type="text" class="span10" name="video[]" placeholder="<?=langtext('ytube_embed_link')?>" />
																		<button type="button" class="btn btn-default"><i class="icon-film"></i></button>
																		<button type="button" class="add btn btn-info" title="Add"><i class="icon-plus"></i></button>
																	</div>
																</td>
															</tr>
													</table>
												</td>
											</tr>
										</table>
										<span class="set"><?=implode("", $input_file)?></span>
									</fieldset>
								</div>
							</div>
							<button type="submit" class="btn btn-success">Edit</button>
							&nbsp;
							<button type="button" class="btn btn-default" onclick="history.back();">Cancel</button>
						<?=form_close()?>
					</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>