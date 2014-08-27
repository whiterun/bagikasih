	<?php $co = get_logged_in_organizer(); ?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
				<?=print_error($error_string)?>
				<?=print_error(validation_errors())?>
				<?=print_success($this->session->flashdata("success_profile"))?>
				<div class="row-fluid">
					<?=$this->load->view('organizer_sidebar')?>
					<!-- Right side of detail page -->
						<div class="span9 thumbnail detail-boxes">
							<h4 class="subtitle"><?=langtext('my_account')?></h4>
							<?=form_open()?>
								<div class="row-fluid">
									<div class="span6">
										<fieldset>
											<legend><?=langtext('private_detail')?></legend>
											<label><?=langtext('name')?> <span class="red">*</span></label>
											<input name="name" value="<?=$co->name?>" class="large-field" type="text">
											
											<label>E-Mail <span class="red">*</span></label>
											<input name="email" value="<?=$co->email?>" class="large-field" type="text">
											
											<label><?=langtext('telephone')?></label>
											<input name="phone" value="<?=$co->phone?>" class="large-field" type="text">
											
											<label>Fax</label>
											<input name="fax" value="<?=$co->fax?>" class="large-field" type="text">
										</fieldset>
									</div>
									<div class="span6">
										<fieldset>
											<legend><?=langtext('address')?></legend>
											<label><?=langtext('address')?></label>
											<input name="address" value="<?=$co->address?>" class="large-field" type="text">
											
											<label><?=langtext('city')?></label>
											<?=OLocation::drop_down_select("id_city", $co->id_city)?>
											
											<label><?=langtext('zip_code')?></label>
											<input name="zip_code" value="<?=$co->zip_code?>" class="large-field" type="text" >
											
											<label><?=langtext('regstate')?></label>
											<input name="state" value="<?=$co->state?>" class="large-field" type="text" >
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