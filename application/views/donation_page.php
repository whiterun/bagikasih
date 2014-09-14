	<?php
		$cu = get_logged_in_user();
		$lang = $this->session->userdata("lang");
	?>
	<body>
		<?=$this->load->view('head')?>
		<div class="content-wrap">
			<div class="container content detail">
				<?=print_error($this->session->flashdata('warning'))?>
				<?=print_success($this->session->flashdata('success'))?>
				<h3 class="text-center"> <?=langtext('confirm_support')?> <em><?=$msl->name?></em></h3>
				<div class="row-fluid">
					<?=form_open('user/save_donation')?>
					<div class="span7 left-side">
						<div class="thumbnail detail-boxes">
							<h4 class="subtitle"><?=langtext('donation')?></h4>
							<h5><?=langtext('determine_donation')?> <em><?=$msl->name?></em> </h5>
							<?=langtext('currency')?> :
							<select id="curen" class="selectpicker span4" name="currency" onchange="show_clist();">
								<option value="IDR">Rupiah (IDR)</option>
								<option value="USD">Dollar (USD)</option>
							</select>
							<br><br>
							<div id="currency"></div>
							<hr>
							<h4><?=langtext('about_you')?></h4>
							<table style="margin-bottom:4px;">
								<div class="form-inline">
									<?=langtext('name')?>&nbsp;&nbsp;
									<input type="text" name="name" value="<?=$cu->name?>" class="span5" placeholder="<?=langtext('name')?>" required />&nbsp;&nbsp;&nbsp;
									Email&nbsp;&nbsp;
									<input type="email" name="email" value="<?=$cu->email?>" class="span5" placeholder="Email" required />
								</div>
								<!--<span>Anda dapat mengganti nama anda di dalam halaman <em>Yayasan Anak Jalanan</em> setelah donasi anda sudah di terima.</span>
								<br>--><br>
								<label class="checkbox">
									<input type="checkbox" name="anonym" value="yes" /><?=langtext('donate_no_name')?>
								</label>
								<label class="checkbox">
									<input type="checkbox" name="update" value="yes" /><?=langtext('receive_update')?>
								</label>
								<div class="form-actions" style="margin:10px -5px -8px; padding-top:10px;">
									<button class="btn btn-danger" type="submit"><?=langtext('donate')?></button>
								</div>
							</table>
						</div>
					</div>
					<!-- Right side of detail page -->
					<div class="span5 right-side">
						<div class="thumbnail detail-boxes">
							<h4 class="subtitle"><?=langtext('cpay_method')?>:</h4>
							<hr>
							<!--<label class="radio">
								<input type="radio" name="topay" value="paypal" checked />
								<img src="<?=base_url('assets/img/paypal-secure.png')?>">
							</label><br>-->
							<label class="radio">
								<!--<input type="radio" name="topay" value="transfer" />-->
								<img src="<?=base_url('assets/img/transfer_bank.jpg')?>">
							</label>
						</div>
					</div>
					<!-- end Right side of detail page -->
					<?=form_close()?>
				</div>
			</div>
		</div>
	</body>
	