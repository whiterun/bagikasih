<?php
	$tt = $this->uri->segment(1);
	$uri = $this->uri->segment(2);
	$sg_arr = array('about_us', 'contact_us', 'faq', 'fundraise', 'fundpage', 'home', 'links', 'location', 'lsm', 'site_map', 'user', 'organizer');
	if($tt != FALSE) {
		if(!in_array($tt, $sg_arr)) {
			$tt = get_lsm_byurl($tt);
			$nm = ' - '.$tt->name;
			$ds = word_limiter($tt->deskripsi, 20);
			if($tt->image != '')
			{
				$mg = base_url('assets/images/'.$tt->image);
			} else {
				if($tt->id_lsm_category == '1') $mg = base_url('assets/img/panti asuhan.jpg');
				else if($tt->id_lsm_category == '2') $mg = base_url('assets/img/panti jompo.jpg');
				else if($tt->id_lsm_category == '3') $mg = base_url('assets/img/panti werdha.jpg');
			}
		} else if($tt == 'fundpage') {
			$mt = get_fundraise_byurl($uri);
			$nm = ' - '.$mt->name;
			$ds = word_limiter($mt->description, 20);
			if(get_lsm($mt->id_lsm)->image != '')
			{
				$mg = base_url('assets/images/'.get_lsm($row->id_lsm)->image);
			} else {
				if(get_lsm($mt->id_lsm)->id_lsm_category == '1') $mg = base_url('assets/img/panti asuhan.jpg');
				else if(get_lsm($mt->id_lsm)->id_lsm_category == '2') $mg = base_url('assets/img/panti jompo.jpg');
				else if(get_lsm($mt->id_lsm)->id_lsm_category == '3') $mg = base_url('assets/img/panti werdha.jpg');
			}
		}
	} else {
		$nm = '';
		$ds = '';
		$mg = base_url('assets/img/bgcired.png');
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<title>Bagi Kasih<?=$nm?></title>

	<!-- Assets -->
	<!--<link href="<?=base_url('assets/css/additional-style.css')?>" rel="stylesheet" type="text/css">-->
	<link href="<?=base_url('assets/less/bootstrap.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('assets/css/other.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('assets/css/jquery.fancybox.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('assets/resources/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css">
	<link href="<?=base_url('assets/resources/silviomoreto-bootstrap-select/bootstrap-select.css')?>" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css'>
	<link href="http://code.jquery.com/ui/1.10.2/themes/flick/jquery-ui.css" rel="stylesheet" />
	<link href='<?=base_url('assets/img/bagikasih_ico_red.png')?>' rel="icon" type="image/x-icon" />
	<link href='<?=base_url('assets/img/bagikasih_ico_red.png')?>' rel="shortcut icon" type="image/x-icon" />
	<!-- end of Assets -->
	
	<meta property="fb:app_id" content="213962165425335" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="Bagi Kasih<?=$nm?>" />
	<meta property="og:image" content="<?=$mg?>" />
	<meta property="og:description" content="<?=$ds?>" />
	<meta property="og:url" content="<?=base_url().uri_string()?>">
	
	<script>var switchTo5x=true;</script>
	<script src="http://w.sharethis.com/button/buttons.js"></script>
	<script>stLight.options({publisher: "b0d8f2a2-d574-4a19-bc22-2df91619b92c", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
	
	<style>
		.slidesjs-pagination li a {
			background-image: url("<?=base_url('assets/img/pagination.png')?>")
		}
	</style>
	</head>