	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
	?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata('warning'))?>
			<?=print_success($this->session->flashdata('success'))?>
				<div class="row-fluid">
					<?=$this->load->view('user_sidebar')?>
					<!-- Right side of detail page -->
					<div class="span10 thumbnail detail-boxes">
						<h4 class="subtitle"><?=langtext('fundpage_list')?></h4>
						<?php
							$list = OUser::get_fundpage_list(0, 0, 'id_fundraise DESC', 'id_buyer = '.$cu->id_buyer);
							if(count($list) > 0) {
						?>
							<table class="table table-bordered">
								<tr>
									<th>No. </th>
									<th><?=langtext('name')?></th>
									<th><?=langtext('social_institute')?></th>
									<th><?=langtext('end_date')?></th>
									<th>Action</th>
								</tr>
								<?php $i = 1; foreach($list as $row) { ?>
								<tr>
									<td><?=$i?></td>
									<td><?=$row->name?></td>
									<td><?=get_lsm($row->id_lsm)->name?></td>
									<td><?=parse_date2($row->end_date)?></td>
									<td>
										<div class="btn-group">
											<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li><a href="<?=base_url('user/fundpage_edit/'.$row->id_fundraise)?>">Edit</a></li>
												<li><a href="<?=base_url('user/fundpage_update/'.$row->id_fundraise)?>">View Updates</a></li>
												<li><a href="<?=base_url('user/fundpage_delete/'.$row->id_fundraise)?>" onclick="return confirm('Are you sure?');">Delete</a></li>
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