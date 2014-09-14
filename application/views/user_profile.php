	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
	?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
				<?=print_error($error_string)?>
				<?=print_error(validation_errors())?>
				<?=print_success($this->session->flashdata("success_profile"))?>
				<div class="row-fluid">
					<?=$this->load->view('user_sidebar')?>
					<!-- Right side of detail page -->
						<div class="span10 thumbnail detail-boxes">
							<h4 class="subtitle"><?=langtext('my_account')?></h4>
							<?=form_open()?>
								<div class="row-fluid">
									<div class="span6">
										<fieldset>
											<legend><?=langtext('private_detail')?></legend>
											<label><?=langtext('name')?> <span class="red">*</span></label>
											<input name="name" value="<?=$cu->name?>" class="large-field" type="text">
											
											<label>E-Mail <span class="red">*</span></label>
											<input name="email" value="<?=$cu->email?>" class="large-field" type="text">
											
											<label><?=langtext('telephone')?></label>
											<input name="phone" value="<?=$cu->phone?>" class="large-field" type="text">
											
											<label>Fax</label>
											<input name="fax" value="<?=$cu->fax?>" class="large-field" type="text">
										</fieldset>
									</div>
									<div class="span6">
										<fieldset>
											<legend><?=langtext('address')?></legend>
											<label><?=langtext('address')?></label>
											<input name="address" value="<?=$cu->address?>" class="large-field" type="text">
											
											<label><?=langtext('city')?></label>
											<?=OLocation::drop_down_select("id_city", $cu->id_city)?>
											
											<label><?=langtext('zip_code')?></label>
											<input name="zip_code" value="<?=$cu->zip_code?>" class="large-field" type="text" >
											
											<label><?=langtext('regstate')?></label>
											<input name="state" value="<?=$cu->state?>" class="large-field" type="text" >
										</fieldset>
									</div>
								</div>
								<button type="submit" class="btn btn-success"><?=langtext('save')?></button>
							<?=form_close()?>
						</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>