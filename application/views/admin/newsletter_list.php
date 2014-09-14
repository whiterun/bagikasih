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
							<a href="#">Other</a> <span class="divider">/</span>	
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
						<div class="muted pull-left">Newsletter Email List</div>
					</div>
					<div class="block-content collapse in">
						<p>
							<?=anchor($this->curpage."/add", "Create New Email")?> |
							<?=anchor($this->curpage."/newsletter_queues", "Newsletter Queues")?> |
							<?=anchor($this->curpage."/create_newsletter", "Create Newsletter")?>
						</p>
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?=print_success($this->session->flashdata('newsletter_success'))?>
						<?php if(sizeof($list) <= 0) { ?>
							<p class='text_red'>There is no data found.</p>
						<? } else { ?>
							<form>
								<div class="input-append">
									<input class="span9" id="appendedInputButtons" type="text" name="keyword" value="<?=$_GET["keyword"]?>" placeholder="Type Keywords..." />
									<button class="btn" type="submit">Search</button>
									<?=anchor('admin/newsletters','Refresh', array('class' => 'btn'))?>
								</div>
							</form>
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No.</th>        	
										<th>Email</th>
										<th>Type</th>
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
										<td><?=$row->email?></td>
										<td><?=ucfirst($row->type)?></td>
										<td>						
											<?						
											echo anchor($this->curpage."/delete/".$row->id, "Delete", array("onclick" => "return confirm('Are you sure?');"));
											echo " | ".anchor($this->curpage."/edit/".$row->id, "Edit");						
											?> 
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