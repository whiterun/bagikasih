<?php
	if($data['id_kota'] != '') $wher1 = " id_kota = ".$data['id_kota'];
	else $wher1 = '';
	
	$list = OArea::get_list(0, 0, 'name asc', $wher1);
	if($data['id_kota'] != '' && sizeof($list) > 0) {
?>
	<select id="area" onchange="show_data(); show_lsm();">
		<option value=""><?=langtext('all')?> Area</option>
		<?php foreach($list as $row) { ?>
			<option value="<?=$row->id_area?>" <?=($row->id_area == $data['area']) ? 'selected' : '' ;?>><?=$row->name?></option>
		<? } ?>
	</select>
<? } ?>