<?php
	if($row)
	{
		extract(get_object_vars($row));		
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
						<li class="active">Banners</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Banner Form</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						
						<?=form_open_multipart()?>
							<table cellpadding="3">
								<tr>
									<td>Title <span class="red">*</span></td>
									<td> : </td>
									<td><input type="text" name="title" value="<?=$title?>" required /> <br/><?=form_error('title')?></td>
								</tr>
								<tr>
									<td valign="top">Description <span class="red">*</span></td>
									<td valign="top"> : </td>
									<td><textarea name="description" rows="5" class="input-xxlarge" required><?=$description?></textarea> <br/><?=form_error('description')?></td>
								</tr>
								<tr>
									<td valign="top">Banner Image <?php if($act == 'add') { echo '<span class="red">*</span>'; } ?></td>
									<td valign="top"> : </td>
									<td valign="top">
										<input name="userfile" type="file" id="userfile" <?php if($act == 'add') { echo "required"; } ?> />
										<p>Image types allowed (jpg, png, gif), having maximum size of 1 MB &amp; minimum resolution 580px x 295px</p>
										<?php if($image) { ?>
										<p><img src="<?=base_url('assets/images/'.$image)?>" width="150" class="img-polaroid" /></p>
										<? } ?>
									</td>
								</tr>
								<tr>            
									<td colspan="3">
										<button class="btn btn-success" type="submit">Save</button>
										<button class="btn btn-default" type="reset">Reset</button>
										<button class="btn btn-default" type="button" onclick="location.href='<?=site_url($this->curpage)?>';">Cancel</button>
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