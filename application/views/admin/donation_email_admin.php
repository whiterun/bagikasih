<?php
if($don->id_buyer != '')
{
	$name = ($don->name != get_buyer($don->id_buyer)->name && $don->name != '')? $don->name : get_buyer($don->id_buyer)->name ;
} else {
	$name = $don->name;
}
?>
<html>
<head>
    <title></title>
</head>
<body>    	
	<p>Dear <?=$user?>, </p>
	<p>Donation to <?=get_lsm($don->id_lsm)->name?> by <?=$name?> has been approved</p>
    <p>Detail :</p><br />
    <div class="header">
    	<div class="konten">
            <table>
				<tr>
					<td>Amount</td>
					<td>:</td>
					<td><?=currency_format($don->amount, $don->currency)?></td>
                </tr>
                <tr>
					<td>Transfer Date</td>
					<td>:</td>
					<td><?=parse_date2($nod->transfer_date)?></td>
                </tr>
                <tr>
					<td>Bank Account</td>
					<td>:</td>
					<td><?=get_bank($nod->id_bank)->name?></td>
                </tr>
				<tr>
					<td>Account Number</td>
					<td>:</td>
					<td><?=$nod->account_number?></td>
                </tr>
				<?php if($nod->description != '') { ?>
				<tr>
					<td>Description</td>
					<td>:</td>
					<td><?=$nod->description?></td>
                </tr>
				<? } ?>
            </table>
        </div>
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