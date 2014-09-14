<?php
	$showform = true;
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
						<li class="active">Banks</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Banks Management</div>
					</div>
					<div class="block-content collapse in">

						<?php if($showform) { ?>
							<?=form_open('', array('class' => 'form-horizontal'))?>
								<fieldset>
									<legend>
									<?php if($row) { ?>
										EDIT Banks ( ID : <?=$row->id?> )
									<? } else { ?>
										ADD Banks
									<? } ?>
									</legend>
									<table class="tbl_form">    	
										<tr>
											<th>Name</th>
											<td> : <input type="text" name="name" value="<?=$name?>" placeholder="Bank Name" autofocus required/> <br/><?=form_error('name')?></td>
										</tr>
										<tr>         
											<td colspan="2" align="center">
												<br>
												<button class="btn btn-success" type="submit">Save</button>
												<button class="btn btn-default" type="reset">Reset</button>
												
												<?php if($row) { ?>
												<button class="btn btn-default" type="button" onclick="location.href='<?=site_url("admin/locations")?>';"><span class="leftarrow icon"></span>Cancel</button>
												<? } ?>
											</td>
										</tr>    
									</table>
								</fieldset>
							<?=form_close()?>
						<? } ?>
						<hr>
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?php if(sizeof($list) <= 0) { ?>
							<p class='text_red'>Bank List is empty.</p>
						<? } else { ?>
							<form>
								<div class="input-append">
									<input class="span9" id="appendedInputButtons" type="text" name="keyword" value="<?=$_GET["keyword"]?>" placeholder="Type Keywords..." />
									<button class="btn" type="submit">Search</button>
									<?=anchor('admin/bank','Refresh', array('class' => 'btn'))?>
								</div>
							</form>
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
										<td><?=$row->name?></td>
										<td>
											<?=anchor($this->curpage.'/delete/'.$row->id_bank, 'delete', array("onclick" => "return confirm('Are you sure?');"))?> |
											<?=anchor($this->curpage.'/listing/'.$row->id_bank, 'edit')?>
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