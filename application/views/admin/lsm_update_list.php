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
						<li class="active">LSM Update List</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">LSM Update List</div>
					</div>
					<div class="block-content collapse in">
						<p><?=anchor($this->curpage."/add", "<i class='icon-plus'></i> Create new",array("class" => "btn"))?></p>
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?php if(sizeof($list) <= 0) { ?>
							<p class='text_red'>There is no data found.</p>
						<? } else { ?>
							<form>
								<div class="input-append">
									<input class="span9" id="appendedInputButtons" type="text" name="keyword" value="<?=$_GET["keyword"]?>" placeholder="Type Keywords..." />
									<button class="btn" type="submit">Search</button>
									<?=anchor('admin/lsm_update_list','Refresh', array('class' => 'btn'))?>
								</div>
							</form>
							<table class="table table-bordered table-striped tbl_list">
								<thead>
									<tr>
										<th>ID</th>
										<th>Date Added</th>                   
										<th>Title</th>                    
										<th>Organizer</th>                   
										<th>Action</th>
									</tr>
								</thead>
								<tbody>                
								<?php 
									$i=1 + $uri;
									
									foreach($list as $row):
										$os = new OLsmUpdate();
										$os->setup($row);
												
									extract(get_object_vars($row));
								?>		        
									<tr>
										<td><?=$id_update?></td>
										<td><?=parse_date_time($dt)?></td>
										<td><?=$title?></td>
										<td><?=get_organizer($id_organizer)->name?></td>
										<td>
											<?php
												echo anchor($this->curpage."/delete/".$id_update, "Delete", array("onclick" => "return confirm('Are you sure?');"));
												echo " | ".anchor($this->curpage."/edit/".$id_update, "Edit");
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