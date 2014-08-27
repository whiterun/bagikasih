<?php
	if($row)
	{
		extract(get_object_vars($row));	
		$P = new OLsmUpdate();
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
						<li class="active">LSM Update Form</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">LSM Update Form</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						
						<?=form_open_multipart()?>
							<table class="tbl_form">
								<tr>
									<th>Organizer</th><td>:</td>
									<td><?=OLsmOrganizer::drop_down_select("id_organizer", $id_organizer)?></td>
								</tr>
								<tr>
									<th>Title</th><td>:</td>
									<td><input type="text" name="title" value="<?=$title?>" required /> <br/><?=form_error('title')?></td>
								</tr>
								<tr>
									<th valign="top">Content</th><td valign="top">:</td>
									<td><textarea name="content" class="input-xxlarge" rows="7"><?=$content?></textarea> <br/><?=form_error('content')?></td>
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

<script src="<?=base_url("assets/js/tiny_mce_advanced.js")?>"></script>