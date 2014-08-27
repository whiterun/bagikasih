<?php
	session_start();
	$_SESSION['KCFINDER']=array();
	$_SESSION['KCFINDER']['disabled'] = false;
	$_SESSION['KCFINDER']['uploadURL'] = "../tinymcpuk/gambar";
	$_SESSION['KCFINDER']['uploadDir'] = "";
	  
	if($row)
	{
		extract(get_object_vars($row));	 
		$O = new OAdmin();
		$O->setup($row);
	}
	extract($_POST);
?>

<h2>E-Mail Admin Form</h2>
<?php /*?><p><?=anchor("admin/users","Users")?> &gt; User Form</p>	<?php */?>
<?=print_error($this->session->flashdata('warning'))?>
<?=print_success($this->session->flashdata('success'))?>

<?=form_open()?>
	<table class="tbl_form">
    	<tr>
            <th>Email</th>
            <td>
            	<input type="text" name="email" value="<?=$email?>" required autofocus /> 
                <br/><?=form_error('email')?>                
            </td>
        </tr>
		<tr>
			<td></td>
			<td>
            	<button class="positive button" type="submit"><span class="check icon"></span>Save</button>
                <button class="button" type="reset"><span class="reload icon"></span>Reset</button>
                <button class="negative button" type="button" onclick="location.href='<?=site_url("admin/users")?>';"><span class="leftarrow icon"></span>Cancel</button>
			</td>
		</tr>    
	</table>
<?=form_close()?>

<script type="text/javascript" src="/_assets/tinymcpuk/jscripts/tiny_mce/my_tiny_mce.js"></script>