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
						<li class="active">Volunteer List</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Volunteer List</div>
					</div>
					<div class="block-content in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?php if(sizeof($list) <= 0) { ?>
							<p class='text_red'>There is no data found.</p>
						<? } else { ?>
							<table class="table table-bordered table-striped tbl_list">
								<thead>
									<tr>
										<th>ID</th>
										<th>Destination</th>
										<th>User</th>
										<th>Volunteer Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>                
								<?php 
									$i=1 + $uri;
									foreach($list as $row):
									extract(get_object_vars($row));
								?>
									<tr>
										<td><?=$i?></td>            
										<td>
											<a href="<?=base_url(get_lsm($id_lsm)->url_title)?>"><?=get_lsm($id_lsm)->name?></a>
										</td>
										<td>
											<?=get_buyer($id_buyer)->name?>
											<?php if($participant != '') { ?>(+<?=$participant?>)<? } ?>
											<?php if($on_behalf != '') { ?>
												<br>On Behalf of <?=$on_behalf?>
										<? } ?>
										</td>
										<td><?=parse_date2($date_activity)?></td>
										<td>
											<?php
												if($suspend == 1) {
														echo "<span class='red'>Suspended</span>";
												} else {
													if($cancel_stat == 0) {
														echo "<span class='green'>Active</span>";
													} else {
														echo "<span class='red'>Cancelled</span>";
													}
												}
											?>
										</td>
										<td>
											<div class="btn-group">
												<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
												<ul class="dropdown-menu" style="min-width:111px;">
													<li><?=anchor($this->curpage."/detail/".$id_volunteer, "View Detail");?></li>
													<?php if($suspend == 0) { ?>
														<li><?=anchor($this->curpage."/suspend/".$id_volunteer, "Suspend", array("onclick" => "return confirm('Are you sure?');"));?></li>
													<? } ?>
													<li><?=anchor($this->curpage."/edit/".$id_volunteer, "Edit");?></li>
													<li><?=anchor($this->curpage."/delete/".$id_volunteer, "Delete", array("onclick" => "return confirm('Are you sure?');"));?></li>
												</ul>
											</div>
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