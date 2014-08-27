<?php
	if($row)
	{
		extract(get_object_vars($row));		
	}
	extract($_POST);
?>
<h2>Setting Form</h2><br/>

<?=form_open()?>
<?=print_error($this->session->flashdata('warning'))?>
<?=print_success($this->session->flashdata('success'))?>

<?=form_open()?>	
    <table class="tbl_form">
    	<tr>
        	<th>Name</th>
            <td><?=$name?></td>
        </tr>
        <tr>
        	<th>Description</th>
            <td><?=$description?></td>
        </tr>
        <tr>
        	<th>Content</th>
            <td><textarea name="content" cols="50" rows="10"><?=$content?></textarea> <br/><?=form_error('content')?></td>
        </tr>
        <tr>
            <td></td>            
            <td>
                <button class="positive button" type="submit"><span class="check icon"></span>Save</button>
                <button class="button" type="reset"><span class="reload icon"></span>Reset</button><br />
                <button class="negative button" type="button" onclick="location.href='<?=site_url($this->curpage)?>';"><span class="leftarrow icon"></span>Cancel</button>
            </td>
        </tr>    
    </table>
<?=form_close()?>