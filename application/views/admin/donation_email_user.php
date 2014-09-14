<html>
<head>
    <title></title>
</head>
<body>    	
    <div class="header">
		<p>Dear <?=get_buyer($don->id_buyer)->name?></p> 
		<p>Your donation to <?=get_lsm($don->id_lsm)->name?>, <?=currency_format($don->amount, $don->currency)?> as been approved by admin at <?=parse_date2(date('Y-m-d'))?></p> 
		<p>Thank you.</p>
	</div>
</body>
</html>

<style>
	body, table { font:Arial, Helvetica, sans-serif; font-size:12px; }
	th { font-weight:bold; }
	th, td { height:15px; }
	
	.header { width:800px; }
	.header-left { float:left; width:600px; }
	.header-right { float:left; width:200px; margin-bottom:80px; }
	
	.batas { width:800px; }
	
	.konten { width:800px; }
	.title { margin-left:0px; }
	.title h1 { font-size:14px; margin-bottom:20px; }
	.order { margin-bottom:30px; }
</style>