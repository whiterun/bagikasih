<?php
	if($data['id_kota'] != '' || $data['id_lsm_category'] != '' || $data['name'] != '')
	{
		$wher1 = array();
		if($data['id_kota'] != '')
		{
			$wher1[] = " id_kota = ".$data['id_kota'];
		}
		if($data['id_lsm_category'] != '')
		{
			$wher1[] = " id_lsm_category = ".$data['id_lsm_category'];
		}
		if($data['name'] != '')
		{
			$wher1[] = " name like '%".$data['name']."%'";
		}
		if($data['area'] != '')
		{
			$wher1[] = " id_area = ".$data['area'];
		}
		$wher1[] = " approved = 1";
		$wher2 = implode(" AND ",$wher1);
	} else $wher2 = ' approved = 1';
	
	$sort = 'id_lsm '.$data['sort'];
	$list = OLsmList::get_list(0, 0, $sort, $wher2);
	foreach($list as $row) {
		if($row->image != '')
		{
			$img = base_url('assets/images/'.$row->image);
		} else {
			if($row->id_lsm_category == '1') $img = base_url('assets/img/panti asuhan.jpg');
			else if($row->id_lsm_category == '2') $img = base_url('assets/img/panti jompo.jpg');
			else if($row->id_lsm_category == '3') $img = base_url('assets/img/panti werdha.jpg');
		}
?>
	<li class="thumbnail splash-item" style="margin-bottom:15px; height:auto; padding-bottom:10px;">
		<a href="<?=base_url($row->url_title)?>">
			<img src="<?=$img?>" width="210" height="150">
			<h4><?=$row->name?></h4>
		</a>
		
		<p style="text-align:justify; height:auto;">
			<?=substr($row->deskripsi, 0, 158)?>...
		</p>
		<span>&nbsp;<i class="icon-map-marker icon-large"></i>&nbsp;&nbsp;<?=$row->address?>, <?=get_city($row->id_kota)->name?></span>
	</li>
<? } ?>
