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
						<li class="active">Volunteer Report List</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Volunteer Report List</div>
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
										<th>LSM</th>
										<th>Volunteer Date</th>
										<th>Report As</th>
										<th>Report Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>                
								<?php 
									$i=1 + $uri;
									foreach($list as $row):
									extract(get_object_vars($row));
									if($report_as == 0) {
										$rep = $other;
									} else {
										if($report_as == 1) $rep = 'Spam or Scam';
										else if($report_as == 2) $rep = 'Hate Speech';
									}
									$vol = get_volunteer($id_volunteer);
								?>
									<tr>
										<td><?=$i?></td>            
										<td>
											<?=get_buyer($vol->id_buyer)->name?>
											<?php if($vol->on_behalf != '') { ?> 
												<a href="#" title="On Behalf Of">(<?=$vol->on_behalf?>)</a>
											<? } ?>
											<br>
											To <a href="<?=base_url(get_lsm($vol->id_lsm)->url_title)?>"><?=get_lsm($vol->id_lsm)->name?></a>
										</td>
										<td><?=parse_date2($vol->date_activity)?></td>
										<td><?=$rep?></td>
										<td><?=parse_date2($report_date)?></td>
										<td><?=anchor($this->curpage."/delete/".$id_vreport, "Delete", array("onclick" => "return confirm('Are you sure?');"));?></td>
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