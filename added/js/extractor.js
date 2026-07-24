$(document).ready(function(){
	var moduleid = $('#viewmoduleid').val();
	switch(moduleid){
		case 'extractor':
			retrieveExtractionData('');
			retrieveExtrationFilters();
		break;
	}//end switch case
});//action //activete extractor


$(document).on('click','.extrator-btn-extractdata',debounce(function(){
	var exfilter = $('.extractor-filter option:selected').val();
	executeExtraction(exfilter);
},300));

$(document).on('click','.extractor-loader',debounce(function(){
	var exfilter = $('.extractor-filter option:selected').val();
	retrieveExtractionData(exfilter);
},300));

function retrieveExtractionData(exfilter){
	$('.extraction-body').html('');
	$.get(domain+'/extractor/loadextractiondata',{exfilter:exfilter},function(data){
		data = $.parseJSON(data);
		plotExtractionData(data.extractiondata);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
	});
}//end function

function plotExtractionData(extractiondata){
	var strhtml = '';
	$.each(extractiondata, function(exindex, exname) {
        strhtml = strhtml.concat('<tr>');
        strhtml = strhtml.concat('<td class="aimslabel col-description">'+exname['tablet']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-min">'+exname['dateid']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-min">'+exname['postdate']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-codes">'+exname['ref']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-codes">'+exname['customercode']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-description">'+exname['customername']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-codes">'+exname['barcode']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-description">'+exname['itemname']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-min">'+exname['isqty']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-min">'+exname['uom']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-currency">'+exname['isamt']+'</td>');
        strhtml = strhtml.concat('<td class="aimslabel col-currency">'+exname['ext']+'</td>');
        strhtml = strhtml.concat('</tr>');
    });//end for each
    $('.extraction-body').html(strhtml);
}//end function plot Extraction data

function retrieveExtrationFilters(){
	var strhtml = '';
	$('.extractor-filter').html('');
	$.get(domain+'/extractor/loadextractionfilters',{},function(data){
		data = $.parseJSON(data);
		$.each(data.exfilters, function(exindex, exname) {
			strhtml = strhtml.concat('<option>'+exname['filter']+'</option>');
		});//end each
		$('.extractor-filter').html(strhtml);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
	});
}//end function 

function executeExtraction(filter){
	$.get(domain+'/extractor/extractdata',{exfilter:filter},function(data){
		data = $.parseJSON(data);
		if(data.status){
			var exfilter = $('.extractor-filter option:selected').val();
			generateAlert('information', "Extraction completed successfully!",'DEFAULT');
			retrieveExtractionData(exfilter);
		}else{
			generateAlert('error','An error occured while extracting data. Please try again.','ERROR');
		}//end status
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
	});
}//END FUNCTION EXECUTE EXTRACTION


$(document).on('click','.extractor-btn-clearout',debounce(function(){
	$('#modal-whlookup').modal();
	$('#modal-whlookup').zIndex(9999);
	$('#whlookuptype').val('EXTRACTOR_CLEAROUT');
},300));


function clearoutWHInventory(whid){
	$.get(domain+'/extractor/clearoutwh',{wh:whid},function(data){
		data = $.parseJSON(data);
		if(data.status){
			generateAlert('information',data.msg,'DEFAULT');
		}else{
			generateAlert('error',data.msg,'ERROR');
		}//end data status
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
	});
}//end function