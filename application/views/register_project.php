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
					<div class="span3 left-side">
						<div class="thumbnail detail-boxes-left">
							<h4 class="subtitle"><?=langtext('how_to_reg')?></h4>
							<ol>
								<li><?=langtext('complete_regform')?></li>
								<li><?=langtext('scan_maildocuments')?></li>
								<li><?=langtext('review_applications')?></li>
							</ol>
						</div>
					</div>
					<!-- Right side of detail page -->
					<div class="span9 thumbnail detail-boxes">
						<h4 class="subtitle"><?=langtext('register_socials')?></h4>
						<div class="row-fluid">
							<?=form_open_multipart('lsm/save_project')?>
								<div class="row-fluid">
									<div class="span12">
										<fieldset>
											<legend><?=langtext('about_socials')?></legend>
											<table cellpadding="4">
												<tr>
													<td><?=langtext('name')?> <span class="red">*</span></td>
													<td>
														<div class="span5"><input id="lname" name="lname" type="text" required /></div>
														<div class="span7" id='lname_result' style="height:40px;"></div>
													</td>
												</tr>
												<tr>
													<td>Url <span class="red">*</span></td>
													<td><label class="checkbox" style="padding-left:0;">http://bagikasih.com/ <input id="urlname" name="urlname" type="text" required /></label></td>
												</tr>
												<tr>
													<td><?=langtext('category')?> <span class="red">*</span></td>
													<td><?=OLsmCategory::drop_down_select("category")?></td>
												</tr>
												<tr>
													<td><?=langtext('location')?> <span class="red">*</span></td>
													<td><?=OLocation::drop_down_select("kota", '', 'onchange="show_drop_area();"')?></td>
												</tr>
												<tr>
													<td id="get_area" colspan="2"></td>
												</tr>
												<tr>
													<td><?=langtext('address')?> <span class="red">*</span></td>
													<td><input name="address" type="text" required /></td>
												</tr>
												<tr>
													<td valign="top"><?=langtext('description')?> <span class="red">*</span></td>
													<td><textarea name="deskripsi" class="input-xxlarge" rows="3" required ></textarea></td>
												</tr>
												<tr>
													<td><?=langtext('expense')?></td>
													<td>
														<div class="input-prepend">
															<span class="add-on">RP</span>
															<input type="text" name="target" class="currfix" />
														</div>
													</td>
												</tr>
												<tr>
													<td><?=langtext('volunteer_form')?></td>
													<td>
														<label class="checkbox">
															<input type="checkbox" name="volunteer" value="1" />
															<?=langtext('if_check_vform')?>
														</label>
													</td>
												</tr>
												<tr>
													<td valign="top"><?=langtext('profile_picture')?></td>
													<td>
														<input name="userfile" type="file" id="userfile" />
														<p><?=langtext('allow_imgtype')?></p>
													</td>
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
								<hr style="border-top: 1px solid #e5e5e5;">
								<div class="row-fluid">
									<div class="span12">
										<fieldset>
											<legend><?=langtext('org_details')?></legend>
											<table cellpadding="4">
												<tr>
													<td>Email <span class="red">*</span></td>
													<td><input name="mail" type="email" required /></td>
												</tr>
												<tr>
													<td><?=langtext('password')?> <span class="red">*</span></td>
													<td><input name="pass" type="password" required /></td>
												</tr>
												<tr>
													<td><?=langtext('name')?> <span class="red">*</span></td>
													<td><input name="name" type="text" required/></td>
												</tr>
												<tr>
													<td><?=langtext('address')?></td>
													<td><input name="alamat" type="text" /></td>
												</tr>
												<tr>
													<td><?=langtext('phone')?> <span class="red">*</span></td>
													<td><input name="phone" type="text" required /></td>
												</tr>
											</table>
										</fieldset>
									</div>
								</div>
								<hr style="border-top: 1px solid #e5e5e5;">
								<div class="row-fluid">
									<div class="span12">
										<fieldset>
											<legend><?=langtext('acc_bank')?></legend>
											<table cellpadding="4">
												<tr>
													<td>Bank <span class="red">*</span></td>
													<td><?=OBank::drop_down_select("bank")?></td>
												</tr>
												<tr>
													<td><?=langtext('acc_number')?> <span class="red">*</span></td>
													<td><input name="anumber" type="text" required /></td>
												</tr>
												<tr>
													<td><?=langtext('acc_holder')?> <span class="red">*</span></td>
													<td><input name="aholder" type="text" required/></td>
												</tr>
											</table>
										</fieldset>
									</div>
								</div>
								<label class="checkbox">
									<input type="checkbox" required />
									<?=langtext('soc_term_check')?>
								</label>
								<button type="submit" class="btn btn-success"><?=langtext('submit_app')?></button>
							<?=form_close()?>
						</div>
					</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>