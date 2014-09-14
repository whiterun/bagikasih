	<?php
		if($row)
		{
			extract(get_object_vars($row));	
			$P = new OLsmList();
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
				<?=print_error($this->session->flashdata('warning'))?>
				<?=print_success($this->session->flashdata('success'))?>
				<div class="row-fluid">
					<?=$this->load->view('organizer_sidebar')?>
					<!-- Right side of detail page -->
						<div class="span9 thumbnail detail-boxes">
							<h4 class="subtitle"><?=langtext('edit_bacc')?></h4>
							<?=form_open()?>
								<table cellpadding="4">
									<tr>
										<td>Bank</td>
										<td>
											<select name="bank" id="bank">
												<option value="0">- Choose Bank -</option>
											<?php
												// OBank::drop_down_select("bank", $id_bank)
												$bo = OBank::get_list(0, 0, "id_bank DESC");
												foreach($bo as $kn) {
												$sl = ($kn->id_bank == $id_bank) ? 'selected' : '' ;
											?>
												<option value="<?=$kn->id_bank?>" <?=$sl?>><?=$kn->name?></option>
											<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Account Number</td>
										<td><input name="anumber" type="text" value="<?=$acc_number?>" /></td>
									</tr>
									<tr>
										<td>Account Holder</td>
										<td><input name="aholder" type="text" value="<?=$acc_holder?>" /></td>
									</tr>
									<tr>
										<td colspan="2">
											<button type="submit" class="btn btn-success">Edit</button>
										</td>
									</tr>
								</table>
								<span class="set"><?=implode("", $input_file)?></span>
							<?=form_close()?>
						</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>