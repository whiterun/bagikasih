<?php
	if($row)
	{
		extract(get_object_vars($row));		
	}
	extract($_POST);
?>
<h2>Testimonial Form</h2><br/>

<?=print_error($this->session->flashdata('warning'))?>
<?=print_success($this->session->flashdata('success'))?>

<?=form_open()?> 
    <table class="tbl_form">    	
        <tr>
        	<th>User</th>
            <td><?=OUser::drop_down_select("user_id",$user_id)?></td>
        </tr>          
        <tr>
        	<th>Message</th>
            <td><textarea name="message" cols="60" rows="30" required><?=$message?></textarea> <br /><?=form_error('message')?></td>
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