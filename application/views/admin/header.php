<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow" />
    
	<title>Welcome to Administration Page</title>
    
	<link href="<?=base_url('assets/css/additional-style.css')?>" rel="stylesheet" media="screen">
	<link href="<?=base_url('assets/css/other.css')?>" rel="stylesheet" media="screen">
	<link href="<?=base_url('assets/css/bootstrap-responsive.min.css')?>" rel="stylesheet" media="screen">
	<link href="<?=base_url('assets/admin-styles.css')?>" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/flick/jquery-ui.css" />
	
	<script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
	<script src="<?=base_url('assets/js/tiny_mce/tiny_mce.js')?>"></script>
</head>
<body>
    <?php
		$cu = get_current_admin();
		if($cu) $this->load->view('admin/tpl_nav_admin');
	?>
	<div class="container-fluid">