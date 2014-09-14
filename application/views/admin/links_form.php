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
							<a href="#">Information</a> <span class="divider">/</span>	
						</li>
						<li class="active">Links</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<!-- block -->
				<div class="block">
					<div class="navbar navbar-inner block-header">
						<div class="muted pull-left">Links Management</div>
					</div>
					<div class="block-content collapse in">
						<?=print_error($this->session->flashdata('warning'))?>
						<?=print_success($this->session->flashdata('success'))?>
						<?=form_open('')?>
							<textarea id="mce" name="description" style="width:100%;" rows="10"><?=auto_tidy(get_info('links')->content)?></textarea><?=form_error('description')?></td>
							<br>
							<button class="btn btn-success" type="submit">Edit</button>
						<?=form_close()?>
					</div>
				</div>
				<!-- /block -->
			</div>
		</div>
	</div>
</div>