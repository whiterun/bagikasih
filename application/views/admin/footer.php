			<hr>
			<footer>
				<p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>
			</footer>
		</div>
	</body>
	<script type="text/javascript" src="<?=base_url('assets/js/swfupload/swfupload.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/jquery.swfupload.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/jquery.swfupload.init.js')?>"></script>
	<script src="<?=base_url('assets/js/tiny_mce_advanced.js')?>"></script>
	
	<script type="text/javascript">
	$(document).ready(function() {
		var id = 1;
		// Add Row
		$(document).on("click", "table.tabel button.add", function () {
			$('.tabel tbody > tr:last').after('<tr><td><div class="input-append"><input type="url" class="span10" name="video[]" placeholder="Paste YouTube embed link here..." /><button type="button" class="btn btn-default"><i class="icon-film"></i></button><button type="button" class="remove btn btn-danger" title="Remove"><i class="icon-remove"></i></button></div></td></tr>');
		});
		
		// Remove
		$(document).on("click", "table.tabel button.remove", function() {
			if ($('.tabel tbody > tr').length <= 1) {
				return false;
			}
			$(this).closest("tr").remove();
		});
	});

	$("input[name$='bgc']").click(function(){
		var rdval = $(this).val();
		if(rdval == 'yes') {
			$(".upload").attr('required', 'required');
			$("#div_name").slideDown('fast');
		} else if(rdval == 'no') {
			$(".upload").removeAttr('required');
			$("#div_name").slideUp('fast');
		}
	});
	
	$(document).ready(function() {
		$('#lname').blur(function(){  
			if($('#lname').val().length < 6){  
				$('#lname_result').html('<p class="alert alert-error" style="height:15px; margin-top:-1px; padding-top:7px;">Minimum amount of chars is 6</p>');
			}else{  
				$('#lname_result').html('<p style="height:15px; margin-top:-1px; padding-top:7px;"><img src="<?=base_url('assets/img/spiffygif.gif')?>" /> Checking...</p>');
				check_lname();  
			}  
		});
	});
  
	function check_lname() {
		var lname = $('#lname').val();
		$.post("<?=base_url('lsm/check_lname')?>", { lname: lname },  
			function(result) {
			if(result == 1) {
				$('#lname_result').html('<p class="alert alert-error" style="height:15px; margin-top:-1px; padding-top:7px;">' + lname + ' is Already Taken</p>');
			} else {
				$('#lname_result').html('<p class="alert alert-success" style="height:15px; margin-top:-1px; padding-top:7px;">' + lname + ' is Available</p>');
			}  
		});
	}
	
	$("#lname").keyup(function(){
		$('#urlname').val($(this).val().replace(/[_|\s]+/g, '-').toLowerCase());
	});
	
	$(function(){
		var total_photos = $('#total_photos').text();
		jquery_upload_image("-photo",".set","image[]","#preview-photo","1 MB",10,'<?=base_url()?>');
	});
	
	function show_drop_area()
	{
		$.post("<?=base_url("admin/lsm_list/lget_area")?>", { id_kota : $("#kota").val(), area : $("#tarea").val() }, function(data) { $('#get_area').html(data); });
		return false;
	}
	
	show_drop_area();
	</script>
</html>
