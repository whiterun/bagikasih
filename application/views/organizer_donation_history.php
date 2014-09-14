	<?php $co = get_logged_in_organizer(); ?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata('warning'))?>
			<?=print_success($this->session->flashdata('success'))?>
				<div class="row-fluid">
					<?=$this->load->view('organizer_sidebar')?>
					<!-- Right side of detail page -->
					<div class="span9 thumbnail detail-boxes">
                        <h4 class="subtitle"><?=langtext('donation_history')?></h4>
						<?php
							$list = OLsmList::get_donation_list(0, 0, 'id_contribution DESC', 'id_lsm = '.$co->id_lsm);
							if(count($list) > 0) {
						?>
							<table class="table table-bordered">
								<tr>
									<th>No. </th>
									<th>User</th>
									<th><?=langtext('amount')?></th>
									<th><?=langtext('date')?></th>
									<th>Status</th>
									<th>Action</th>
								</tr>
								<?php
									$i = 1;
									foreach($list as $row) {
										if($row->id_buyer != '')
										{
											$name = ($row->name != get_buyer($row->id_buyer)->name && $row->name != '') ? $row->name : get_buyer($row->id_buyer)->name ;
										} else {
											$name = $row->name;
										}
								?>
								<tr>
									<td><?=$i?></td>
									<td>
										<?=$name?>
										<?php if($row->id_fundraise != '') { ?>
											<br>melalui <a href="<?=base_url(get_fundraise($row->id_fundraise)->url_title)?>"><?=get_fundraise($row->id_fundraise)->name?></a>
										<? } ?>
									</td>
									<td><?=currency_format($row->amount, $row->currency)?></td>
									<td><?=parse_date2($row->date_contribution)?></td>
									<td>
										<?php
											if($row->confirm == 0) {
												echo "<span class='red'>Not Confirmed</span>";
											} else if($row->confirm == 1) {
												echo "<span class='orange'>Payment Sent</span>";
											} else if($row->confirm == 2){
												echo "<span class='green'>Confirmed</span>";
											}
										?>
									</td>
									<td>
										<div class="btn-group">
											<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
											<ul class="dropdown-menu" style="min-width:85px;">
												<li><a href="<?=base_url('organizer/donation_detail/'.$row->id_contribution)?>">View Detail</a></li>
												<li><a href="<?=base_url('organizer/donation_delete/'.$row->id_contribution)?>" onclick="return confirm('Are you sure?');">Delete</a></li>
											</ul>
										</div>
									</td>
								</tr>
								<? $i++; } ?>
							</table>
						<? } ?>
                    </div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>