<? $curpage = $this->curpage."/newsletter_queues"; ?>
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
							<a href="#">Other</a> <span class="divider">/</span>	
						</li>
						<li class="active">Newsletters</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Newsletter Queue List</div>
					</div>
					<div class="block-content collapse in">
						<p>
							<?=anchor($this->curpage, "Newsletter Email List")?> |
							<?=anchor($this->curpage."/add", "Create New Email")?> |
							<?=anchor($this->curpage."/create_newsletter", "Create Newsletter")?>
						</p>
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?php if(sizeof($list) <= 0) { ?>
							<p class='text_red'>There is no data found.</p>
						<? } else { ?>
							<form>
								<div class="input-append">
									<input class="span9" id="appendedInputButtons" type="text" name="keyword" value="<?=$_GET["keyword"]?>" placeholder="Type Keywords..." />
									<button class="btn" type="submit">Search</button>
									<?=anchor('admin/newsletters/newsletter_queues','Refresh', array('class' => 'btn'))?>
								</div>
							</form>
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No.</th>        	
										<th>Email</th>                    
										<th>Subject</th>
										<th>Content</th>
										<th>Status</th>
										<th>Sent Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>                
								<?php 
									$i=1 + $uri;
									
									foreach($list as $row):
										$nc_res = $this->db->get_where("newsletter_contents", array("id" => $row->newsletter_content_id));
										$nc_row = $nc_res->row();
								?>		        
									<tr>
										<td><?=$i?></td>            
										<td><?=$row->email?></td>      
										<td><?=$nc_row->title?></td>      
										<td><?=character_limiter(strip_tags($nc_row->body), 100)?></td>      
										<td><?=$row->status?></td>
										<td><?=(intval($row->sent_date) > 0 ? date("F, d Y \a\\t H:i:sa", strtotime($row->sent_date)) : "" )?></td>
										<td>						
											<?						
											echo anchor($curpage."/delete/".$row->id, "Delete", array("onclick" => "return confirm('Are you sure?');"));
											//echo " | ".anchor($this->curpage."/edit/".$row->id, "Edit");						
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