	<body>
		<?=$this->load->view('head')?>
		
		<!-- Content section -->
		<div class="content-wrap">
			<div class="container content detail">
				<div class="row-fluid">
					<div class="span12 thumbnail detail-boxes">
						<div class="row-fluid">
							<div class="span6 well well-small detail-boxes">
								<?=print_error(validation_errors())?>
								<?//print_r($my_data)?>
								<form action="" method="post">
									<h5>Your Account</h5>
									<table class="table table-hovered">
										<tbody>
											<tr>
												<td>Email</td>
												<td>: <input type="email" name="email" value="<?=$my_data[email]?>" /></td>
											</tr>
											<tr>
												<td>Password <span class="red">*</span></td>
												<td>: <input type="password" name="password" required /></td>
											</tr>
											<tr>
												<td>Confirm Password <span class="red">*</span></td>
												<td>: <input type="password" name="confirm_password" required /></td>
											</tr>
											<tr>
												<td>No. Handphone <span class="red">*</span></td>
												<td>: <input type="text" name="no_handphone" required /></td>
											</tr>
											<tr>
												<td colspan="2" align="center">
													<input type="submit" value="Ok" class="btn btn-success" />
												</td>
											</tr>
										</tbody>
									</table>
								</form>
							</div>
							<div class="span6 well well-small detail-boxes">
								<h5>Your Facebook Detail</h5>
								<table class="table table-hovered">
									<tbody>
										<tr>
											<td rowspan="5">
												<img src="https://graph.facebook.com/<?=$my_data[id]?>/picture?type=normal" class="img-polaroid" />
											</td>
											<td>Name</td>
											<td><b>: <?=$my_data[name]?></b></td>
										</tr>
										<tr>
											<td>Email</td>
											<td><b>: <?=$my_data[email]?></b></td>
										</tr>
										<tr>
											<td>Birthday</td>
											<td><b>: <?=fb_date($my_data[birthday])?></b></td>
										</tr>
										<tr>
											<td>Gender</td>
											<td><b>: <?=$my_data[gender]?></b></td>
										</tr>
										<tr>
											<td>Location</td>
											<td><b>: <?=$my_data[location][name]?></b></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>