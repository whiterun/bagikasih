tinyMCE.init({
	mode : "exact",
	elements : "mce",
	theme : "advanced",
	editor_deselector : "mceNoEditor",
	plugins : "spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,ibrowser",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect|cut,copy,paste,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,anchor,cleanup,|,sub,sup,|,charmap",
    	theme_advanced_buttons2 : "",
    	theme_advanced_buttons3 : "",
    //  theme_advanced_buttons4 : "ibrowser",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	// Skin options
	skin : "o2k7",
	skin_variant : "silver",
		
	editor_deselector : "mceNoEditor",
	/*theme_advanced_disable : "styleselect,image,help",
	theme_advanced_disable : "formatselect,styleselect,image",*/
	relative_urls : false,
	convert_urls : false
});