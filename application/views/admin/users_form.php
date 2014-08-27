<?php
	if($row)
	{
		extract(get_object_vars($row));	 
		$O = new OUser();
		$O->setup($row);
	}
	extract($_POST);
?>
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
						<div class="muted pull-left">User Form</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						
						<?=form_open()?>
							<table class="tbl_form">
								<tr>
									<th>Email</th>
									<td> : <input type="text" name="email" value="<?=$email?>" required autofocus /> <br/><?=form_error('email')?>                
									</td>
								</tr>
								<tr>
									<th>Password</th>
									<td> : <input type="password" name="password"  /> <br /><?=form_error('password')?>                
									</td>
									<td>
										To change the password, please fill up this field. Otherwise, leave this empty.
									</td>
								</tr>
								<tr>
									<th>Name</th>
									<td> : <input type="text" name="name" value="<?=$name?>" required  /> <br/><?=form_error('name')?>                
									</td>
								</tr>
								<tr>
									<th>Address</th>
									<td> : <input type="text" name="address" value="<?=$address?>" /> <br/><?=form_error('address')?>                
									</td>
								</tr>
								<tr>
									<th>City</th>
									<td> : <?php echo OLocation::drop_down_select("id_city",$id_city)?> <br/><?=form_error('id_city')?></td>
								</tr>
								<tr>
									<th>State</th>
									<td> : <input type="text" name="state" value="<?=$state?>"   /> <br/><?=form_error('state')?>                
									</td>
								</tr>
								<tr>
									<th>Zip Code</th>
									<td> : <input type="text" name="zip_code" value="<?=$zip_code?>"   /> <br/><?=form_error('zip_code')?>                
									</td>
								</tr>
								<tr>
									<th>Phone</th>
									<td> : <input type="text" name="phone" value="<?=$phone?>"   /> <br/><?=form_error('phone')?>                
									</td>
								</tr>
								<tr>
									<th>Fax</th>
									<td> : <input type="text" name="fax" value="<?=$fax?>"   /> <br/><?=form_error('fax')?>                
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<button class="btn btn-success" type="submit">Save</button>
										<button class="btn btn-default" type="reset">Reset</button>
										<button class="btn btn-default" type="button" onclick="location.href='<?=site_url("admin/users")?>';">Cancel</button>
									</td>
								</tr>    
							</table>
						<?=form_close()?>
					</div>
				</div>
				<!-- /block -->
			</div>
		</div>
	</div>
</div>