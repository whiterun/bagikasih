	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
		
		if($don->id_buyer != '')
		{
			$name = ($don->name != $cu->name && $don->name != '')? $don->name : $cu->name ;
			$email = ($don->email != $cu->email && $don->email != '')? $don->email : $cu->email ;
		} else {
			$name = $don->name;
			$email = $don->email;
		}
		
		if($don->id_fundraise != '')
		{
			$nmn = get_lsm($don->id_lsm)->name;
		} else {
			$nmn = get_lsm(get_fundraise($don->id_fundraise)->id_lsm)->name;
		}
		
		$amt = ($don->amount == 0.00) ? '' : str_replace('.00', '', $don->amount) ;
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
						<div class="span9 thumbnail detail-boxes">
							<h4 class="subtitle"><?=langtext('confirm_donation').' '.$nmn?></h4>
							<?=form_open()?>
								<table>
									<tr>
										<td>Name</td>
										<td>&emsp;:&emsp;</td>
										<td><?=$name?></td>
									</tr>
									<tr>
										<td>Email</td>
										<td>&emsp;:&emsp;</td>
										<td><?=$email?></td>
									</tr>
									<tr>
										<td>Donation Date</td>
										<td>&emsp;:&emsp;</td>
										<td><?=parse_date2($don->date_contribution)?></td>
									</tr>
									<tr>
										<td>Amount <span class="red">*</span></td>
										<td>&emsp;:&emsp;</td>
										<td>
											<div class="input-prepend">
												<span class="add-on">RP</span>
												<input type="text" name="amount" class="currfix" value="<?=$amt?>" required />
											</div>
										</td>
									</tr>
									<tr>
										<td>Payment Method</td>
										<td>&emsp;:&emsp;</td>
										<td><?=ucwords($don->to_pay)?></td>
									</tr>
									<tr>
										<td>Transfer Date <span class="red">*</span></td>
										<td>&emsp;:&emsp;</td>
										<td><input type="text" class="span5" id="dp3" value="<?=date('Y-m-d')?>" name="transfer_date" readonly required /></td>
									</tr>
									<tr>
										<td>Bank Account <span class="red">*</span></td>
										<td>&emsp;:&emsp;</td>
										<td><?=OBank::drop_down_select('bank', '', 'required')?></td>
									</tr>
									<tr>
										<td>Account Number <span class="red">*</span></td>
										<td>&emsp;:&emsp;</td>
										<td><input type="text" class="span6" name="account" required /></td>
									</tr>
									<tr>
										<td valign="top">Keterangan</td>
										<td valign="top">&emsp;:&emsp;</td>
										<td><textarea style="width:500px;" rows="5" name="description"></textarea></td>
									</tr>
									<tr>
										<td colspan="3">
											<button type="submit" class="btn btn-success">Confirm</button>&nbsp;
											<button type="button" class="btn btn-default" onclick="location.href='<?=base_url('user/donation_history')?>';">Cancel</button>
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