	<?php $cu = get_logged_in_user(); ?>
	<body>
		<div class="header-wrap">
			<?=$this->load->view('head')?>
			<div class="container header">
				<center>
					<h3><?=langtext('search').' '.langtext('social_institute')?></h3>
				</center>
				<!-- Big Search -->
				<div class="big-search">
					<div class="row-fluid">
						<div class="span12 wrap">
							<?=langtext('city')?>:&nbsp;
							<select id="id_kota" class="span2" onchange="show_data();">
								<option value=""><?=langtext('all')?></option>
							<?php
								$list = OLocation::get_list(0,0,'name asc');
								foreach($list as $row) {
							?>
								<option value="<?=$row->id_kota?>"><?=$row->name?></option>
							<? } ?>
							</select>
							&nbsp;&nbsp;
							<?=langtext('type')?>:&nbsp;
							<select id="id_lsm_category" class="span2" onchange="show_data();">
								<option value=""><?=langtext('all')?></option>
							<?php
								$list = OLsmCategory::get_list();
								foreach($list as $row) {
							?>
								<option value="<?=$row->id_lsm_category?>"><?=$row->category?></option>
							<? } ?>
							</select>
							&nbsp;&nbsp;
							<?=langtext('keyword')?>:&nbsp;
							<input type="text" id="name" class="span3" placeholder="<?=langtext('type_keywords')?>">
							<button class="btn btn-success pull-right" onclick="show_data();"><i class="icon-search"></i> <?=langtext('search')?></button>
						</div>
					</div>
				</div>
				<!-- end Big Search -->
			</div>
		</div>
		<!-- Content section -->
		<div class="content-wrap">  
			<div class="container content">
				<span><?=langtext('sort_by')?>:</span>
				<select id="sort" class="span2" onchange="show_data();">
					<option value="DESC"><?=langtext('latest_joined')?></option>
					<option value="ASC"><?=langtext('oldest')?></option>
				</select>
				<span class="l_area"></span>
				<!--<button class="btn" onclick="reset_filter();"><i class="icon-refresh"></i> Reload</button>-->
				<br>
				<br>
				<div id="pan" class="row-fluid">
					<ul id="splash_data" class="pin" style="list-style-type:none;">             
						<!-- the Item -->
						
						<!-- end the Item -->
					</ul> 
				</div>
			</div>
		</div>
	</body>
