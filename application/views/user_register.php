	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
	?>
	<body>
		<?=$this->load->view('head')?>
		
		<!-- Content section -->
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata("warning"))?>
			<?=print_success($this->session->flashdata("success"))?>
				<div class="row-fluid">
					<!-- Right side of detail page -->
					<div class="span12 thumbnail detail-boxes">
						<h4 class="subtitle"><?=langtext('reg_new_user')?></h4>
						<div class="row-fluid">
							<?=form_open()?>
								<div class="row-fluid">
									<div class="span6">
										<fieldset>
										<legend><?=langtext('private_detail')?></legend>
											<table cellpadding="4">
												<tr>
													<td>Email <span class="red">*</span></td>
													<td> : <input type="text" name="email" value="<?=set_value('email')?>" required /> <br/><?=form_error('email')?>                
													</td>
												</tr>
												<tr>
													<td><?=langtext('password')?> <span class="red">*</span></td>
													<td> : <input type="password" name="password" required /> <br /><?=form_error('password')?>                
													</td>
												</tr>
												<tr>
													<td><?=langtext('confirm_pass')?> <span class="red">*</span></td>
													<td> : <input type="password" name="confirm_password" required /> <br /><?=form_error('confirm_password')?>                
													</td>
												</tr>
												<tr>
													<td><?=langtext('name')?> <span class="red">*</span></td>
													<td> : <input type="text" name="name" value="<?=set_value('name')?>" required /> <br/><?=form_error('name')?>                
													</td>
												</tr>
												<tr>
													<td><?=langtext('phone')?></td>
													<td> : <input type="text" name="phone" value="<?=set_value('phone')?>" />
													</td>
												</tr>
												<tr>
													<td>Fax</td>
													<td> : <input type="text" name="fax" value="<?=set_value('fax')?>" />
													</td>
												</tr>
											</table>
										</fieldset>
									</div>
									<div class="span6">
										<fieldset>
										<legend><?=langtext('address')?></legend>
											<table>
												<tr>
													<td><?=langtext('address')?></td>
													<td> : <input type="text" name="address" value="<?=set_value('address')?>" />
													</td>
												</tr>
												<tr>
													<td><?=langtext('city')?></td>
													<td> : <?=OLocation::drop_down_select("id_city",$id_city)?></td>
												</tr>
												<tr>
													<td><?=langtext('regstate')?></td>
													<td> : <input type="text" name="state" value="<?=set_value('state')?>" />                
													</td>
												</tr>
												<tr>
													<td><?=langtext('zip_code')?></td>
													<td> : <input type="text" name="zip_code" value="<?=set_value('zip_code')?>" />
													</td>
												</tr>
											</table>
										</fieldset>
									</div>
								</div>
								<label class="checkbox">
									<input type="checkbox" required />
									<?=langtext('user_term_check')?>
								</label>
								<button type="submit" class="btn btn-success"><?=langtext('sign_up')?></button>
								&nbsp;
								<button type="reset" class="btn btn-default">Cancel</button>
							<?=form_close()?>
						</div>
					</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>