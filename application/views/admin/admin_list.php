<h2>Email Admin</h2><br/>

<p><?=anchor($this->curpage."/add", "+ Create new",array("class" => "button positive"))?></p>
<?=print_error($this->session->flashdata('warning'))?>
<?=print_success($this->session->flashdata('success'))?>

<?php
	if(sizeof($list) <= 0) echo "<p class='text_red'>The E-Mail Admin is empty.</p>";
    else
    {?>
		
        <table class="tbl_list">
            <thead>
                <tr>
					<th>No</th>
					<th>Email</th>
					<th>Action</th>
                </tr>
            </thead>
            <tbody>
                
            <?php 
                $i=1 + $uri;
                foreach($list as $row):				
               	 	extract(get_object_vars($row));
						$O = new OAdmin();                        
						$O->setup($row); 
			?>                                           
				<tr class="<?=alternator("odd", "even")?>" data_id="<?=$row->id?>">
    				<td><?=$i?></td>
					<td><?=$email?></td>
					<td>
					 	<?=anchor($this->curpage."/edit/".$id, "Edit",array('title' => 'Edit'))?>
                        <?=" | "?> 
						<?=anchor($this->curpage."/delete/".$id, "Delete", array("onclick" => "return confirm('Are you sure?');", "title" => "Delete"))?>
                 	</td>
				</tr>		
        <?php 
            unset($O);
			$i++; 
            endforeach; 
        ?>
        	</tbody>	
        </table>        
        <?=$pagination?>
<?php
  }
?>