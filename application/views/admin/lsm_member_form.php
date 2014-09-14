<?php
	if($row)
	{
		extract(get_object_vars($row));	
		$P = new OProduct();
		$P->setup($row);
	}
	extract($_POST);
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
						<li class="active">LSM Member Form</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Member Form</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						
						<?=form_open_multipart()?>
							<table class="tbl_form">
								<tr>
									<th>LSM</th><td>:</td>
									<td><?=OLsmList::drop_down_select("id_lsm", $id_lsm)?></td>
								</tr>
								<tr>
									<th>Name</th><td>:</td>
									<td><input type="text" name="name" value="<?=$name?>" required /> <br/><?=form_error('name')?></td>
								</tr>
								<tr>
									<th>Age</th><td>:</td>
									<td><input type="text" name="age" value="<?=$age?>" required /> <br/><?=form_error('name')?></td>
								</tr>
								<tr>
									<th valign="top">About</th><td valign="top">:</td>
									<td><textarea name="about" class="input-xxlarge" rows="6"><?=$about?></textarea> <br/><?=form_error('about')?></td>
								</tr>
								<tr>
									<th>Photos</th><td>:</td>
									<td>
										<input name="userfile" type="file" id="userfile" />
										<p>Image types allowed (jpg, png, gif), having maximum size of 1 MB &amp; minimum resolution 150px x 150px</p>
									</td>
								</tr>
								<?php if($foto) { ?>
								<tr>
									<th></th><td></td>
									<td><img src="<?=base_url('assets/images/'.$foto)?>" width="100" class="img-polaroid" /></td>
								</tr>
								<? } ?>
								<tr>
									<th>Join Date</th><td> : </td>
									<td><input type="text" name="tgl_masuk" class="datepicker" value="<?=$tgl_masuk?>" required  /></td>
								</tr>
								<tr>
									<th>Out Date</th><td> : </td>
									<td><input type="text" name="tgl_keluar" class="datepicker1" value="<?=$tgl_keluar?>" required /></td>
								</tr>

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

<script>
	$(function() {
		$( ".datepicker, .datepicker1" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true
		});			
	});
</script>

<script src="<?=base_url("assets/js/tiny_mce_advanced.js")?>"></script>