<?php
	if($row)
	{
		extract(get_object_vars($row));	
		$P = new OLsmList();
		$P->setup($row);
	}
	extract($_POST);
	$sp = ($act == 'edit') ? 'span12' : 'span6' ;
?>
<div class="row-fluid">
	<!--/span-->
	<div class="span12" id="content">
		<div class="row-fluid">
			<div class="navbar">
				<div class="navbar-inner">
					<ul class="breadcrumb">
						<li>
							<a href="#">Home</a> <span class="divider">/</span>	
						</li>
						<li>
							<a href="#">LSM</a> <span class="divider">/</span>	
						</li>
						<li class="active">LSM Form</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">LSM Form</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						
						<?=form_open_multipart()?>
							<div class="row-fluid">
								<div class="span12">
									<fieldset>
										<legend>About LSM</legend>
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
														<input type="text" name="target" value="<?=$fund_target?>" />
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
															<a href="<?=base_url($this->curpage."/delete_photo/{$id_lsm}/{$r->id_lgallery}")?>" class="cl-fav btn btn-mini btn-danger" title="remove" onclick="return confirm('Delete this photo ?');"><i class="icon-remove"></i></a>
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
															<a href="<?=base_url($this->curpage."/delete_video/{$id_lsm}/{$r->id_lvideo}")?>" class="btn btn-danger" title="remove" onclick="return confirm('Delete this photo ?');"><i class="icon-remove"></i></a>
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
										</table>
										<span class="set"><?=implode("", $input_file)?></span>
									</fieldset>
								</div>
							</div>
							<hr style="border-top: 1px solid #e5e5e5;">
							<div class="row-fluid">
								<?php if($act == 'add') { ?>
								<div class="span6">
									<fieldset>
										<legend>Organizer Details</legend>
										<table cellpadding="4">
											<tr>
												<td>Email</td>
												<td><input name="mail" type="text" /></td>
											</tr>
											<tr>
												<td>Password</td>
												<td><input name="pass" type="password" /></td>
											</tr>
											<tr>
												<td>Name</td>
												<td><input name="name" type="text" /></td>
											</tr>
											<tr>
												<td>Address</td>
												<td><input name="alamat" type="text" /></td>
											</tr>
											<tr>
												<td>Phone</td>
												<td><input name="phone" type="text" /></td>
											</tr>
										</table>
									</fieldset>
								</div>
								<? } ?>
								<div class="<?=$sp?>">
									<fieldset>
										<legend>Bank Account Details</legend>
										<table cellpadding="4">
											<tr>
												<td>Bank</td>
												<td>
													<select name="bank" id="bank">
														<option value="0">- Choose Bank -</option>
													<?php
														// OBank::drop_down_select("bank", $id_bank)
														$bo = OBank::get_list(0, 0, "id_bank DESC");
														foreach($bo as $kn) {
														$sl = ($kn->id_bank == $id_bank) ? 'selected' : '' ;
													?>
														<option value="<?=$kn->id_bank?>" <?=$sl?>><?=$kn->name?></option>
													<? } ?>
													</select>
												</td>
											</tr>
											<tr>
												<td>Account Number</td>
												<td><input name="anumber" type="text" value="<?=$acc_number?>" /></td>
											</tr>
											<tr>
												<td>Account Holder</td>
												<td><input name="aholder" type="text" value="<?=$acc_holder?>" /></td>
											</tr>
										</table>
									</fieldset>
								</div>
							</div>
							<button class="btn btn-success" type="submit"><span class="check icon"></span>Save</button>
							<button class="btn btn-default" type="reset"><span class="reload icon"></span>Reset</button>
							<button class="btn btn-default" type="button" onclick="location.href='<?=site_url($this->curpage)?>';"><span class="leftarrow icon"></span>Cancel</button>
						<?=form_close()?>
					</div>
				</div>
				<!-- /block -->
			</div>
		</div>
	</div>
</div>