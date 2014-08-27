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
						<h4 class="subtitle"><?=get_fundraise($id)->name?> Updates List</h4>
						<p><a href="<?=base_url('user/new_fupdate')?>" class="btn btn-mini btn-default"><i class="icon-plus"></i> <?=langtext('add_update')?></a></p>
						<?php
							$list = OUser::get_fundpage_update(0, 0, 'id_fupdate DESC', 'id_fundraise = '.$id);
							if(count($list) > 0) {
						?>
							<table class="table table-bordered">
								<tr>
									<th>No.</th>
									<th><?=langtext('description')?></th>
									<th>Action</th>
								</tr>
								<?php $i = 1; foreach($list as $row) { ?>
								<tr>
									<td><?=$i?></td>
									<td><?=word_limiter($row->description, 15)?></td>
									<td>
										<div class="btn-group">
											<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
											<ul class="dropdown-menu">
												<li><a href="<?=base_url('user/fupdate_edit/'.$row->id_fupdate)?>">Edit</a></li>
												<li><a href="<?=base_url('user/fupdate_delete/'.$row->id_fupdate)?>" onclick="return confirm('Are you sure?');">Delete</a></li>
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