<span class="muted pull-right">
	<i class="icon-calendar"></i>
		<?=parse_date2($vol->date_activity)?>
</span>
<h5 style="margin-top:0px;">
	<?=get_buyer($vol->id_buyer)->name?>
	<?php if($vol->participant != '') { ?> 
		<a href="#" title="Amount of participant(s)">(+<?=$vol->participant?>)</a>
	<? } ?>
	<?php if($vol->on_behalf != '') { ?>
		, Atas Nama <?=$vol->on_behalf?>
	<? } ?>
</h5>
<?php if($vol->activity != '') { ?>
<blockquote>
	Dalam rangka kegiatan <?=$vol->activity?>
</blockquote>
<? } ?>