<?php extract($_POST); ?>
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
						<li class="active">Edit Volunteer</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Edit Volunteer</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						
						<?=form_open_multipart()?>
							<fieldset>
								<legend>Edit Volunteer to <?=get_lsm($vol->id_lsm)->name?></legend>
								<label>Volunteer Date</label>
								<input type="text" class="span3" id="dp3" value="<?=$vol->date_activity?>" name="date_activity" readonly required /><br>
								<label class="help-inline">Participant : </label>
								<input type="text" name="participant" class="span1" value="<?=$vol->participant?>" />
								<label class="checkbox"><input type="checkbox" id="ano" <?php if($vol->on_behalf != '') echo 'checked'; ?> /> Atas Nama Organisasi</label>
								<input type="text" class="span4" id="on_behalf" name="on_behalf" value="<?=$vol->on_behalf?>" <?php if($vol->on_behalf == '') echo 'disabled'; ?> />
								<label class="checkbox"><input type="checkbox" id="nk" <?php if($vol->activity != '') echo 'checked'; ?> /> Nama Kegiatan</label>
								<textarea class="span5" style="height:100px;" id="activity" name="activity" <?php if($vol->activity == '') echo 'disabled'; ?>><?=$vol->activity?></textarea>
								<br>
								<button class="btn btn-success" type="submit"><span class="check icon"></span>Edit</button>
								<button class="btn btn-default" type="button" onclick="location.href='<?=$_SERVER['HTTP_REFERER']?>';"><span class="leftarrow icon"></span>Cancel</button>
							</fieldset>
						<?=form_close()?>
					</div>
				</div>
				<!-- /block -->
			</div>
		</div>
	</div>
</div>
<script>
	$(function() {
		$("#dp3").datepicker({ dateFormat: 'yy-mm-dd' });
	});
	
	$(function() {
		$('#ano').click(function(){
			if($(this).is(':checked'))
			{
				$('#on_behalf').val('<?=$vol->on_behalf?>');
				$('#on_behalf').removeAttr('disabled');
			} else {
				$('#on_behalf').val('');
				$('#on_behalf').attr('disabled','disabled');
			}
		});
	});
	
	$(function() {
		$('#nk').click(function(){
			if($(this).is(':checked'))
			{
				$('#activity').val('<?=$vol->activity?>');
				$('#activity').removeAttr('disabled');
			} else {
				$('#activity').val('');
				$('#activity').attr('disabled','disabled');
			}
		});
	});
</script>