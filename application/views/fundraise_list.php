	<?php $cu = get_logged_in_user(); ?>
	<body>
		<div class="header-wrap">
			<?=$this->load->view('head')?>
			<div class="container header">
				<center>
					<h3><?=langtext('search_fundpage')?></h3>
				</center>
				<!-- Big Search -->
				<div class="big-search">
					<div class="row-fluid">
						<div class="span12 wrap">
							<input type="text" id="frname" class="span10" placeholder="<?=langtext('search')?>" style="width:85%;" />
							<button class="btn btn-success pull-right" onclick="show_fraise();"><i class="icon-search"></i> <?=langtext('search')?></button>
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
				<select id="sort" class="selectpicker span2" onchange="show_fraise();">
					<option value="DESC"><?=langtext('latest_joined')?></option>
					<option value="ASC"><?=langtext('oldest')?></option>
				</select>
				<!--<button class="btn" onclick="reset_fraise();"><i class="icon-refresh"></i> Reload</button>-->
				<br>
				<br>
				<div id="pan" class="row-fluid">
					<ul id="fraise_data" class="pin" style="list-style-type:none;">             
						<!-- the Item -->
						
						<!-- end the Item -->
					</ul> 
				</div>
			</div>
		</div>
	</body>
