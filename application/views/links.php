	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
	?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata("warning"))?>
			<?=print_success($this->session->flashdata("success"))?>
				<div class="row-fluid">
					<div class="span2 left-side">
						<div class="thumbnail detail-boxes-left">
							<h4 class="subtitle"><?=langtext('others')?></h4>
							<p><?=anchor('about_us', langtext('about_us'))?></p>
							<p><?=anchor('contact_us', langtext('contact_us'))?></p>
							<!--<p><?=anchor('site_map', langtext('site_map'))?></p>-->
							<p><?=anchor('faq', 'F.A.Q')?></p>
							<p><?=anchor('links', 'Links')?></p>
						</div>
					</div>
					<div class="span10 thumbnail detail-boxes">
						<h4 class="subtitle">Links</h4>
						<?=auto_tidy(get_info('links')->content)?>
					</div>
				</div>
			</div>
		</div>
	</body>