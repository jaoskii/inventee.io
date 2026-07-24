function getAutoEndingEntries(doc,q,asofdate,callback){
	$('#overlay').css('display','block');
	$.get(domain+'/'+doc+'/generateendingentries',{q:q,d:asofdate},function(data){
			$('#overlay').css('display','none');
			if(data.status){
				callback(data.entries);
			}else{
				generateAlert('error',data.msg,'ERROR');
			}//end if
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  	});
}//end function