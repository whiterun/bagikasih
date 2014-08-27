<html>
<head>
    <title></title>
</head>
<body>    	
    <div class="header">
    <p>Dear <?=$admin?></p> 
    <p>Volunteer to <?=$lsm?> at <?=parse_date2($date)?> has been cancelled by <?=$user?></p> 
    <p><h5>Reason : </h5></p>
    <blockquote><?=$reason?></blockquote>
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