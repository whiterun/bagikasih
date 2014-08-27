<?php
	$showform = true;
	if($row)
	{	
		extract(get_object_vars($row));	
		$showform = true;
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
						<li class="active">LSM Photo</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">LSM Photo Management</div>
					</div>
					<div class="block-content collapse in">
						<p><?=anchor($this->curpage."/add", "<i class='icon-plus'></i> Create new",array("class" => "btn"))?></p>
						<?php if($showform) { ?>
							<?=form_open_multipart('add',array('class' => 'form-horizontal'))?>
								<fieldset>
									<legend>
										<?php if($row) { ?>
											Edit Photo ( ID : <?=$row->id_photo?> )
										<? } else { ?>
											Add New Photos
										<? } ?>
									</legend>
									<table>
										<tr>
											<th>Photo</th>
											<td> : <input type="file" name="userfile" required /></td>
										</tr>
										<tr>        
											<td colspan="2" align="center">
												<br>
												<button class="btn btn-success" type="submit">Save</button>
												<button class="btn btn-default" type="reset">Reset</button>
												<?php if($row) { ?>
												<button class="btn btn-default" type="button" onclick="location.href='<?=site_url("admin/categories")?>';">Cancel</button>
												<? } ?>
											</td>
										</tr>    
									</table>
								</fieldset>								
							<?=form_close()?>
						<? } ?>
					
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?php if(sizeof($list) <= 0) { ?>
							<p class='text_red'>LSM Photo List is empty.</p>
						<? } else { ?>
							<table class="table table-bordered table-striped tbl_list">
								<thead>
									<tr>
										<th>No.</th>
										<th>Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$i=1 + $uri;
									foreach($list as $row):
								?>
									<tr>
										<td style="width:30px;"><?=$i?></td>            
										<td><?=$row->name?></td>
										<td>
											<?=anchor($this->curpage.'/listing/'.$row->id_lsm_category, 'edit')?> |
											<?=anchor($this->curpage.'/delete/'.$row->id_lsm_category, 'delete', array("onclick" => "return confirm('Are you sure?');"))?>
										</td>
									</tr>
									
									<?php
									$photo = OLsmPhoto::get_list($start, $perpage, $row->id_lsm, "caption ASC", '0');
									if(count($photo) > 0) 
									{
									?>
										<tr>
											<td> </td>
											<td colspan="2">
												<?php
												foreach($photo as $pho) { 
												?>
												
													<div>
														<?=$pho->photo?>
													</div>

												<?php 
												} 
												?>
											</td>
										</tr>
								<?php
									}
									$i++;
									endforeach;
								?>
								</tbody>
							</table>
							<div class="pagination">
								<?=$pagination?>
							</div>
						<? } ?>
					</div>
				</div>
				<!-- /block -->
			</div>
		</div>
	</div>
</div>