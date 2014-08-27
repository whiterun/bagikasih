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
						<h4 class="subtitle"><?=get_lsm($co->id_lsm)->name?> Update</h4>
						<p><a href="<?=base_url('organizer/lsm_update_new')?>" class="btn btn-mini btn-default"><i class="icon-plus"></i> <?=langtext('add_update')?></a></p>
						<?php
							$list = OLsmList::get_lupdate(0, 0, 'a.id_update DESC', 'b.id_organizer = '.$co->id_organizer);
							if(count($list) > 0) {
						?>
							<table class="table table-bordered">
								<tr>
									<th>No.</th>
									<th>Title</th>
									<th>Content</th>
									<th>Action</th>
								</tr>
								<?php $i = 1; foreach($list as $row) { ?>
								<tr>
									<td><?=$i?></td>
									<td><?=$row->title?></td>
									<td><?=word_limiter($row->content, 10)?></td>
									<td>
										<div class="btn-group">
											<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
											<ul class="dropdown-menu" style="min-width:85px;">
												<li><a href="<?=base_url('organizer/lsm_update_edit/'.$row->id_update)?>">Edit</a></li>
												<li><a href="<?=base_url('organizer/lsm_update_delete/'.$row->id_update)?>" onclick="return confirm('Are you sure?');">Delete</a></li>
											</ul>
										</div>
									</td>
								</tr>
								<? $i++; } ?>
							</table>
						<? } else { ?>
							<p>There is no update found.</p>
						<? } ?>
					</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>