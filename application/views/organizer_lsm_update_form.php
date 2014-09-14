	<?php
		if($row)
		{
			extract(get_object_vars($row));	
			$P = new OLsmUpdate();
			$P->setup($row);
		}
		extract($_POST);
	?>
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
							<h4 class="subtitle">Update</h4>
							<?=form_open()?>
								<table>
									<tr>
										<td><label>Title <span class="red">*</span></label></td>
										<td><input type="text" name="title" value="<?=$title?>" required /> <br/><?=form_error('title')?></td>
									</tr>
									<tr>
										<td valign="top"><label>Content <span class="red">*</span></label></td>
										<td><textarea name="content" class="input-xxlarge" rows="6" required><?=$content?></textarea> <br/><?=form_error('content')?></td>
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