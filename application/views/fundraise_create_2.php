	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
	?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata("warning"))?>
			<?=print_success($this->session->flashdata("success"))?>
				<div class="row-fluid">
					<!-- Right side of detail page -->
					<div class="span10 thumbnail detail-boxes" style="margin:auto 80px;">
						<h4 class="subtitle"><?=langtext('step-2')?></h4>
						<?=form_open_multipart('fundraise/save_fundraise')?>
							<input type="hidden" name="id_lsm" value="<?=$ils?>"/>
							<div class="row-fluid">
								<div class="span12">
									<fieldset>
										<table width="100%" cellpadding="4">
											<tr>
												<td><?=langtext('social_institute')?> <span class="red">*</span></td>
												<td class="span10">
													<div class="input-append">
														<input type="text" class="span10" value="<?=get_lsm($ils)->name?>" required disabled />
														<a href="#" onclick="location.href='<?=base_url('fundraise/create')?>';" class="btn btn-default" title="Change"><i class="icon-edit"></i></a>
													</div>
												</td>
											</tr>
											<tr>
												<td><?=langtext('name')?> <span class="red">*</span></td>
												<td><input name="name" type="text" required /></td>
											</tr>
											<tr>
												<td><?=langtext('fund_target')?> <span class="red">*</span></td>
												<td>
													<div class="input-prepend">
														<span class="add-on">RP</span>
														<input type="text" name="target" class="currfix" required />
													</div>
												</td>
											</tr>
											<tr>
												<td><?=langtext('page_color')?> <span class="red">*</span></td>
												<td>
													<select name="pcolor" class="span2">
														<option value="light">Light</option>
														<option value="dark">Dark</option>
													</select>
												</td>
											</tr>
											<tr>
												<td valign="middle"><?=langtext('background')?> <span class="red">*</span></td>
												<td valign="top">
													<label class="radio inline"><input type="radio" name="bgc" value="no" required /> <?=langtext('accor_theme')?></label>
													<label class="radio inline"><input type="radio" name="bgc" value="yes" required /> <?=langtext('image')?></label>
												</td>
											</tr>
											<tr>
												<td></td>
												<td>
													<div id="div_name" style="display:none;">
														<div class="input-append">
															<input class="span9" id="fname" type="text" readonly />
															<div class="fileUpload btn btn-default">
															<span>Upload</span>
															<input type="file" name="fpfile" class="upload" onchange="$('#fname').val($(this).val());" />
															</div>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td valign="top"><?=langtext('description')?> <span class="red">*</span></td>
												<td><textarea name="description" class="span12" rows="3" placeholder="<?=langtext('plh_desc_fund')?>" required></textarea></td>
											</tr>
											<tr>
												<td><?=langtext('end_date')?> <span class="red">*</span></td>
												<td><input type="text" id="dp3" name="end_date" readonly required /></td>
											</tr>
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
											<tr>
												<td valign="top"><?=langtext('videos')?></td>
												<td>
													<table class="tabel">
														<tbody>
															<tr class="contoh">
																<td>
																	<div class="input-append">
																		<input type="url" class="span10" name="video[]" placeholder="<?=langtext('ytube_embed_link')?>" />
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
							<label class="checkbox">
								<input type="checkbox" required />
								<?=langtext('fpage_term_check')?>
							</label>
							<button type="submit" class="btn btn-success"><?=langtext('submit_app')?></button>
							&nbsp;
							<button type="button" class="btn btn-default">Cancel</button>
						<?=form_close()?>
					</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>