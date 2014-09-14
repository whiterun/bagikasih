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
						<div class="muted pull-left">Banner List</div>
					</div>
					<div class="block-content collapse in">
						<p><?=anchor($this->curpage."/add", "<i class='icon-plus'></i> Create new",array("class" => "btn"))?></p>
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?php if(sizeof($list) <= 0) { ?>
							<p class='text_red'>Banner List is empty.</p>
						<? } else { ?>
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>ID</th>               
										<th>Title</th>
										<th>Description</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>                
								<?php 
									$i=1 + $uri;
									foreach($list as $row):
								?>		        
									<tr>
										<td><?=$row->id_banner?></td>
										<td><?=$row->title?></td>
										<td><?=word_limiter($row->description, 10)?></td>
										<td>
											<?php
												echo anchor($this->curpage."/edit/".$row->id_banner, "Edit");						
												echo " | ".anchor($this->curpage."/delete/".$row->id_banner, "Delete", array("onclick" => "return confirm('Are you sure?');"));
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