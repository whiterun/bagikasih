<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade active in" id="idr">
		<div class="offset1">
		<?php if($data['curen'] == 'IDR') { ?>
			<label class="radio">
				<input type="radio" name="donval" value="10000" checked>10.000
			</label>
			<label class="radio">
				<input type="radio" name="donval" value="20000">20.000
			</label>
			<label class="radio">
				<input type="radio" name="donval" value="50000">50.000
			</label>
			<label class="radio">
				<input type="radio" name="donval" value="100000">100.000
			</label>
			<label class="radio">
				<input type="radio" name="donval" value="200000">200.000
			</label>
			<label class="radio">
				<input type="radio" name="donval" value="500000">500.000
			</label>
			<label class="radio pull-left">
				<input type="radio" name="donval" value="other">Lainnya
			</label>
			<div id="val_don" style="display:none;">
				<br><input id="odonval" name="otval" type="text" style="margin:1px 0 0 -50px;" />&emsp;<span id="ovr" class="red"></span>
			</div>
		<? } else if($data['curen'] == 'USD') { ?>
			<label class="radio">
				<input type="radio" name="donval" value="1" checked>1
			</label>
			<label class="radio">
				<input type="radio" name="donval" value="2">2
			</label>
			<label class="radio">
				<input type="radio" name="donval" value="5">5
			</label>
			<label class="radio">
				<input type="radio" name="donval" value="10">10
			</label>
			<label class="radio">
				<input type="radio" name="donval" value="20">20
			</label>
			<label class="radio">
				<input type="radio" name="donval" value="50">50
			</label>
			<label class="radio pull-left">
				<input type="radio" name="donval" value="other">Lainnya
			</label>
			<div id="val_don" style="display:none;">
				<br><input id="odonval" name="otval" type="text" style="margin:1px 0 0 -50px;" />&emsp;<span id="ovr" class="red"></span>
			</div>
		<? } ?>
		</div>
	</div>
</div>
<script>
	$("input[name$='donval']").click(function(){
		var rdval = $(this).val();
		if(rdval == 'other') {
			$("#odonval").attr('required', 'required');
			$("#val_don").slideDown('fast');
		} else {
			$("#odonval").removeAttr('required');
			$("#val_don").slideUp('fast');
		}
	});
	
	// $('#odonval').keypress(function(event){
		// console.log(event.which);
	// if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
		// event.preventDefault();
	// }});
	
	$('#odonval').keyup(function(){
		var num = $(this).val().replace(/\,/g,'');
		if(!isNaN(num))
		{
			if(num.indexOf('.') > -1)
			{
				num = num.split('.');
				num[0] = num[0].toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,'');
				if(num[1].length > 2){
					alert('You may only enter two decimals!');
					num[1] = num[1].substring(0,num[1].length-1);
				} return $(this).val(num[0]+'.'+num[1]);
			} else {
				return $(this).val(num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1,').split('').reverse().join('').replace(/^[\,]/,''));
			};
		} else {
			alert('Oops, number only!');
			return $(this).val($(this).val().substring(0,$(this).val().length-1));
		}
	});
	
	$('#odonval').keyup(function(){
		var min = ($('#curen').val() == 'USD') ? 1 : 10000 ;
		if($(this).val() != '') {
			if($(this).val() < min) {
				$('#ovr').text('Donation Minimum '+min+' '+$('#curen').val());
			} else {
				$('#ovr').text('');
			}
		} else {
			$('#ovr').text('Amount Required');
		}
	});
</script>