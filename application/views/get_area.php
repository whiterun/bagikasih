<?php
	if($data['id_kota'] != '') $wher1 = " id_kota = ".$data['id_kota'];
	else $wher1 = '';
	
	$list = OArea::get_list(0, 0, 'name asc', $wher1);
	if(sizeof($list) > 0) {
	$wd = ($this->uri->segment(1) == 'admin') ? '77%' : '100%' ;
?>
<table width="<?=$wd?>">
	<tr>
		<td>Area <span class="red">*</span></td>
		<td>
			<select name="area" required>
				<?php foreach($list as $row) { ?>
					<option value="<?=$row->id_area?>" <?=($row->id_area == $data['area']) ? 'selected' : '' ;?>><?=$row->name?></option>
				<? } ?>
			</select>
		</td>
	</tr>
</table>
<? } ?>