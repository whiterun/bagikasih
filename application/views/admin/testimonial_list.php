<h2>Testimonial List</h2><br/>
    
<?=print_error($this->session->flashdata('warning'))?>
<?=print_success($this->session->flashdata('success'))?>

<p><?=anchor($this->curpage."/add", "Create New")?></p>

<?php
if(sizeof($list) <= 0) echo "<p class='red'>There is no data found.</p>";
else
{
?>
    <table class="tbl_list">
        <thead>
            <tr>
                <th>No.</th>        	
                <th>Date</th>
                <th>User Info</th>
                <th>Message</th>
                <th>Status</th>
                <th>Action</th>                
            </tr>
        </thead>
        <tbody>
        <?php 
			$i=1 + $uri; 
			
			foreach($list as $row) :
			
				$U = new OUser($row->user_id);
				$user = $U->row;
		?>
            <tr class="<?=alternator("odd", "even")?>">
                <td><?=$i?></td>            
                <td><?=parse_date($row->dt)?></td>                
                <td>
                	<?=$user->name?><br />
                    <?=$user->email?><br />
                </td>                
                <td><?=trimmer($row->message, 50)?></td>
                <td>
                	<?php
						if($row->status == "pending") echo ucfirst($row->status)." | ".anchor($this->curpage.'/act/published/'.$row->id, 'set to Published');	
						else echo ucfirst($row->status)." | ".anchor($this->curpage.'/act/pending/'.$row->id, 'set to Pending');
					?>
                </td>
                <td>
                	<?php 
                		echo anchor($this->curpage."/delete/".$row->id, "Delete", array("onclick" => "return confirm('Are you sure?');"));
						echo " | ".anchor($this->curpage."/edit/".$row->id, "Edit");
					?>
                </td>
            </tr>
        <?php 
			$i++;
			unset($U);
			endforeach;
		?>	
        </tbody>
    </table>

    <?=$pagination?>
<?php
}
?>