	<?php $co = get_logged_in_organizer(); ?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
				<?=print_error($error_string)?>
				<?=print_error(validation_errors())?>
				<?=print_success($this->session->flashdata("success"))?>
				<div class="row-fluid">
					<?=$this->load->view('organizer_sidebar')?>
					<!-- Right side of detail page -->
						<div class="span9 thumbnail detail-boxes">
							<h4 class="subtitle"><?=langtext('change_pass')?></h4>
							<?=form_open()?>
								<fieldset>
									<label><?=langtext('current_pass')?></label>
									<input type="password" name="old_password" required />

									<label><?=langtext('new_pass')?></label>
									<input type="password" name="password" required />
									
									<label><?=langtext('confirm_pass')?></label>
									<input type="password" name="retype_password" required />
								</fieldset>
								<button type="submit" class="btn btn-success"><?=langtext('save')?></button>
							<?=form_close()?>
						</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>