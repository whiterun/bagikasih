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
						<li class="active">LSM List</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">LSM List</div>
					</div>
					<div class="block-content collapse in">
						<p><?=anchor($this->curpage."/add", "<i class='icon-plus'></i> Create new",array("class" => "btn"))?></p>
						<p>
							<strong>Filter by City : </strong><?=anchor("admin/lsm_list/","All")?>
							<?php
							$loclist = OLocation::get_list(0,0);
							foreach($loclist as $loc)
							{
								echo " | ".anchor("admin/lsm_list/?location_id={$loc->id_kota}",$loc->name);
							}
							?>
						</p>
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?php if(sizeof($list) <= 0) { ?>
							<p class='text_red'>There is no data found.</p>
						<? } else { ?>
							<form>
								<div class="input-append">
									<input class="span9" id="appendedInputButtons" type="text" name="keyword" value="<?=$_GET["keyword"]?>" placeholder="Type Keywords..." />
									<button class="btn" type="submit">Search</button>
									<?=anchor('admin/lsm_list','Refresh', array('class' => 'btn'))?>
								</div>
							</form>
							<table class="table table-bordered table-striped tbl_list">
								<thead>
									<tr>
										<th>ID</th>
										<th>LSM Name</th>
										<th>Category</th>
										<th>Status</th>
										<th>Featured</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>                
								<?php 
									$i=1 + $uri;
									
									foreach($list as $row):
										$os = new OLsmList();
										$os->setup($row);
												
									extract(get_object_vars($row));
									$st = ($approved == 1) ? 'Approved' : 'Not Approved' ;
									$ft = ($featured == 1) ? 'Yes' : 'No' ;
								?>
									<tr>
										<td><?=$id_lsm?></td>            
										<td><?=$name?></td>
										<td><?=get_lsm_category($id_lsm_category)->category?></td>
										<td><?=$st?></td>
										<td><?=$ft?></td>
										<td>
											<?php
												echo anchor($this->curpage."/delete/".$id_lsm, "Delete", array("onclick" => "return confirm('Are you sure?');"));
												echo " | ".anchor($this->curpage."/edit/".$id_lsm, "Edit");
												if($approved == 0) {
													echo " | ".anchor($this->curpage."/approve/".$id_lsm, "Approve", array("onclick" => "return confirm('Are you sure?');"));
												} else {
													echo " | ".anchor($this->curpage."/disable/".$id_lsm, "Disable", array("onclick" => "return confirm('Are you sure?');"));
												}
												if($featured == 0) {
													echo " | ".anchor($this->curpage."/featured/".$id_lsm."/1", "Set Featured", array("onclick" => "return confirm('Are you sure?');"));
												} else {
													echo " | ".anchor($this->curpage."/featured/".$id_lsm."/0", "Set Not Featured", array("onclick" => "return confirm('Are you sure?');"));
												}
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