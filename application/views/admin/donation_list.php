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
						<li class="active">Donation List</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Donation List</div>
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
										<th>Recipient</th>
										<th>Amount</th>
										<th>Donation Date</th>
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
											<?php if($row->id_fundraise != '') { ?>
												<br>via <a href="<?=base_url(get_fundraise($id_fundraise)->url_title)?>"><?=get_fundraise($id_fundraise)->name?></a>
											<? } ?>
										</td>
										<td><?=currency_format($amount, $currency)?></td>
										<td><?=parse_date2($date_contribution)?></td>
										<td>
											<?php
												if($confirm == 0) {
													echo "<span class='red'>Not Confirmed</span>";
												} else if($confirm == 1) {
													echo "<span class='orange'>Payment Sent</span>";
												} else {
													echo "<span class='green'>Confirmed</span>";
												}
											?>
										</td>
										<td>
											<div class="btn-group">
												<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
												<ul class="dropdown-menu" style="min-width:111px;">
													<li><?=anchor($this->curpage."/detail/".$id_contribution, "View Detail");?></li>
													<?php if($confirm == 1) { ?>
														<li><?=anchor($this->curpage."/approve/".$id_contribution, "Approve", array("onclick" => "return confirm('Are you sure?');"));?></li>
													<? } ?>
													<?php if($confirm != 0) { ?>
														<li><?=anchor($this->curpage."/edit/".$id_contribution, "Edit");?></li>
													<? } ?>
													<li><?=anchor($this->curpage."/delete/".$id_contribution, "Delete", array("onclick" => "return confirm('Are you sure?');"));?></li>
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