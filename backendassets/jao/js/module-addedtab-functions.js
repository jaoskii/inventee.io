//THIS SET OF FUNCTIONS WAS CREATED WITH A PROTOTYPE STRUCTURE - JAO (AUG 22,2017)
//CONSTRUCTOR (HANDLES ALL PARAMETERS)
//INIT CONSTRUCTOR
function SJTabFunctions(tab_type){
	//PUT ADDITIONAL PROPERTIES HERE
	this.tabtype = tab_type;
	this.trno = '';
	this.updateparams = {};
}//End function

//PROTOTYPES (HANDLES FUNCTIONS AVAILABLE FOR THE CONSTRUCTOR)
SJTabFunctions.prototype = {
    constructor: SJTabFunctions,
    updateTabinfo:function(tabmodal){
       	this.trno = $('.txtboxtrno').val();
       	switch(this.tabtype){
       		case 'SC_RECEIVE':
				this.updateparams = {rdate:$('.txtreceivedateid').val(),
									rnotes:$('.txtreceivenotes').val(),
									q:this.trno,
									qc: $('.txtclientcode').val(),
									tabkey:this.tabtype};
       		break;

       		case 'SC_POSTDEV':
       			this.updateparams = {truck:$('.txtpostdevtruck').val(),
									shippingline:$('.txtpostdevshippingline').val(),
									destination:$('.txtpostdevdestination').val(),
									checkerdriver:$('.txtpostdevcheckerdriver').val(),
									receivedby:$('.txtpostdevreceivedby').val(),
									notes:$('.txtpostdevnotes').val(),
									q:this.trno,
									tabkey:this.tabtype};
       		break;

       		case 'SC_DISPATCHDISC':
       			this.updateparams = {dtype:$('.discrepancytype').val(),
									ddetails:$('.txtdispatchdiscdetails').val(),
									dnotes:$('.txtdispatchdiscnotes').val(),
									q:this.trno,
									tabkey:this.tabtype};
       		break;

       		case 'SC_DISPATCHCONFIRM':
       			this.updateparams = {ddate:$('.txtdconfirmationdateid').val(),
									dnotes:$('.txtdispatchconfirmationnotes').val(),
									q:this.trno,
									tabkey:this.tabtype};
       		break;

       		case 'SC_SETTLED':
       			this.updateparams = {sdate:$('.txtsettleddateid').val(),
									snotes:$('.txtsettlednotes').val(),
									q:this.trno,
									tabkey:this.tabtype};
       		break;
       	}//end switch

       	$.get(domain+'/SJ/updatetabs',this.updateparams,function(data){
			data = $.parseJSON(data);
			if(data.status){
				generateAlert('information',data.msg,'DEFAULT');
			}else{
				generateAlert('error',data.msg,'ERROR');
			}//end if
			$('#'+tabmodal).modal('hide');
		}).fail(function (jqXHR, textStatus, error) {
			generateAlert('error','[SJTB_ERR] System Error: Status Code ' +jqXHR.status,'ERROR');
		});
    },//end updateTabinfo


    openTabModals:function(tabmodal){
    	$('#'+tabmodal).modal();
    },//end openTabModals


    getTabinfo:function(){
    	this.trno = $('.txtboxtrno').val();
    	tabtype = this.tabtype;
    	$('.sjtabtxt').val('');
		$('#overlay').css('display','block');
		$('#overlay').css('z-index','9999');
        $.get(domain+'/SJ/gettabinfo',{q:this.trno,tabkey:this.tabtype},function(data){
        	$('#overlay').css('display','none');
			data = $.parseJSON(data);
			if(data.status){
				switch(tabtype){
					case 'SC_RECEIVE':
						$('.txtreceivedateid').val(data.details[0]['screceivedate']);
						$('.txtreceivenotes').val(data.details[0]['screceivenotes']);
					break;

					case 'SC_POSTDEV':
						$('.txtpostdevtruck').val(data.details[0]['sctruck']);
						$('.txtpostdevshippingline').val(data.details[0]['scshippingline']);
						$('.txtpostdevdestination').val(data.details[0]['scdestination']);
						$('.txtpostdevcheckerdriver').val(data.details[0]['sccheckerdriver']);
						$('.txtpostdevreceivedby').val(data.details[0]['screceivedby']);
						$('.txtpostdevnotes').val(data.details[0]['scpostdevnotes']);
		       		break;

		       		case 'SC_DISPATCHDISC':
		       			$('.discrepancytype').val(data.details[0]['scdiscrepancytype']);
						$('.txtdispatchdiscdetails').val(data.details[0]['scdiscrepancydetails']);
						$('.txtdispatchdiscnotes').val(data.details[0]['scdiscrepancynotes']);
		       		break;

		       		case 'SC_DISPATCHCONFIRM':
		       			$('.txtdconfirmationdateid').val(data.details[0]['scconfirmationdate']);
						$('.txtdispatchconfirmationnotes').val(data.details[0]['scconfirmationnotes']);
		       		break;

		       		case 'SC_SETTLED':
		       			$('.txtsettleddateid').val(data.details[0]['scsettleddate']);
						$('.txtsettlednotes').val(data.details[0]['scsettlednotes']);
		       		break;
				}//end switch
			}//end if
		}).fail(function (jqXHR, textStatus, error) {
			generateAlert('error','[SJTB_ERR] System Error: Status Code ' +jqXHR.status,'ERROR');
		});
    },//end getTabinfo

}//end function prototype sj tab functions

/// ############################### BUTTON EVENTS (RETRIEVE AND SHOW MODAL)
$(document).on('click','#screceivetab',debounce(function(){
	var tabmodal = $(this).attr('tabmodal');
	objmodel = new SJTabFunctions('SC_RECEIVE');
	objmodel.openTabModals(tabmodal);
	objmodel.getTabinfo();
},300));

$(document).on('click','#scpostdevtab',debounce(function(){
	var tabmodal = $(this).attr('tabmodal');
	objmodel = new SJTabFunctions('SC_POSTDEV');
	objmodel.openTabModals(tabmodal);
	objmodel.getTabinfo();
},300));

$(document).on('click','#scdispatchdisctab',debounce(function(){
	var tabmodal = $(this).attr('tabmodal');
	objmodel = new SJTabFunctions('SC_DISPATCHDISC');
	comboloader = new comboOptionLoader();
	objmodel.openTabModals(tabmodal);
	objmodel.getTabinfo();
	comboloader.loadAvailableDiscrepancyType();
	comboloader.loadAvailableUom();
},300));

$(document).on('click','#scdispatchconfirmationtab',debounce(function(){
	var tabmodal = $(this).attr('tabmodal');
	objmodel = new SJTabFunctions('SC_DISPATCHCONFIRM');
	objmodel.openTabModals(tabmodal);
	objmodel.getTabinfo();
},300));

$(document).on('click','#scsettledtab',debounce(function(){
	var tabmodal = $(this).attr('tabmodal');
	objmodel = new SJTabFunctions('SC_SETTLED');
	objmodel.openTabModals(tabmodal);
	objmodel.getTabinfo();
},300));


/// ############################ UPDATE BUTTON EVENTS (UPDATE AND CLOSE MODAL)
$(document).on('click','.scupdatereceivetab',debounce(function(){
	var tabmodal = $(this).attr('tabmodal');
	objmodel = new SJTabFunctions('SC_RECEIVE');
	objmodel.updateTabinfo(tabmodal);
},300));


$(document).on('click','.scupdatepostdeliverytab',debounce(function(){
	var tabmodal = $(this).attr('tabmodal');
	objmodel = new SJTabFunctions('SC_POSTDEV');
	objmodel.updateTabinfo(tabmodal);
},300));


$(document).on('click','.scupdatedispatchdiscrepancytab',debounce(function(){
	var tabmodal = $(this).attr('tabmodal');
	objmodel = new SJTabFunctions('SC_DISPATCHDISC');
	objmodel.updateTabinfo(tabmodal);
},300));


$(document).on('click','.scupdatedispatchconfirmation',debounce(function(){
	var tabmodal = $(this).attr('tabmodal');
	objmodel = new SJTabFunctions('SC_DISPATCHCONFIRM');
	objmodel.updateTabinfo(tabmodal);
},300));


$(document).on('click','.scupdatesettledtab',debounce(function(){
	var tabmodal = $(this).attr('tabmodal');
	objmodel = new SJTabFunctions('SC_SETTLED');
	objmodel.updateTabinfo(tabmodal);
},300));


