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
							<h4 class="subtitle"><?=langtext('add_update')?></h4>
							<?=form_open()?>
								<table>
									<tr>
										<td valign="top">
											<label><?=langtext('description')?> <span class="red">*</span></label>
										</td>
										<td><textarea class="input-xxlarge" rows="5" name="description" placeholder="<?=langtext('plh_desc_fup')?>" required></textarea></td>
									</tr>
									<tr>
										<td colspan="2">
											<button type="submit" class="btn btn-success"><?=langtext('save')?></button>&nbsp;
											<button type="button" class="btn btn-default" onclick="history.back();">Cancel</button>
										</td>
									</tr>
								</table>
							<?=form_close()?>
						</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>