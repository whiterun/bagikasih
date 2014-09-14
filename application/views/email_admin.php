<html>
<head>
    <title></title>
</head>
<body>    	
	<p>Dear Admin, </p>
    <p>This is New Donation Detail for you :</p><br />
    <div class="header">
    	<div class="konten">
            <table>
            	<tr>
                    <td colspan="3">Donation Detail</td>
                </tr>
				<tr>
                    <td>To</td>
                    <td>:</td>
                    <td><?=$to?></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td><?=$name?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><?=$email?></td>
                </tr>
				<tr>
                    <td>Amount</td>
                    <td>:</td>
                    <td><?=$amount?></td>
                </tr>
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