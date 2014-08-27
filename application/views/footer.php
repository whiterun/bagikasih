<?php $co = get_logged_in_organizer(); ?>
	<div style="width:320px; left:58%;" id="modal" class="modal hide fade text-center">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4><?=langtext('sign_in')?></h4>
		</div>	
		<div class="modal-body">
			<div class="text-center">
				<a href="https://graph.facebook.com/oauth/authorize?client_id=213962165425335&redirect_uri=<?=site_url("home/login_facebook")?>&scope=email,user_birthday,user_location">
					<img src="<?=base_url('assets/img/fbcn.jpg')?>">
				</a>
			</div>
			<h5><?=strtoupper(langtext('or'))?></h5>
			<?=form_open('home/user_login', array('id'	=> 'sign_form'))?>
				<?=print_error($error_string)?>
				<?=print_error(validation_errors())?>
				&nbsp;
					<label><?=langtext('yemail_addr')?></label>
					<input type="text" name="email" placeholder="Email" value="<?=set_value('email')?>"/>
					<label><?=langtext('password')?></label>
					<input type="password" name="password" placeholder="<?=langtext('password')?>" />
				<br>
				<!--<p><?=anchor('account/forgot_password', 'Forgot Your Password ?')?></p>-->
				<div class="text-center">
					<button type="button" class="btn btn-warning" onclick="$('#sign_form').submit();"><?=langtext('sign_in')?></button> <?=langtext('or')?> <a href="<?=base_url('home/register')?>" class="btn btn-primary"><?=langtext('register')?></a>
				</div>
			<?=form_close()?>
		</div>
	</div>
	
	<div style="width:320px; left:58%;" id="modal5" class="modal hide fade text-center">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4>Organizer Login</h4>
		</div>	
		<div class="modal-body">
			<?=form_open('home/organizer_login', array('id'	=> 'orsign_form'))?>
				<?=print_error($error_string)?>
				<?=print_error(validation_errors())?>
					<label><?=langtext('yemail_addr')?></label>
					<input type="text" name="email" placeholder="Email" value="<?=set_value('email')?>"/>
					<label><?=langtext('password')?></label>
					<input type="password" name="password" placeholder="<?=langtext('password')?>" />
				<br>
				<!--<p><?=anchor('account/forgot_password', 'Forgot Your Password ?')?></p>-->
				<div class="text-center">
					<button type="button" class="btn btn-warning" onclick="$('#orsign_form').submit();"><?=langtext('sign_in')?></button>
				</div>
			<?=form_close()?>
		</div>
	</div>
	
	<div id="smodal" class="modal hide fade">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel">Thank You !</h3>
		</div>
		<div class="modal-body">
			<p>Your invitation message has been sent to your friend...</p>
		</div>
	</div>
	<!-- end Content section -->
	<footer class="bottom-section">
		<div class="container">
			<center>    
				<ul class="inline">
					<li><?=anchor('about_us', langtext('about_us'))?></li>
					<li><?=anchor('contact_us', langtext('contact_us'))?></li>
					<li><?=anchor('faq', 'F.A.Q')?></li>
					<li><?=anchor('links', 'Links')?></li>
					<?php if(!$co) { ?>
					<li><a href="#modal5" data-toggle="modal">Organizer Login</a></li>
					<? } ?>
				</ul>
			with love by <a href="mataharilabs.com">mataharilabs.com</a>
			</center>
		</div>
	</footer>
	<div id="fb-root"></div>

	<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    <script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
	
    <script src="<?=base_url('assets/resources/silviomoreto-bootstrap-select/bootstrap-select.min.js')?>"></script>
	
	<script src="<?=base_url('assets/js/jquery.hovercard.js')?>"></script>
	<script src="<?=base_url('assets/js/jquery.autocomplete.js')?>"></script>
	<script src="<?=base_url('assets/js/jquery.slides.min.js')?>"></script>
	<script src="<?=base_url('assets/js/holder.min.js')?>"></script>
	<script src="<?=base_url('assets/js/jquery.fancybox.js')?>"></script>

    <script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-44788192-1', 'bagikasih.com');
		ga('send', 'pageview');
		
		window.fbAsyncInit = function() {
			FB.init( { appId : '213962165425335', status : true, xfbml : true } );
		};
		
		function send_message()
		{
			FB.ui({
				method: 'send',
				link: 'http://bagikasih.com/<?=uri_string()?>',
			},	function(response)
				{
					// console.log(response);
					if(response.success === true)
					{
						$('#smodal').modal('show');
					}
				}
			);
		}
		
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/id_ID/all.js#xfbml=1&appId=213962165425335";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		$('#popover-hover').popover({ html: true});
		
        $('.selectpicker').selectpicker();
		
        $('.tooltip1').tooltip();
		
		$(function() {
			$('.slider').slidesjs({
				width: 940,
				height: 295,
				navigation: false,
					play : {
					auto : true
				}
			});
		});
		
		$(function(){
			$('#kotako').autocomplete({
				serviceUrl: '<?=base_url('lsm/search_kota')?>',
				onSelect: function (suggestion) {
					$('#id_kota').val(suggestion.data);
				}
			});
			
			$('#frname').autocomplete({
				serviceUrl: '<?=base_url('fundraise/search_fundraise')?>'
			});
		});
		
		$(function(){
			$('#lsmcat').autocomplete({
				serviceUrl: '<?=base_url('lsm/search_type_lsm')?>',
				onSelect: function (suggestion) {
					$('#id_lsm_category').val(suggestion.data);
				}
			});	
		});
		
		$(function(){
			$(document).on('click', 'a[href^="#"]', function (e) {
				e.preventDefault();
				var target = this.hash;
				$('html, body').stop().animate({
					'scrollTop': $(target).offset().top
				}, 900, 'swing', function () {
					window.location.hash = target;
				});
			});
		});
		
		$( ".currfix" ).bind( "keyup blur", function() {
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
		
		$(function() {
			$('#ano').click(function(){
				if($(this).is(':checked'))
				{
					$('#on_behalf').removeAttr('disabled');
				} else {
					$('#on_behalf').val('');
					$('#on_behalf').attr('disabled','disabled');
				}
			});
		});
		
		$(function() {
			$('#nk').click(function(){
				if($(this).is(':checked'))
				{
					$('#activity').removeAttr('disabled');
				} else {
					$('#activity').val('');
					$('#activity').attr('disabled','disabled');
				}
			});
		});
		
		function show_data()
		{
			$.post("<?=base_url("lsm/splash_list")?>", { id_kota : $("#id_kota").val(), id_lsm_category : $("#id_lsm_category").val(), name : $("#name").val(), sort : $('#sort').val(), area : $('#area').val() }, function(data) { show_area($('#area').val()); $('#splash_data').html(data); });
			return false;
		}
		
		function show_lsm()
		{
			$.post("<?=base_url("fundraise/fraise_list1")?>", { id_kota : $("#id_kota").val(), id_lsm_category : $("#id_lsm_category").val(), name : $("#name").val(), sort : $('#sort').val(), area : $('#area').val() }, function(data) { show_area($('#area').val()); $('#lsm_data').html(data); });
			return false;
		}
		
		function show_fraise()
		{
			$.post("<?=base_url("fundraise/fraise_list")?>", { name : $("#frname").val() }, function(data) { $('#fraise_data').html(data); });
			return false;
		}
		
		function show_clist()
		{
			$.post("<?=base_url("user/currency_list")?>", { curen : $("#curen").val() }, function(data) { $('#currency').html(data); });
			return false;
		}
		
		function show_area(id_ar)
		{
			var id_area = (id_ar != '') ? id_ar : '' ;
			$.post("<?=base_url("lsm/l_area")?>", { id_kota : $("#id_kota").val(), area : id_area }, function(data) { $('.l_area').html(data); });
			return false;
		}
		
		function show_drop_area()
		{
			$.post("<?=base_url("lsm/lget_area")?>", { id_kota : $("#kota").val(), area : $("#tarea").val() }, function(data) { $('#get_area').html(data); });
			return false;
		}
		
		function reset_filter()
		{
			$('#name').val(''); 
			$('#id_kota').val(''); 
			$('#id_lsm_category').val(''); 
			$('#sort option[value=DESC]').attr('selected', 'selected'); 
			show_data();
		}
		
		function reset_lsm()
		{
			$('#name').val(''); 
			$('#id_kota').val(''); 
			$('#id_lsm_category').val(''); 
			$('#sort option[value=DESC]').attr('selected', 'selected'); 
			show_lsm();
		}
		
		
		show_data();
		
		show_lsm();
		
		show_fraise();
		
		show_clist();
		
		show_area();
		
		show_drop_area();
		
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
		
		$("input[name$='rep']").click(function(){
			var rdval = $(this).val();
			if(rdval == '0') {
				$("#res").attr('required', 'required');
				$("#val_rep").slideDown('fast');
			} else {
				$("#res").removeAttr('required');
				$("#val_rep").slideUp('fast');
			}
		});
		
		function rvolf()
		{
			if($('input[name$="rep"]').prop('checked') == true) {
				if($('#val_rep').css('display') == 'block') {
					if($.trim($('#res').val()).length == 0) {
						alert('Write some reasons first!');
					} else {
						$('#rvolf').submit();
					}
				} else {
					$('#rvolf').submit();
				}
			} else {
				$('#rvolf').submit();
			}
		}
		
		$('#tooltip').tooltip('hide');
		
		$(document).ready(function() {
			var id = 1;
			// Add Row
			$(document).on("click", "table.tabel button.add", function () {
				$('.tabel tbody > tr:last').after('<tr><td><div class="input-append"><input type="url" class="span10" name="video[]" placeholder="<?=langtext('ytube_embed_link')?>" /><button type="button" class="btn btn-default"><i class="icon-film"></i></button><button type="button" class="remove btn btn-danger" title="Remove"><i class="icon-remove"></i></button></div></td></tr>');
			});
			
			// Remove
			$(document).on("click", "table.tabel button.remove", function() {
				if ($('.tabel tbody > tr').length <= 1) {
					return false;
				}
				$(this).closest("tr").remove();
			});
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
		
		$(document).ready(function() {
			$('.fancybox').fancybox();
		});
		
		$(function() {
			$("#dp3").datepicker({ dateFormat: 'yy-mm-dd' });
		});
    </script>
	<script type="text/javascript" src="<?=base_url('assets/js/swfupload/swfupload.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/jquery.swfupload.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/jquery.swfupload.init.js')?>"></script>
	<script src="<?=base_url('assets/js/tiny_mce/tiny_mce.js')?>"></script>
	<script src="<?=base_url('assets/js/tiny_mce_advanced_2.js')?>"></script>
	
	<script type="text/javascript" src="<?=base_url('assets/js/jquery.zclip.min.js')?>"></script>
	
	<script type="text/javascript">
	$(function(){
		var total_photos = $('#total_photos').text();
		jquery_upload_image("-photo",".set","image[]","#preview-photo","1 MB",10,'<?=base_url()?>');
	});
	
	$(document).ready(function(){
		$('#zcopy').zclip({
			path:'<?=base_url('assets/js/ZeroClipboard.swf')?>',
			copy:$('.uritex').val()
		});
	});
	</script>
	</body>
</html>