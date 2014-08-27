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
						<li class="active">LSM Category</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">LSM Category Management</div>
					</div>
					<div class="block-content collapse in">
						<?php if($showform) { ?>
							<?=form_open('',array('class' => 'form-horizontal'))?>
								<fieldset>
									<legend>
									<?php if($row) { ?>
										EDIT Categories ( ID : <?=$row->id_category?> )
									<? } else { ?>
										ADD New Categories
									<? } ?>
									</legend>
									<table>    	
										<tr>
											<th>Name</th>
											<td> : <input type="text" name="category" value="<?=$category?>" autofocus required /><br/><?=form_error('name')?></td>
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
							<p class='text_red'>LSM Category List is empty.</p>
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
										<td><?=$i?></td>            
										<td><?=$row->category?></td>
										<td>
											<?=anchor($this->curpage.'/listing/'.$row->id_lsm_category, 'edit')?> |
											<?=anchor($this->curpage.'/delete/'.$row->id_lsm_category, 'delete', array("onclick" => "return confirm('Are you sure?');"))?>
										</td>
									</tr>
								<?php
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