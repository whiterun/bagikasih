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
						<li class="active">Volunteer Detail</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Volunteer Detail</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						
						<?=form_open_multipart()?>
							<fieldset>
								<legend>Volunteer to <span class="text-success"><em><?=get_lsm($vol->id_lsm)->name?></em></span></legend>
								<span class="muted pull-right">
									<i class="icon-calendar"></i>
										<?=parse_date2($vol->date_activity)?>
								</span>
								<h5>
									<?=get_buyer($vol->id_buyer)->name?>
									<?php if($vol->participant != '') { ?> 
										<a href="#" title="Amount of participant(s)">(+<?=$vol->participant?>)</a>
									<? } ?>
									<?php if($vol->on_behalf != '') { ?>
										, On Behalf of <?=$vol->on_behalf?>
									<? } ?>
								</h5>
								<?php if($vol->activity != '') { ?>
								<blockquote>
									Due to activity <?=$vol->activity?>
								</blockquote>
								<? } ?>
								<button class="btn btn-default" type="button" onclick="location.href='<?=$_SERVER['HTTP_REFERER']?>';"><span class="leftarrow icon"></span>Back</button>
							</fieldset>
						<?=form_close()?>
					</div>
				</div>
				<!-- /block -->
			</div>
		</div>
	</div>
</div>