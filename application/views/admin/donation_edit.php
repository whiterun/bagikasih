<?php
	extract($_POST);
	
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
<div class="row-fluid">
	<!--/span-->
	<div class="span12" id="content">
		<div class="row-fluid">
			<div class="navbar">
				<div class="navbar-inner">
					<ul class="breadcrumb">
						<li>
							<a href="#">Home</a> <span class="divider">/</span>	
						</li>
						<li>
							<a href="#">LSM</a> <span class="divider">/</span>	
						</li>
						<li class="active">Edit Donation</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Edit Donation</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						
						<?=form_open_multipart()?>
							<fieldset>
								<legend>Edit Donation to <?=$nmn?></legend>
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
										<td><input type="text" class="span5" id="dp3" value="<?=$nod->transfer_date?>" name="transfer_date" readonly required /></td>
									</tr>
									<tr>
										<td>Bank Account <span class="red">*</span></td>
										<td>&emsp;:&emsp;</td>
										<td><?=OBank::drop_down_select('bank', $nod->id_bank, 'required')?></td>
									</tr>
									<tr>
										<td>Account Number <span class="red">*</span></td>
										<td>&emsp;:&emsp;</td>
										<td><input type="text" class="span6" name="account" value="<?=$nod->account_number?>" required /></td>
									</tr>
									<?php if($nod->description != '') { ?>
									<tr>
										<td valign="top">Keterangan <span class="red">*</span></td>
										<td valign="top">&emsp;:&emsp;</td>
										<td width="550"><textarea style="width:500px;" rows="5" name="description"><?=$nod->description?></textarea></td>
									</tr>
									<? } ?>
									<tr>
										<td>Status</td>
										<td>&emsp;:&emsp;</td>
										<td>
											<?php
												if($don->confirm == 0) {
													echo "<span class='red'>Not Confirmed</span>";
												} else if($don->confirm == 1) {
													echo "<span class='orange'>Payment Sent</span>";
												} else {
													echo "<span class='green'>Confirmed</span>";
												}
											?>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<button class="btn btn-success" type="submit"><span class="check icon"></span>Edit</button>
											<button class="btn btn-default" type="button" onclick="location.href='<?=$_SERVER['HTTP_REFERER']?>';"><span class="leftarrow icon"></span>Cancel</button>
										</td>
									</tr>
								</table>
							</fieldset>
						<?=form_close()?>
					</div>
				</div>
				<!-- /block -->
			</div>
		</div>
	</div>
</div>
<script language="javascript">
	$(function() {
		$("#dp3").datepicker({ dateFormat: 'yy-mm-dd' });
	});
</script>