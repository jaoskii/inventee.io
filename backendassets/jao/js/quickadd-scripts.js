//F0R QUICK ADD
$(document).on('click','.customerquickadd',function(){
	varstorage.data('quickaddclienttype','customer');
	$('#modal-clientquickadd').modal();
});

$(document).on('click','.quickclientsave',function(){
	var errcount = 0;
	$('.quickforms.qrequired').each(function(){
		if($(this).val() == ''){
			errcount += 1;
			$(this).css('border','solid 2px red');
		}//end function
	});//end for each

	if(errcount == 0){
		var formvalues = $(".quickforms.quickclient").serializeArray();
		formvalues.push({name:"quickaddtype",value:varstorage.data('quickaddclienttype')});
		quickAddClient(formvalues);
		$('.quickforms').val('');
		$('#modal-clientquickadd').modal('hide');
	}else{
		generateAlert('error','Please enter values on required fields.','ERROR');
	}//end if
});

function quickAddClient(formvalues){
	$('#overlay').css('display','block');
	$.ajax({type:"POST",url: domain + '/admin/quickaddclient',data:formvalues, success: function(data){
		data = $.parseJSON(data);
		$('#overlay').css('display','none');
		if(data.status){
			generateAlert('information','Customer sucessfully added through quickadd.','DEFAULT');
			getmoduleClientdata(data.searchid,varstorage.data('quickaddclienttype'));
			$('#modal-clientlookup').modal('hide');
		}else{
			generateAlert('error','Error adding Customer through quick add. Please try again.','ERROR');
		}//end if
		varstorage.removeData('quickaddclienttype');
	}}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
	});	//end ajax
}//end function