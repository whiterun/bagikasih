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
						<li>
							<a href="#">LSM Photo</a> <span class="divider">/</span>	
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
							<table class="tbl_form">
								<tr>
									<th>LSM Name</th><td>:</td>
									<td><input type="text" name="name" value="<?=$name?>" autofocus required /> <br/><?=form_error('name')?></td>
								</tr>
								<tr>
									<th>Category</th><td>:</td>
									<td><?=OLsmCategory::drop_down_select("id_lsm_category", $id_lsm_category)?></td>
								</tr>
								<tr>
									<th>Location</th><td>:</td>
									<td><?=OLocation::drop_down_select("id_kota", $id_kota)?></td>
								</tr>
								<tr>
									<th valign="top">Description</th><td valign="top">:</td>
									<td><textarea name="deskripsi" rows="10"><?=$deskripsi?></textarea> <br/><?=form_error('deskripsi')?></td>
								</tr>
								<tr>
									<th>Image</th><td>:</td>
									<td>
										<input name="userfile" type="file" id="userfile" />
										<p>Image types allowed (jpg, png, gif), having maximum size of 1 MB &amp; minimum resolution 150px x 150px</p>
									</td>
								</tr>
								<?php if($image) { ?>
								<tr>
									<th></th><td></td>
									<td><img src="<?=base_url('assets/images/'.$image)?>" width="100" class="img-polaroid" /></td>
								</tr>
								<? } ?>
								<tr>
									<td colspan="3" align="center">
										<button class="btn btn-success" type="submit"><span class="check icon"></span>Save</button>
										<button class="btn btn-default" type="reset"><span class="reload icon"></span>Reset</button>
										<button class="btn btn-default" type="button" onclick="location.href='<?=site_url($this->curpage)?>';"><span class="leftarrow icon"></span>Cancel</button>
									</td>
								</tr> 
							</table>
						<?=form_close()?>
					</div>
				</div>
				<!-- /block -->
			</div>
		</div>
	</div>
</div>

<script src="<?=base_url("assets/js/tiny_mce_advanced.js")?>"></script>