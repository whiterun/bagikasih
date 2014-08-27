<?php
	extract($_POST);
	if($don->id_buyer != '')
	{
		$name = ($don->name != get_buyer($don->id_buyer)->name && $don->name != '')? $don->name : get_buyer($don->id_buyer)->name ;
		$email = ($don->email != get_buyer($don->id_buyer)->name && $don->email != '')? $don->email : get_buyer($don->id_buyer)->email ;
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
						<li class="active">Donation Detail</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Donation Detail</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						
						<?=form_open_multipart()?>
							<fieldset>
								<legend>Donation to <?=$nmn?></legend>
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
									<?php if($don->confirm != 0) { ?>
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
									<? } } ?>
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
											<button class="btn btn-default" type="button" onclick="location.href='<?=base_url($this->curpage)?>';"><span class="leftarrow icon"></span>Back</button>
											<?php if($don->confirm == 1) { ?>
												<?=anchor($this->curpage."/approve/".$don->id_contribution, "Approve", array("class" => "btn btn-warning", "onclick" => "return confirm('Are you sure?');"));?></li>
											<? } ?>
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