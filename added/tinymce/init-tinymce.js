//var modulemodals;

$(function(){
//initializes all functionalities of our RICH TEXT EDITOR
	initializeWigs();
});


function initializeWigs(){
	tinyMCE.init({
	  selector: 'textarea.wig',
	  height: 500,
	  resize: false,
	  theme: 'modern',
	  menubar:false,
	  plugins: [
	    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	    'searchreplace wordcount visualblocks visualchars code fullscreen',
	    'insertdatetime media nonbreaking save table contextmenu directionality',
	    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
	  ],
	  toolbar1: 'undo redo | table | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor emoticons | codesample',
	  
	  extended_valid_elements: 'img[class=myclass|!src|border:0|alt|title|width|height|style]',
	  invalid_elements: 'strong,b,em,i',
	  content_css: [
	    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
	     '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
	    '//www.tinymce.com/css/codepen.min.css'
	  ]
	});
}//end function


$(document).on('click','.wig-save',debounce(function(){
	var tinyval = tinyMCE.activeEditor.getContent();
	var moduleid = $('#viewmoduleid').val();
	var formvalues = new Array();
	
	switch(moduleid){
		case 'fsitedetails':
			var f = $('#updatefield').val();
			formvalues.push({name: "f", value:f});
			formvalues.push({name: "tinyval", value:tinyval});
		break;

		case 'wysiwyg':
			moduleid = 'stockcard';	
			var key = $('#key').val();
			var f = $('#updatefield').val();
			formvalues.push({name: "q", value:key});
			formvalues.push({name: "f", value:f});
			formvalues.push({name: "tinyval", value:tinyval});
		break;
	}//end switch


	$.ajax({type:"POST",url: domain+'/'+moduleid+'/updatedatawys',data:formvalues, success: function(data){
		data = $.parseJSON(data);
		if(data.status){
			generateAlert('information', "Data Updated!",'DEFAULT');
		}else{
			generateAlert('error','Error occured while updating. Please try again. [ERR_UP101]','ERROR');	
		}//end if
    }});
},300));