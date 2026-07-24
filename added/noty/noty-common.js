//FUNCTION THAT GENERATES GLOBAL NOTIFICATION
function generateAlert(type, text,category) {
	var n;
	switch (category) { 
	case 'ERROR': 
	//ERROR ALERTS
	    n = noty({
	    text        : text,
	    type        : type, //information,warning,success,alert,confirm,error
	    dismissQueue: true,
	    layout      : 'center',
	    closeWith   : ['click'],
	    theme       : 'relax',
	    maxVisible  : 1,
	    modal : true,
	    killer: true,
	    animation   : { 
		    open  : 'animated flipInX',
		    close : 'animated flipOutX',
		    easing: 'swing',
		    speed : 50
	        },//END ANIMATION
	    });
		break;

	case 'ADDCART': 
	//ADD TO CART BUTTON ALERTS
	n = noty({
	    text        : text,
	    type        : type, //information,warning,success,alert,confirm,error
	    dismissQueue: true,
	    layout      : 'bottomLeft',
	    closeWith   : ['click'],
	    theme       : 'relax',
	    maxVisible  : 5,
	    modal : false,
	    animation   : { 
		    open  : 'animated bounceInLeft',
		    close : 'animated bounceOutLeft',
		    easing: 'swing',
		    speed : 50
	        },//END ANIMATION
	    timeout:2500,
	    });
		break;

	case 'ANNOUNCEMENT':
	//DEFAULT ALERTS (FOR MESSAGE ALERTS)
	n = noty({
	    text        : text,
	    type        : type, //information,warning,success,alert,confirm,error
	    dismissQueue: true,
	    layout      : 'topLeft',
	    closeWith   : ['click'],
	    theme       : 'relax',
	    maxVisible  : 10,
	    modal : false,
	    killer: false,
	    animation   : { 
		    open  : 'animated flipInX',
		    close : 'animated flipOutX',
		    easing: 'swing',
		    speed : 50
	        },//END ANIMATION
	    
	    });
	break;

	case 'REMINDER':
	//DEFAULT ALERTS (FOR MESSAGE ALERTS)
	n = noty({
	    text        : text,
	    type        : type, //information,warning,success,alert,confirm,error
	    dismissQueue: true,
	    layout      : 'bottomRight',
	    closeWith   : ['click'],
	    theme       : 'relax',
	    maxVisible  : 10,
	    modal : false,
	    killer: false,
	    animation   : { 
		    open  : 'animated flipInX',
		    close : 'animated flipOutX',
		    easing: 'swing',
		    speed : 50
	        },//END ANIMATION
	    
	    });
	break;

	case 'SUCCESS':
		n = noty({
		    text        : text,
		    type        : type, //information,warning,success,alert,confirm,error
		    dismissQueue: true,
		    layout      : 'center',
		    closeWith   : ['click'],
		    theme       : 'relax',
		    maxVisible  : 5,
		    modal : true,
		    killer: false,
		    animation   : { 
			    open  : 'animated flipInX',
			    close : 'animated flipOutX',
			    easing: 'swing',
			    speed : 50
		        },
		    timeout:1500
		    //END ANIMATION
		});
	break;

	default:
	//DEFAULT ALERTS (FOR MESSAGE ALERTS)
	n = noty({
	    text        : text,
	    type        : type, //information,warning,success,alert,confirm,error
	    dismissQueue: true,
	    layout      : 'center',
	    closeWith   : ['click'],
	    theme       : 'relax',
	    maxVisible  : 2,
	    modal : true,
	    killer: true,
	    animation   : { 
		    open  : 'animated flipInX',
		    close : 'animated flipOutX',
		    easing: 'swing',
		    speed : 50
	        },//END ANIMATION
	    timeout:1500,
	    });
	}//END CASE WHEN

    console.log('html: ' + n.options.id);
}//END GENERATE ALERT MESSAGES


//FUNCTION THAT GENERATES GLOBAL NOTIFICATION
function generateMsgbox(type, text,category,param) {	
	switch (category) {
	
	case 'EXTRACTOR_CLEAROUT':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-truck"></i> CLEAROUT TRUCK ', onClick: debounce(function ($noty) {
			    	clearoutWHInventory(param['whid']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVEMASTERITEM':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';
		var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
					$noty.close();
					deleteMasteritem(param);
			    },300)},{
			   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
			   		$noty.close();
			    }}]
		});
	break;
	
	case 'DELETEASSET': 
		//CONFIRMATION BOX
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
				deleteModuleData(param);
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
	break;

	case 'DELETE_SO_NOTE': 
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> DELETE ', onClick: debounce(function ($noty) {
			    	deleteSoNotes(param['trno'],param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'DELETE_FLASH': 
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE', onClick: debounce(function ($noty) {
					manageFlashDeals(param,'DELETE_FLASH_DEAL',function(data){
						generateAlert('information',data.msg,'DEFAULT');
						$('.fditems').html('');
						var params = {searchstring:''};
						manageFlashDeals(params,'RETRIEVE_FLASHDEAL_LIST',function(data){
							plotFlashDealList(data);
						});
					});
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'DELETE_FLASH_ITEM':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE', onClick: debounce(function ($noty) {
					manageFlashDeals(param,'DELETE_FLASH_DEAL_ITEM',function(data){
						generateAlert('information',data.msg,'DEFAULT');
						var params = {searchstring:''};
						$('.fditems').html('');
						manageFlashDeals(params,'RETRIEVE_FLASHDEAL_LIST',function(data){
							plotFlashDealList(data);
						});
					});
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'DOD_ITEM_REMOVE': 
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE ITEM', onClick: debounce(function ($noty) {
					removeDODItem(param['dod'],param['q']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;
	
	case 'DOD_REMOVE': 
	var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE DOD', onClick: debounce(function ($noty) {
					removeDOD(param['dod']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_CLASS':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE CLASS', onClick: debounce(function ($noty) {
					 removeclassitem(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_COLLECTION':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE COLLECTION', onClick: debounce(function ($noty) {
					 removecollection(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_DISTRIBUTION':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE DISTRIBUTION', onClick: debounce(function ($noty) {
					 removedistribution(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_ROUTE':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE ROUTE', onClick: debounce(function ($noty) {
					removeroute(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_SCTERRITORY':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE', onClick: debounce(function ($noty) {
					removeterritory(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_SCPROVINCE':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE', onClick: debounce(function ($noty) {
					removescprovince(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'CREATE_LEAVESETUP':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 1
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> OK', onClick: debounce(function ($noty) {
					loadleaveaccount();
					loadleaveemp();
					$('.btnnewleavesetup').hide();
					$('.btncancelleavesetup').show();
					$('.btnsaveleavesetup').show();
					
					$('#txtleaveentitled').prop('disabled',false);
					$('#txtleaveremarks').prop('disabled',false);

					$('#txtleaveacctwaw').val('');
					$('#txtleaveempwaw').val('');
					$('#txtleaveyearwaw').val('');
					$('#txtleavesetupyear').val('2017');
					$('#txtleaveyearwaw').val('2017');

					$('#modal-leavesetup-lookup').modal({backdrop:'static',keyboard:true});
					$('#btnleave1').click();
			    	$noty.close();
			    },100)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'CANCEL_LEAVESETUP':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> YES', onClick: debounce(function ($noty) {
					$('.btnnewleavesetup').show();
					$('.btncancelleavesetup').hide();
					$('.btnsaveleavesetup').hide();
					$('#leaveaccount').val('');
					$('#leaveemp').val('');

					$('#txtleaveremarks').prop('disabled',true);
					$('#txtleaveentitled').prop('disabled',true);

					$('.leavetxt').val('');


					$('.leavesetupdate1').show();
					$('.leavesetupdate').hide();

					$('#modal-leavesetup-lookup').modal('hide');
			    	$noty.close();
			    },100)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> NO', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;


	case 'CREATE_LEAVEAPP':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> YES', onClick: debounce(function ($noty) {
					$('.btnnewleaveapp').hide();
					
					$('#txtempcode').prop('disabled',false);
					$('.btnemplookup2').prop('disabled',false);
					$('.btnleaveappdocno').prop('disabled',false);

					$('.btnsaveleaveapp').show();
					$('.btncancelleaveapp').show();
					$('.txtleaveapp').val('');
					$('#leavetrno').val('');
					$('#leaverefno').val('');
					loadleavetrans();
					$('.btndeleteleaveapp').hide();
					setTimeout(function(){
						$('#txtempcode').focus();
					},300);
			    	$noty.close();
			    },100)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> NO', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'CANCEL_LEAVEAPP':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> YES', onClick: debounce(function ($noty) {
					$('.btncancelleaveapp').hide();
					$('.btndeleteleaveapp').hide();
					$('.btnnewleaveapp').show();
					$('.btnsaveleaveapp').hide();
					$('.txtleaveapp').val('');
					$('.txtleaveappdates1').show();
					$('.txtleaveappdates').hide();
					$('.txtleaveapp').prop('disabled',true);
					$('.btnemplookup2').prop('disabled',true);
					$('.btnleaveappdocno').prop('disabled',true);
					$('#leaverefno').val('');
					loadleavetrans();
			    	$noty.close();
			    },100)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> NO', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'CREATE_RATESETUP':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> YES', onClick: debounce(function ($noty) {
					$('.empratetxt').prop('disabled',false);
					$('.btnsaverate').show();
					$('#txtempcode').focus();
					$('.btnnewrate').hide();
					$('.btncancelrate').show();
					$('#txtempcode').prop('disabled',false);
					$('.btnemplookup2').prop('disabled',false);
					$('.rateeffect1').hide();
					$('.rateeffect').show();
					setTimeout(function(){$('#txtempcode').focus();},100);
			    	$noty.close();
			    },100)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> NO', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'CANCEL_RATESETUP':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> YES', onClick: debounce(function ($noty) {
					$('.empratetxt').prop('disabled',true);
					$('.btncancelrate').hide();
					$('.btnsaverate').hide();
					$('.btnnewrate').show();
					$('.rateeffect').hide();
					$('.rateeffect1').show();
					$('.txtrates').val('');
					$('#txtempcode').prop('disabled',true);
					$('.btnemplookup2').prop('disabled',true);
					$('.empratecontent').slideUp(300);
					$('.rateclassrate').text('');
			    	$noty.close();
			    },100)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> NO', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'CREATE_ALLOWSETUP':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> YES', onClick: debounce(function ($noty) {
					$('.btnnewallowsetup').hide();
					$('.btnsaveallowsetup').show();
					$('.btncancelallowsetup').show();
					$('.txtallowsetup').prop('disabled',false);
					$('#txtallowempname').prop('disabled',true);
					$('#txtalloweffect').prop('disabled',true);
					$('#txtallowto').prop('disabled',true);
					$('.btnemplookup2').prop('disabled',false);
					$('#txtempcode').focus();
					$('.txtalloweffectdate1').hide();
					$('.txtalloweffectdate').show();
					$('.txtallowtodate1').hide();
					$('.txtallowtodate').show();
			    	$noty.close();
			    },100)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> NO', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'CANCEL_ALLOWSETUP':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> YES', onClick: debounce(function ($noty) {
					$('.btncancelallowsetup').hide();
					$('.btnsaveallowsetup').hide();
					$('.btnnewallowsetup').show();
					$('.txtallowsetup').prop('disabled',true);
					$('.txtallowsetup').val('');
					$('#allowempcode').val('');
					$('#txtempcode').prop('disabled',true);
					$('.btnemplookup2').prop('disabled',true);
					$('.txtalloweffectdate1').show();
					$('.txtalloweffectdate').hide();
					$('.txtallowtodate1').show();
					$('.txtallowtodate').hide();
					loadallowsetup();
					$('.btnemplookup2').prop('disabled',true);
			    	$noty.close();
			    },100)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> NO', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_LEAVEAPP':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 1
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> OK', onClick: debounce(function ($noty) {
					removeleaveapp(param['line']);
			    	$noty.close();
			    },100)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_SCCITY':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE', onClick: debounce(function ($noty) {
					removesccity(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_CITY':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE CITY', onClick: debounce(function ($noty) {
					removecity(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_STOCKGRP':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE CITY', onClick: debounce(function ($noty) {
					removesgrp(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_COMMISSION':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE', onClick: debounce(function ($noty) {
					removecomm(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_COMMISSIONDETAIL':
		var maxvisib = 1;
		var opening = 'animated flipInX';
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE', onClick: debounce(function ($noty) {
					removecommdet(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_STATUS':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE', onClick: debounce(function ($noty) {
					removestatus(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'SAVE_GENTAB1':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-success', text: '<i class="fa fa-save"></i> SAVE', onClick: debounce(function ($noty) {
					savegentab1(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'SAVE_EMPREQ':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-success', text: '<i class="fa fa-save"></i> SAVE', onClick: debounce(function ($noty) {
					saveemprequirements(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'SAVE_GENTAB2':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-success', text: '<i class="fa fa-save"></i> SAVE', onClick: debounce(function ($noty) {
					savegentab2(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'SAVE_GENTAB3':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-success', text: '<i class="fa fa-save"></i> SAVE', onClick: debounce(function ($noty) {
					savegentab3(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_CLASS_MASTER':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE CLASS', onClick: debounce(function ($noty) {
					removeclassmaster(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_MODEL':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE MODEL', onClick: debounce(function ($noty) {
					removemodel(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_PROVINCE':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE PROVINCE', onClick: debounce(function ($noty) {
					removeprovince(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_PART':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE PART', onClick: debounce(function ($noty) {
					removepart(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_CUSTOMPRICE_ITEM':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE ITEM', onClick: debounce(function ($noty) {
					removecustomerpriceitem(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_EMPLOYEE':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE EMPLOYEE', onClick: debounce(function ($noty) {
					removeemployee(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;


	case 'REMOVE_CATEGORY':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE CATEGORY', onClick: debounce(function ($noty) {
					removecategories(param['line']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'REMOVE_HIGHLIGHT':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE HIGHLIGHT', onClick: debounce(function ($noty) {
					removeHighlight(param['highid']);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'FH_DELETE_SELECTED':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE ITEMS', onClick: debounce(function ($noty) {
					removeSelectedItemfromHighlight(param);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;
	case 'F_ENDSALE':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-unlink"></i> END SALE', onClick: debounce(function ($noty) {
					endSaleofSelectedItems();
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	case 'FBR_DELETEBRAND':
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';

			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-sm btn-danger', text: '<i class="fa fa-trash"></i> REMOVE BRAND', onClick: debounce(function ($noty) {
					removeFBRBrand(param);
			    	$noty.close();
			    },300)},{
				addClass: 'btn btn-sm btn-github', text: '<i class="fa fa-times"></i> CANCEL', onClick: function ($noty) {
			    	$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

/*	case 'FMANAGECAT': 
	//REMOVE ITEM
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';

		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-sm btn-success', text: 'TRANSFER', onClick: debounce(function ($noty) {
		    	$noty.close();
		    },300)},{
			addClass: 'btn btn-sm btn-warning', text: 'REMOVE', onClick: function ($noty) {
		    	$noty.close();
		    }},{
			addClass: 'btn btn-sm btn-github', text: 'CANCEL', onClick: function ($noty) {
		    	$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;*/
	
	case 'YULICKPOSTING':
		//CONFIRMATION BOX
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';
			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
					$noty.close();
					posting(param['trno']);
			    },300)},{
			   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
			   		$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;

	/*case 'FMANAGEUNGROUP': 
	//REMOVE ITEM
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';

		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-sm btn-danger', text: 'YES', onClick: debounce(function ($noty) {
		    	$noty.close();
		    },300)},{
			addClass: 'btn btn-sm btn-warning', text: 'NO', onClick: function ($noty) {
		    	$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;*/

	case 'CALENDAR_MOD': 
	if(param['updateready']){
		var buttons = [/*{
			addClass: 'btn btn-xs btn-success', text: 'COMMENT', onClick: debounce(function ($noty) {
				clickCommentEvent(param);
		    	$noty.close();
		    },300)},*/{
			addClass: 'btn btn-xs btn-success', text: 'UPDATE', onClick: debounce(function ($noty) {
				retrieveEventinfo(param);
		    	$noty.close();
		    },300)},{
			addClass: 'btn btn-xs btn-success', text: 'UNPIN', onClick: debounce(function ($noty) {
				clickUnpinEvent(param);
		    	$noty.close();
		    },300)},{
			addClass: 'btn btn-xs btn-danger', text: 'DELETE', onClick: debounce(function ($noty) {
				clickDeleteEvent(param);
		    	$noty.close();
		    },300)},{
			addClass: 'btn btn-xs btn-warning', text: 'CANCEL', onClick: function ($noty) {
		    	$noty.close();
		    }}];
	}else{
		var buttons = [/*{
			addClass: 'btn btn-xs btn-success', text: 'COMMENT', onClick: debounce(function ($noty) {
				clickCommentEvent(param);
		    	$noty.close();
		    },300)},*/{
			addClass: 'btn btn-xs btn-success', text: 'UPDATE', onClick: debounce(function ($noty) {
				retrieveEventinfo(param);
		    	$noty.close();
		    },300)},{
			addClass: 'btn btn-xs btn-warning', text: 'CANCEL', onClick: function ($noty) {
		    	$noty.close();
		    }}];
	}//end if

	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';

		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     :  buttons
	    });
	    console.log('html: ' + n.options.id);
		break;

	case 'CALENDAR_EVENT_DEL': 
	//REMOVE ITEM
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';

		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-sm btn-success', text: 'YES', onClick: debounce(function ($noty) {
				deleteEvent(param['seq']);
		    	$noty.close();
		    },300)},{
			addClass: 'btn btn-sm btn-danger', text: 'NO', onClick: function ($noty) {
		    	$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

	case 'CALENDAR_EVENT_UNPIN': 
	//REMOVE ITEM
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';

		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-sm btn-success', text: 'YES', onClick: debounce(function ($noty) {
				unpinEvent(param['seq']);
		    	$noty.close();
		    },300)},{
			addClass: 'btn btn-sm btn-danger', text: 'NO', onClick: function ($noty) {
		    	$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

	case 'CALENDAR_PENDING_PROP':
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';

		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [/*{
			addClass: 'btn btn-sm btn-success', text: 'COMMENT', onClick: debounce(function ($noty) {
				clickCommentEvent(param);
		    	$noty.close();
		    },300)},*/{
			addClass: 'btn btn-sm btn-success', text: 'DELETE', onClick: debounce(function ($noty) {
				clickDeleteEvent(param);
		    	$noty.close();
		    },300)},{
			addClass: 'btn btn-sm btn-danger', text: 'CANCEL', onClick: function ($noty) {
		    	$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

	case 'REMOVEBOX': 
	//REMOVE ITEM
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';

		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 100
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'Ok', onClick: debounce(function ($noty) {
		    	removeCartitem(param);
		    	$noty.close();
		    },300)},{
		    addClass: 'btn btn-danger', text: 'Cancel', onClick: function ($noty) {
		    	$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

	case 'NEW_ITEM': 
	//REMOVE ITEM
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';

		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 100
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				newItemdata(param['barcode'],1);
		    	$noty.close();
		    },300)},{
		    addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		    	newItemdata(param['barcode'],0);
		    	$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;


	case 'CLEARBOX': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 100
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-sm btn-success', text: 'YES', onClick: debounce(function ($noty) {
		    	clearCart();
		   		$noty.close();
		    },300)},{
		   	addClass: 'btn btn-sm btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

//USED ON AIMS FOR DELETING OF DOCUMENTS
	case 'DELETEDOC': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
				deleteModuleData(param);
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

case 'DELCOMPONENTSTOCK': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
				deleteItemstockcardUOM(param);
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;


//USED ON AIMS FOR DELETING OF DOCUMENTS
	case 'DELETEUOM': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
				deleteItemUOM(param);
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

case 'REMOVE_CHOICESMENU':
		var maxvisib = 1,
			opening = 'animated flipInX',
			closing = 'animated flipOutX',
			timeouting = false,
			loc = 'center',
			modalling = true,
			closeby = 'click',
			n = noty({
			    text        : text,
			    type        : type,
			    dismissQueue: true,
			    layout      : loc,
			    closeWith   : [closeby],
			    theme       : 'relax',
			    maxVisible  : maxvisib,
			    modal 		: modalling,
			    animation   : { 
				    open  : opening,
				    close : closing,
				    easing: 'swing',
				    speed : 50
			    },
			    timeout:timeouting,
				buttons     : [{
					addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
						$noty.close();
						deletechoicemenuitem(param['type'],param['line']);
				    },300)},{
				   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
				   		$noty.close();
				    }}]
		    });
	break;

	case 'REMOVE_ITEMIMG':
		var maxvisib = 1,
			opening = 'animated flipInX',
			closing = 'animated flipOutX',
			timeouting = false,
			loc = 'center',
			modalling = true,
			closeby = 'click',
			n = noty({
			    text        : text,
			    type        : type,
			    dismissQueue: true,
			    layout      : loc,
			    closeWith   : [closeby],
			    theme       : 'relax',
			    maxVisible  : maxvisib,
			    modal 		: modalling,
			    animation   : { 
				    open  : opening,
				    close : closing,
				    easing: 'swing',
				    speed : 50
			    },
			    timeout:timeouting,
				buttons     : [{
					addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
						$noty.close();
						deletemenuimg(param['itemid']);
				    },300)},{
				   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
				   		$noty.close();
				    }}]
		    });
	break;
	
//USED ON FRONTEND_LOGS
	case 'DELETE_FLOG': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
				deleteFrontendLogs(param['logid'],param['type']);
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

	case 'DELETEACCUSER': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
				deleteUserAccess(param['idno'],param['id']);
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

	case 'DELETEACCGRP': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
				deleteUserGrp(param['idno']);
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

//USED ON AIMS FOR DELETING OF CHART OF ACCOUNT ENTRIES
	case 'DELETECOA': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
				deleteContra(param);
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

//USED ON AIMS FOR REMOVAL OF ITEM FROM STOCK
	case 'REMOVESTOCK': 
		//CONFIRMATION BOX
		var maxvisib = 1;
		var opening = 'animated flipInX';		
		var closing = 'animated flipOutX';
		var timeouting = false;
		var loc = 'center';
		var	modalling = true;
		var closeby = 'click';
			var n = noty({
		    text        : text,
		    type        : type,
		    dismissQueue: true,
		    layout      : loc,
		    closeWith   : [closeby],
		    theme       : 'relax',
		    maxVisible  : maxvisib,
		    modal : modalling,
		    animation   : { 
			    open  : opening,
			    close : closing,
			    easing: 'swing',
			    speed : 50
		                  },
		    timeout:timeouting,
			buttons     : [{
				addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
					removeStockitem(param);
					$noty.close();
			    },300)},{
			   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
			   		$noty.close();
			    }}]
		    });
		    console.log('html: ' + n.options.id);
	break;	

	case 'SJ2QTY': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
				/*if(param['saveprocess'] == "ALL"){
		    		if(!$.isEmptyObject(param['stockarraydata_temp'])){
					saveStockpart(param['stockarraydata_temp']);
					}

					if(!$.isEmptyObject(param['stockarraydata_orig'])){
					saveStockpart(param['stockarraydata_orig']);
					}
				}else{
					saveStockpart(param['stockarraydata_orig']);
				}//end else*/
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		   		retainEncodedOrderQuantity(param['refx'],param['linex'],param['trno'],param['line'],param['isqty'],param['isqty2'],param['iss'],param['iss2']);
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;	


case 'REMOVEGENITEM': 
	//CONFIRMATION BOX
	
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
		    	removeGenitem(param);
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;
//USED ON AIMS FOR REMOVAL OF ITEM FROM STOCK
	case 'ITEMDOUBLED': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 100
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				$noty.close();
				$(this).prop('disabled',true);
				//DETERMINES WHAT WAY ITEM WAS ADDED (EDIT OR ADDED NEW)
		    	if(param['type'] == "edit"){
		    		replaceStockitem(param['line'],param['data'],param['qty']);
		    	}else{
		    		addStockitem(param['line'],param['data'],param['qty']);
		    	}//END PARAM TYPE

		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

case 'REFRESH': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 100
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
		    	saveAllStockitems();
		    	if($( ".module-btnheadcollapse" ).hasClass('stockedting')){
					$( ".module-btnheadcollapse" ).trigger( "click" );
				}
		    	ajaxSearchDoc(param['docno']);
		    	$noty.close();
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
		    	if($( ".module-btnheadcollapse" ).hasClass('stockedting')){
					$( ".module-btnheadcollapse" ).trigger( "click" );
				}
		   		ajaxSearchDoc(param['docno']);
		   		$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;

//USED ON AIMS , SHOWS WHEN THERE IS STILL DATA NEED TO BE SAVE ON HEAD OR STOCK (SHIFTING TRU HEAD OR STOCK)
	case 'SHIFTING': 
	//CONFIRMATION BOX
	var maxvisib = 1;
	var opening = 'animated flipInX';		
	var closing = 'animated flipOutX';
	var timeouting = false;
	var loc = 'center';
	var	modalling = true;
	var closeby = 'click';
		var n = noty({
	    text        : text,
	    type        : type,
	    dismissQueue: true,
	    layout      : loc,
	    closeWith   : [closeby],
	    theme       : 'relax',
	    maxVisible  : maxvisib,
	    modal : modalling,
	    animation   : { 
		    open  : opening,
		    close : closing,
		    easing: 'swing',
		    speed : 50
	                  },
	    timeout:timeouting,
		buttons     : [{
			addClass: 'btn btn-success', text: 'YES', onClick: debounce(function ($noty) {
				//DETERMINES SHITING 
				if(param['shiftfrom'] == "stock"){
					$( ".module-btnheadcollapse" ).trigger("click");
					saveAllStockitems();	
				}else{
					saveModulehead();
					$( ".module-btnheadcollapse" ).trigger("click");
				}//END SHIFTFROM
				$noty.close();
		    },300)},{
		   	addClass: 'btn btn-danger', text: 'NO', onClick: function ($noty) {
				//DETERMINES SHITING
				if(param['shiftfrom'] == "stock"){
					loadstockview(); 
					$( ".module-btnheadcollapse" ).trigger("click");
				}else{
					moduleHeadCancel();
					$( ".module-btnheadcollapse" ).trigger("click");
				}//END SHIFTFROM
				$noty.close();
		    }}]
	    });
	    console.log('html: ' + n.options.id);
		break;
	default:
	//GENERAL ALERTS			
	var maxvisib = 1;		
	var opening = 'animated bounceInLeft';
	var closing = 'animated bounceOutLeft';
	var timeouting = 500;
	var loc = 'center';		
	var	modalling = false;
	var closeby = 'click';
	}

}

//############################################### FOR ALERT MESSAGES ###########################################

function generateMessagebox(msg,msgtype,param){
    switch (msgtype) { 
		case 'CLEARBOX': 
		//ADD TO CART BUTTON ALERTS
		epic_icon = "fa-question";
		boxtype = "CLEARBOX"
			break;
		
		case 'REMOVE': 
		//ADD TO CART BUTTON ALERTS
		epic_icon = "fa-question";
		boxtype = "REMOVEBOX"
			break;

		case 'DELETECOA': case 'DELETEDOC': case 'REMOVESTOCK': case 'DELETEUOM': case 'DELETE_FLOG': case 'REMOVEGENITEM':
		case 'ITEMDOUBLED': case 'SHIFTING': case 'REFRESH': case 'DELETEACCUSER': case 'DELETEACCGRP':
		case 'CALENDAR_MOD': case 'CALENDAR_EVENT_DEL': case 'CALENDAR_EVENT_UNPIN': case 'NEW_ITEM': case 'CALENDAR_PENDING_PROP':
		case 'SJ2QTY': case 'FMANAGECAT': case 'FMANAGEUNGROUP': case 'YULICKPOSTING':
		case 'FBR_DELETEBRAND': case 'F_ENDSALE': case 'FH_DELETE_SELECTED': case 'REMOVE_HIGHLIGHT':
		case 'DOD_ITEM_REMOVE': case 'DOD_REMOVE': case 'REMOVE_CATEGORY': case'REMOVE_CLASS': case 'REMOVE_COLLECTION': case'REMOVE_DISTRIBUTION':
		case 'DELETE_FLASH': case 'DELETE_FLASH_ITEM': case 'DELETE_SO_NOTE': case 'REMOVE_ROUTE': case 'REMOVE_PROVINCE': case 'REMOVE_CUSTOMPRICE_ITEM':
		case 'REMOVE_MODEL': case 'REMOVE_CLASS_MASTER': case 'REMOVE_PART': case 'REMOVE_EMPLOYEE': case 'SAVE_GENTAB1': case 'SAVE_GENTAB3': case 'SAVE_EMPREQ': case 'SAVE_GENTAB2':
		case 'REMOVE_CITY': case 'REMOVE_STOCKGRP': case 'REMOVE_COMMISSION': case 'REMOVE_COMMISSIONDETAIL': case 'REMOVE_STATUS': case 'REMOVE_SCTERRITORY': case 'REMOVE_SCPROVINCE': case 'REMOVE_SCCITY':
		case 'CREATE_LEAVESETUP': case 'CANCEL_LEAVESETUP': case 'CREATE_LEAVEAPP': case 'REMOVE_LEAVEAPP': case 'CREATE_ALLOWSETUP': case 'CANCEL_LEAVEAPP':
		case 'CREATE_RATESETUP': case 'CANCEL_RATESETUP': case 'CANCEL_ALLOWSETUP': case 'EXTRACTOR_CLEAROUT': case 'DELETEASSET': case 'REMOVEMASTERITEM':
		case 'REMOVE_CHOICESMENU': case 'REMOVE_ITEMIMG':
		case 'DELCOMPONENTSTOCK':
		//ADD TO CART BUTTON ALERTS
			epic_icon = "";
			boxtype = msgtype;
		break;

		default:
		//GENERAL ALERTS			
		epic_icon = "fa-info";
		boxtype = "DEFAULTBOX"
		break;
	}//END SWITCH
    
    var notification = '<div class="activity-item"><i class="fa '+epic_icon+' text-success"></i><div class="activity"> '+msg+'</div></div>';
    generateMsgbox('alert', notification,boxtype,param);
}//END GENERATEMESSAGEBOX

//############################################### END FOR ALERT MESSAGES ###########################################


//FOR FRONT END FUNCTIONS
function generateAdditemnotif(cartcount,totalamt){
	var cartlink = ''+domain+'/frontend/mycart';
    var notification = '<div class="activity-item"> <i class="fa fa-shopping-cart text-success"></i> <div class="activity"> Item has been added to your <a href="'+cartlink+'">cart!</a><br>\
    <span style="color:black">No. of items in cart: <b>'+cartcount+'</b></span><br> \
    <span style="color:black">Total amount: <b>'+totalamt+'</b></span></div> </div>';
    generateAlert('success', notification,'ADDCART');
}//END GENERATEADDITEMNOTIF

function generateError(errormsg){
    var notification = '<div class="activity-item"> <i class="fa fa-times text-success"></i> <div class="activity"> '+errormsg+'</div> </div>';
    generateAlert('error', notification,'ERROR');
}//END GENERATEERROR
