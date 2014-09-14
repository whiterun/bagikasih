<?php
	if($data['name'] != '')
	{
		$wher1 = array();
		if($data['name'] != '') $wher1[] = " name like '%".$data['name']."%'";
		$wher1[] = " end_date >= '".date('Y-m-d')."' AND approved = 1";
		$wher2 = implode(" AND ",$wher1);
	} else $wher2 = ' end_date >= "'.date('Y-m-d').'" AND approved = 1';
	
	$sort = 'id_fundraise '.$data['sort'];
	$list = OLsmList::get_fundraise_list(0, 0, $sort, $wher2);
	foreach($list as $row) {
	
	$don = get_funded('', $row->id_fundraise)->amt;
	$pro = ceil(($don / $row->fund_target * 100));
	
	if(get_lsm($row->id_lsm)->image != '')
	{
		$img = base_url('assets/images/'.get_lsm($row->id_lsm)->image);
	} else {
		if(get_lsm($row->id_lsm)->id_lsm_category == '1') $img = base_url('assets/img/panti asuhan.jpg');
		else if(get_lsm($row->id_lsm)->id_lsm_category == '2') $img = base_url('assets/img/panti jompo.jpg');
		else if(get_lsm($row->id_lsm)->id_lsm_category == '3') $img = base_url('assets/img/panti werdha.jpg');
	}
?>
	<li class="thumbnail splash-item" style="margin-bottom:15px; height:auto;">
		<a href="<?=base_url('fundpage/'.$row->url_title)?>">
			<img src="<?=$img?>" width="210" height="150">
			<h4><?=$row->name?></h4>
		</a>
		
		<p style="text-align:justify; height:60px"></p>
		<div class="stats">
			<div class="row-fluid">
				<div class="progress progress-striped progress-success">
				  <div class="bar" style="width: <?=$pro?>%;"></div>
				</div>
				<div class="row-fluid">
					<div class="span12">
						<strong><?=rupiah_format($don)?></strong>&nbsp;<em class="muted">terkumpul</em><br>
						<small class="muted">dari total <?=rupiah_format($row->fund_target)?></small>
					</div>
				</div>
			</div>
		</div>
	</li>
<? } ?>