/*
$(function() {
	jquery_upload_image(prefix,insertid,inputname,previewid,filesize,filelimit);
});
*/

var fpath = "";
var domain = "http://"+document.domain;

function jquery_upload_image(prefix,insertid,inputname,previewid,filesize,filelimit)
{
	if(filesize == null) filesize = 1024;
	if(filelimit == null) filelimit = 1;
	$('#swfupload-control'+prefix).swfupload({
		upload_url: domain + "/ajax/upload",
		file_post_name: "uploadfile",
		file_size_limit : filesize,
		file_types : "*.jpg;*.png;*.gif",
		file_types_description : "Image file",
		file_upload_limit : filelimit,
		flash_url : "/" +fpath+ "assets/js/swfupload/swfupload.swf",
		button_image_url : "/" +fpath+ "assets/js/swfupload/wdp_buttons_upload_114x29.png",
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button'+prefix)[0],
		debug: true
	})
	.bind('fileQueued', function(event, file){
		var listitem='<li id="'+file.id+'" >'+
			'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
			'<div class="progressbar" ><div class="progress" ></div></div>'+
			'<p class="status" >Pending</p>'+
			'<span class="cancel" >&nbsp;</span>'+
			'</li>';
		$('#log'+prefix).append(listitem);
		$('li#'+file.id+' .cancel').bind('click', function(){
			var swfu = $.swfupload.getInstance('#swfupload-control'+prefix);
			swfu.cancelUpload(file.id);
			$('li#'+file.id).slideUp('fast');
		});
		// start the upload since it's queued
		$(this).swfupload('startUpload');
	})
	.bind('fileQueueError', function(event, file, errorCode, message){
		alert('Size of the file '+file.name+' is greater than limit');
	})
	.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
		$('#queuestatus'+prefix).text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
	})
	.bind('uploadStart', function(event, file){
		$('#log'+prefix+' li#'+file.id).find('p.status').text('Uploading...');
		$('#log'+prefix+' li#'+file.id).find('span.progressvalue').text('0%');
		$('#log'+prefix+' li#'+file.id).find('span.cancel').hide();
	})
	.bind('uploadProgress', function(event, file, bytesLoaded){
		//Show Progress
		var percentage=Math.round((bytesLoaded/file.size)*100);
		$('#log'+prefix+' li#'+file.id).find('div.progress').css('width', percentage+'%');
		$('#log'+prefix+' li#'+file.id).find('span.progressvalue').text(percentage+'%');
		$('#log'+prefix+' li#'+file.id).find('span.cancel').show();
	})
	.bind('uploadSuccess', function(event, file, serverData, receivedResponse){
		var item=$('#log'+prefix+' li#'+file.id);
		item.find('div.progress').css('width', '100%');
		item.find('span.progressvalue').text('100%');
		item.addClass('success').find('p.status').html('<span class="green">Completed.</span>');
		$('#log'+prefix+' li#'+file.id).find('span.cancel').hide();
		/*
		console.log("Server response= "+serverData);
		console.log("receivedResponse= "+receivedResponse);
		*/
		if(serverData != "error")
		{
			$(insertid).append('<input type="hidden" name="' +inputname+ '" class="' +inputname.replace("[]","")+ '" value="'+serverData+'" />');
		}

		var dt = new Date();
		
		if(filelimit > 1) $(previewid).append('<img src="/' +fpath+ 'assets/images/temp/resize_'+serverData+'?'+dt.getTime()+'" alt="Preview" width="200" />');
		else $(previewid).html('<img src="/' +fpath+ 'assets/images/temp/resize_'+serverData+'?'+dt.getTime()+'" alt="Preview" width="200" />');
	})		
	.bind('uploadError', function (event, file, error_code, message)
	{
		/*
		console.log("event= "+event);
		console.log("file= "+file);
		console.log("error_code= "+error_code);
		console.log("message= "+message);
		*/
	})
	.bind('uploadComplete', function(event, file){
		// upload has completed, try the next one in the queue
		$(this).swfupload('startUpload')
		var totalImageUpload = $('.'+ inputname.replace("[]","") ).length;
		//alert("You've just upload "+totalImageUpload+" image files.");
		if( parseInt(totalImageUpload) >= parseInt(filelimit) )
		{
			$(this).swfupload('setButtonDisabled', true);
		}
		//$('.success').delay(2500).fadeOut(1200);
	})	

}

function jquery_upload_mp3(prefix,insertid,inputname,previewid,filesize,filelimit)
{
	if(filesize == null) filesize = "20 MB";
	if(filelimit == null) filelimit = 1;
	$('#swfupload-control'+prefix).swfupload({
		upload_url: domain + "/ajax/upload/mp3",
		file_post_name: "uploadfile",
		file_size_limit : filesize,
		file_types : "*.mp3",
		file_types_description : "mp3 file",
		file_upload_limit : filelimit,
		flash_url : "/" +fpath+ "assets/js/swfupload/swfupload.swf",
		button_image_url : "/" +fpath+ "assets/js/swfupload/wdp_buttons_upload_114x29.png",
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button'+prefix)[0],
		debug: true
	})
	.bind('fileQueued', function(event, file){
		var listitem='<li id="'+file.id+'" >'+
			'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
			'<div class="progressbar" ><div class="progress" ></div></div>'+
			'<p class="status" >Pending</p>'+
			'<span class="cancel" >&nbsp;</span>'+
			'</li>';
		$('#log'+prefix).append(listitem);
		$('li#'+file.id+' .cancel').bind('click', function(){
			var swfu = $.swfupload.getInstance('#swfupload-control'+prefix);
			swfu.cancelUpload(file.id);
			$('li#'+file.id).slideUp('fast');
		});
		// start the upload since it's queued
		$(this).swfupload('startUpload');
	})
	.bind('fileQueueError', function(event, file, errorCode, message){
		alert('Size of the file '+file.name+' is greater than limit');
	})
	.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
		$('#queuestatus'+prefix).text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
	})
	.bind('uploadStart', function(event, file){
		$('#log'+prefix+' li#'+file.id).find('p.status').text('Uploading...');
		$('#log'+prefix+' li#'+file.id).find('span.progressvalue').text('0%');
		$('#log'+prefix+' li#'+file.id).find('span.cancel').hide();
		//*
		var totalFileUpload = $('.'+ inputname.replace("[]","") ).length;
		if( parseInt(totalFileUpload) >= parseInt(filelimit)-1 )
		{
			$(this).swfupload('setButtonDisabled', true);
		}
		//*/
	})
	.bind('uploadProgress', function(event, file, bytesLoaded){
		//Show Progress
		var percentage=Math.round((bytesLoaded/file.size)*100);
		$('#log'+prefix+' li#'+file.id).find('div.progress').css('width', percentage+'%');
		$('#log'+prefix+' li#'+file.id).find('span.progressvalue').text(percentage+'%');
		$('#log'+prefix+' li#'+file.id).find('span.cancel').show();
	})
	.bind('uploadSuccess', function(event, file, serverData, receivedResponse){
		var item=$('#log'+prefix+' li#'+file.id);
		item.find('div.progress').css('width', '100%');
		item.find('span.progressvalue').text('100%');
		item.addClass('success').find('p.status').html('<span class="green">Completed.</span>');
		$('#log'+prefix+' li#'+file.id).find('span.cancel').hide();
		/*
		console.log("Server response= "+serverData);
		console.log("receivedResponse= "+receivedResponse);
		*/
		if(serverData != "error")
		{
			$(insertid).append('<input type="hidden" name="' +inputname+ '" class="' +inputname.replace("[]","")+ '" value="'+serverData+'" />');
		}
		var dt = new Date();
		
		/*
		if(filelimit > 1) $(previewid).append('Successfully Uploaded.');
		else $(previewid).html('Successfully Uploaded.');
		*/
		//*
		$.ajax({
			type: "POST",
			url: domain+"/ajax/view/song_upload_preview",
			data: { 'mp3':serverData, 'duration':'01:00' },
			async: false,
			success: function(resp)
			{
				if(filelimit > 1) $(previewid).append(resp);
				else $(previewid).html(resp);
			}
		});
		//*/
	})		
	.bind('uploadError', function (event, file, error_code, message)
	{
		/*
		console.log("event= "+event);
		console.log("file= "+file);
		console.log("error_code= "+error_code);
		console.log("message= "+message);
		*/
	})
	.bind('uploadComplete', function(event, file){
		// upload has completed, try the next one in the queue
		$(this).swfupload('startUpload');
		//$(this).swfupload('setButtonDisabled', true);
		var totalFileUpload = $('.'+ inputname.replace("[]","") ).length;
		//alert("You've just upload "+totalFileUpload+" mp3 files and you have max upload "+filelimit+" files.");
		if( parseInt(totalFileUpload) >= parseInt(filelimit) )
		{
			$(this).swfupload('setButtonDisabled', true);
		}
		//$('.success').delay(2500).fadeOut(1200);
	})	

}




function jquery_upload_all_files(prefix,insertid,inputname,previewid,filesize,filelimit)
{
	if(filesize == null) filesize = 2056;
	if(filelimit == null) filelimit = 1;
	$('#swfupload-control'+prefix).swfupload({
		upload_url: domain + "/ajax/upload/all_files",
		file_post_name: "uploadfile",
		file_size_limit : filesize,
		file_types : "",
		file_types_description : "all file",
		file_upload_limit : filelimit,
		flash_url : "/" +fpath+ "assets/js/swfupload/swfupload.swf",
		button_image_url : "/" +fpath+ "assets/js/swfupload/wdp_buttons_upload_114x29.png",
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button'+prefix)[0],
		debug: true
	})
	.bind('fileQueued', function(event, file){
		var listitem='<li id="'+file.id+'" >'+
			'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
			'<div class="progressbar" ><div class="progress" ></div></div>'+
			'<p class="status" >Pending</p>'+
			'<span class="cancel" >&nbsp;</span>'+
			'</li>';
		$('#log'+prefix).append(listitem);
		$('li#'+file.id+' .cancel').bind('click', function(){
			var swfu = $.swfupload.getInstance('#swfupload-control'+prefix);
			swfu.cancelUpload(file.id);
			$('li#'+file.id).slideUp('fast');
		});
		// start the upload since it's queued
		$(this).swfupload('startUpload');
	})
	.bind('fileQueueError', function(event, file, errorCode, message){
		alert('Size of the file '+file.name+' is greater than limit');
	})
	.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
		$('#queuestatus'+prefix).text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
	})
	.bind('uploadStart', function(event, file){
		$('#log'+prefix+' li#'+file.id).find('p.status').text('Uploading...');
		$('#log'+prefix+' li#'+file.id).find('span.progressvalue').text('0%');
		$('#log'+prefix+' li#'+file.id).find('span.cancel').hide();
	})
	.bind('uploadProgress', function(event, file, bytesLoaded){
		//Show Progress
		var percentage=Math.round((bytesLoaded/file.size)*100);
		$('#log'+prefix+' li#'+file.id).find('div.progress').css('width', percentage+'%');
		$('#log'+prefix+' li#'+file.id).find('span.progressvalue').text(percentage+'%');
		$('#log'+prefix+' li#'+file.id).find('span.cancel').show();
	})
	.bind('uploadSuccess', function(event, file, serverData, receivedResponse){
		var item=$('#log'+prefix+' li#'+file.id);
		item.find('div.progress').css('width', '100%');
		item.find('span.progressvalue').text('100%');
		item.addClass('success').find('p.status').html('<span class="green">Completed.</span>');
		$('#log'+prefix+' li#'+file.id).find('span.cancel').hide();
		/*
		console.log("Server response= "+serverData);
		console.log("receivedResponse= "+receivedResponse);
		*/
		if(serverData != "error")
		{
			$(insertid).append('<input type="hidden" name="' +inputname+ '" class="' +inputname.replace("[]","")+ '" value="'+serverData+'" />');
		}
		var dt = new Date();
		
		if(filelimit > 1) $(previewid).append(serverData);
		else $(previewid).html(serverData);
	})		
	.bind('uploadError', function (event, file, error_code, message)
	{
		/*
		console.log("event= "+event);
		console.log("file= "+file);
		console.log("error_code= "+error_code);
		console.log("message= "+message);
		*/
	})
	.bind('uploadComplete', function(event, file){
		// upload has completed, try the next one in the queue
		$(this).swfupload('startUpload')
		var totalImageUpload = $('.'+ inputname.replace("[]","") ).length;
		//alert("You've just upload "+totalImageUpload+" image files.");
		if( parseInt(totalImageUpload) >= parseInt(filelimit) )
		{
			$(this).swfupload('setButtonDisabled', true);
		}
		//$('.success').delay(2500).fadeOut(1200);
	})	

}