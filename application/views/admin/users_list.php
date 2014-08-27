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
							<a href="#">Users</a> <span class="divider">/</span>	
						</li>
						<li class="active">User List</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">User List</div>
					</div>
					<div class="block-content collapse in">
						<p><?=anchor($this->curpage."/add", "<i class='icon-plus'></i> Create new",array("class" => "btn"))?></p>
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?php if(sizeof($list) <= 0) { ?>
							<p class='text_red'>User List is empty.</p>
						<? } else { ?>
							<form>
								<div class="input-append">
									<input class="span9" id="appendedInputButtons" type="text" name="keyword" value="<?=$_GET["keyword"]?>" placeholder="Type Keywords..." />
									<button class="btn" type="submit">Search</button>
									<?=anchor('admin/users','Refresh', array('class' => 'btn'))?>
								</div>
							</form>
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>ID</th>
										<th>Date Added</th>
										<th>Name</th>
										<th>Email</th>
										<th>Info</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$i=1 + $uri;
									foreach($list as $row):				
										extract(get_object_vars($row));
											$O = new OUser();                        
											$O->setup($row); ?>                        
									<tr>
										<td><?=$row->id?></td>
										<td><?=parse_date_time($dt)?></td>
										<td><?=$email?></td>
										<td><?=$name?></td>
										<td style="font-size: 11px;">
											<strong>Address :</strong> <?=$address?><br />
											<strong>Location :</strong> <?=get_city($id_city)->name?>, <?=$state?><br />
											<strong>Zip Code :</strong> <?=$zip_code?><br />
											<strong>Phone :</strong> <?=$phone?>
										</td>
										<td>
											<?=anchor($this->curpage."/edit/".$id_buyer, "Edit",array('title' => 'Edit'))?>
											<?=" | "?> 
											<?=anchor($this->curpage."/delete/".$id_buyer, "Delete", array("onclick" => "return confirm('Are you sure?');", "title" => "Delete"))?>
										</td>
									</tr>		
								<?php 
									unset($O);
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