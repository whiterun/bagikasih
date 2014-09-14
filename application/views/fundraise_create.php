	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
	?>
	<body>
		<?=$this->load->view('head')?>
		
		<!--<div class="header-wrap"></div>
		<div class="fix-space-on-top">&nbsp;</div>-->
		<!-- Content section -->
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata("warning"))?>
			<?=print_success($this->session->flashdata("success"))?>
				<div class="row-fluid">
					<div class="span3 left-side">
						<div class="well well-small detail-boxes-left">
							<ul class="nav nav-list">
								<li class="nav-header"><h5>Bagaimana aplikasi saya diproses</h5></li>
								<li class="divider"></li>
								<li>
									<ol>
										<li>Fill out the Registration Form</li>
										<li>We'll set up your Fundraise Page and send you a confirmation email.</li>
									</ol>
								</li>
							</ul>
						</div>
					</div>
					<!-- Right side of detail page -->
					<div class="span9 thumbnail right-side">
						<div class="row-fluid">
							<div class="span9 profile-title">
								<h3>Create your Fundraise Page</h3>
							</div>
						</div>
						<hr>
						<div class="row-fluid">
							<?=form_open_multipart('fundraise/save_fundraise')?>
								<div class="row-fluid">
									<div class="span12">
										<fieldset>
											<table cellpadding="4">
												<tr>
													<td>* Fundraise Name</td>
													<td><input name="name" type="text" required /></td>
												</tr>
												<tr>
													<td>* LSM</td>
													<td><?=OLsmList::drop_down_select("id_lsm")?></td>
												</tr>
												<tr>
													<td valign="top">* Description</td>
													<td><textarea name="description"></textarea></td>
												</tr>
											</table>
										</fieldset>
									</div>
								</div>
								<label class="checkbox">
									<input type="checkbox" required />
									I have read and accept bagikasih terms of service on behalf of register project.
								</label>
								<button type="submit" class="btn btn-success">Submit Application</button>
							<?=form_close()?>
						</div>
					</div>
					<!-- end Right side of detail page -->
				</div>
			</div>
		</div>
	</body>