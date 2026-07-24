function initializeShortcuts(){
var moduleid = $('#viewmoduleid').val();

//NEW TRANSACTION
$(document).bind('keypress', 'shift+n',function (evt){
	evt.preventDefault();
	$('.module-btnnew').trigger('click');
});

//SAVE TRANSACTION
$(document).bind('keypress', 'shift+s',function (evt){
	evt.preventDefault();
	$('.module-btnsave').trigger('click');
});

//EDIT TRANSACTION
$(document).bind('keypress', 'shift+e',function (evt){
	evt.preventDefault();
	$('.module-btnedit').trigger('click');
});

//SHOW LOGS
$(document).bind('keypress', 'shift+l',function (evt){
	evt.preventDefault();
	$('.module-btnlogs').trigger('click');
});

//UNLOCK TRANSACTION
$(document).bind('keypress', 'shift+j',function (evt){
	evt.preventDefault();
	$('.module-btnlogs').trigger('click');
});

//LOCK TRANSACTION
$(document).bind('keypress', 'shift+k',function (evt){
	evt.preventDefault();
	$('.module-btnlogs').trigger('click');
});

//POST TRANSACTION
$(document).bind('keypress', 'shift+t',function (evt){
	evt.preventDefault();
	$('.module-btnlogs').trigger('click');
});

//UNPOST TRANSACTION
$(document).bind('keypress', 'shift+u',function (evt){
	evt.preventDefault();
	$('.module-btnlogs').trigger('click');
});




//ADD NEW ITEM ROW (BLANK)
$(document).bind('keypress', 'shift+a',function (evt){
	evt.preventDefault();
	stockview.enterGridviewEditingMode();
	var moduleid = $('#viewmoduleid').val(), tableid = '';
	if($('.module-btnsave').is(':visible') || $('.module-btnunpost').is(':visible') || $('.module-btnunlock').is(':visible')) {
		return;
	} else {
		switch(moduleid) {
			case 'SO': tableid = 'sostockview'; break;
		}//end switch

		var rowcount = stockview.getTemprowIndex();
		stockview.addNewRow(tableid,rowcount);
		switch(moduleid) {
			case 'SO':
				$('#sostockview tbody tr#gvrow-'+rowcount+'.temprow td input[coltype=barcode]').focus();
				$('#sostockview tbody tr#gvrow-'+rowcount+'.temprow .showbalance').css('display','none');
			break;
		}//end if lvl 2
	}//end if llvl 1
	loadautocomplete();
});

//SAVE ALL ITEMS (UNSAVED / EDITED)
$(document).bind('keypress', 'shift+q',function (evt){
	evt.preventDefault();
	alert('save all unsaved items');
});

//SAVE ITEM ROW (UNSAVED AND EDITED)
$(document).bind('keypress', 'shift+r',function (evt){
	evt.preventDefault();
	alert('save row of focused unsaved /edited items');
});

}//end function initialize

$(document).ready(function(){
	initializeShortcuts();
});