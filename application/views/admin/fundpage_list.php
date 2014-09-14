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
						<li class="active">Fundpage</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Fundpage List</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?php if(sizeof($list) <= 0) { ?>
							<p class='text_red'>There is no data found.</p>
						<? } else { ?>
							<form>
								<div class="input-append">
									<input class="span9" id="appendedInputButtons" type="text" name="keyword" value="<?=$_GET["keyword"]?>" placeholder="Type Keywords..." />
									<button class="btn" type="submit">Search</button>
									<?=anchor('admin/fundpage','Refresh', array('class' => 'btn'))?>
								</div>
							</form>
							<table class="table table-bordered table-striped tbl_list">
								<thead>
									<tr>
										<th>ID</th>
										<th>Fundpage Title</th>                   
										<th>LSM</th>
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
									$ft = ($featured == 1) ? 'Yes' : 'No' ;
								?>
									<tr>
										<td><?=$id_fundraise?></td>            
										<td><?=$name?></td>
										<td><?=get_lsm($id_lsm)->name?></td>
										<td><?=$ft?></td>
										<td>
											<?php
												echo anchor(base_url('fundpage/'.$url_title), "View", array("target" => "blank"));
												echo " | ".anchor($this->curpage."/edit/".$id_fundraise, "Edit");
												echo " | ".anchor($this->curpage."/delete/".$id_fundraise, "Delete", array("onclick" => "return confirm('Are you sure?');"));
												if($featured == 0) {
													echo " | ".anchor($this->curpage."/featured/".$id_fundraise."/1", "Set Featured", array("onclick" => "return confirm('Are you sure?');"));
												} else {
													echo " | ".anchor($this->curpage."/featured/".$id_fundraise."/0", "Set Not Featured", array("onclick" => "return confirm('Are you sure?');"));
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
