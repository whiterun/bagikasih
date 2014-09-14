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
						<li>
							<a href="#">Users</a> <span class="divider">/</span>	
						</li>
						<li class="active">Newsletters</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Create Newsletter Form</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						
						<?=form_open()?>
							<table class="tbl_form">
								<tr>
									<th>Newsletter Type</th>
									<td> : <?=gen_ddl_set("type", array("public" => "Public", "member" => "Member"), $type, "", FALSE); ?></td>
								</tr>
								<tr>
									<th>Subject</th>
									<td> : <input type="text" name="title" value="<?=$title?>" class="full" autofocus required /> <br/><?=form_error('title')?></td>
								</tr>
								<tr>
									<th valign="top">Content</th>
									<td><textarea name="body" rows="15"><?=$body?></textarea> <br/><?=form_error('body')?> </td>
								</tr>
								<tr>
									<td colspan="2" align="center">
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
<script src="<?=base_url("assets/js/tiny_mce_advanced.js")?>"></script>