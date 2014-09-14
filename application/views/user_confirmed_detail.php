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
							<h4 class="subtitle"><?=langtext('donation_to').$nmn?></h4>
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
										<td>Amount</td>
										<td>&emsp;:&emsp;</td>
										<td><?=currency_format($don->amount, $don->currency)?></td>
									</tr>
									<tr>
										<td>Payment Method</td>
										<td>&emsp;:&emsp;</td>
										<td><?=ucwords($don->to_pay)?></td>
									</tr>
									<tr>
										<td>Transfer Date</td>
										<td>&emsp;:&emsp;</td>
										<td><?=parse_date2($nod->transfer_date)?></td>
									</tr>
									<tr>
										<td>Bank Account</td>
										<td>&emsp;:&emsp;</td>
										<td><?=get_bank($nod->id_bank)->name?></td>
									</tr>
									<tr>
										<td>Account Number</td>
										<td>&emsp;:&emsp;</td>
										<td><?=$nod->account_number?></td>
									</tr>
									<?php if($nod->description != '') { ?>
									<tr>
										<td valign="top">Keterangan</td>
										<td valign="top">&emsp;:&emsp;</td>
										<td width="550"><?=$nod->description?></td>
									</tr>
									<? } ?>
									<tr>
										<td colspan="3">
											<button type="button" class="btn btn-default" onclick="location.href='<?=base_url('user/donation_history')?>';">Back</button>
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