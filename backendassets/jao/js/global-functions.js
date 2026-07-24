//GLOBAL VARIABLES USED IN THE SYSTEM
var viewcostaccess = 1;
var confiaccess = 1;
var syslockdate;
var voidcolor = '#B22222';
var allowedstockaccess = {};
// THIS FILE CONTAINS ALL FUNCTIONS USED GLOBALLY ON AIMS
// THIS FILE IS STILL IN ONGOING TRANSFERRING - JAO

//############################################## FINISHED AND ALREADY USED FUNCTIONS ################################################

// WTODO JAD 05-28-2019
var availableTags = [];
$(document).on('ready', function () {
	var moduleid = $('#viewmoduleid').val();
	switch (moduleid) {
		case 'SO':
			$.ajax({
				type: 'post',
				url: domain + '/admin/loadavailableitems',
				success: function (data) {
					//data = $.parseJSON(data);
					$.each(data.data, function (index, waw) {
						availableTags.push(waw['barcode'] + '~' + waw['itemname']);
					});
				}
			});
			break;
	}
});

//PAGE ONLOAD ################################################
function loadstockview() {
	var x = $('.txtboxtrno').val(),
		stockdiv = "#modulestockview",
		isposted = $(stockdiv).attr('poststatus'),
		islocked = $(stockdiv).attr('lockedstatus'),
		isreadonly = false,
		moduleid = $('#viewmoduleid').val();

	if (isposted == 1 || islocked == 1) {
		isreadonly = true;
	} //end if

	if (x == '') {
		x = 0;
	}

	switch (moduleid) {
		case 'CK':
		case 'PO':
		case 'SO':
		case 'pscheme':
		case 'PS':
		case 'quotation':
		case 'TR':
			var isreadonly = false;
			$(stockdiv).addClass(moduleid).prop('checked', false);
			stockview = new GridViewGenerator(domain + '/' + moduleid + '/buildstockview', stockdiv);
			if (moduleid == 'CK') {
				dateid = $('.txtdateid').val();
				stockview.initializeGrid(dateid, isreadonly, [], true, function (data) {
					$(stockview.initdiv).html(data);
					checkifvoidPosted();
				});
			} else {
				stockview.initializeGrid(x, isreadonly, [], true, function (data) {
					$(stockview.initdiv).html(data);
					checkifvoidPosted();
				});
			}
			break;

		case 'changeitem':
			x = $('.txtchangeitemsearch').val();
			changeitemgrid = new GridViewGenerator(domain + '/' + moduleid + '/buildstockview', stockdiv);
			changeitemgrid.initializeGrid(x, isreadonly);
			break;

		case 'taxmenu':
			stockview = new GridViewGenerator(domain + '/' + moduleid + '/buildstockview', stockdiv);
			stockview.initializeGrid(x, isreadonly);
			break;

		default:
			$(stockdiv).addClass(moduleid).prop('checked', false);
			stockview = new GridViewGenerator(domain + '/' + moduleid + '/buildstockview', stockdiv);


			if (moduleid == 'tpshipping' || moduleid == 'tphandling') {
				var addedparams = [];
				addedparams.push({
					name: "date1",
					value: ''
				});
				addedparams.push({
					name: "date2",
					value: ''
				});
				stockview.initializeGrid(x, isreadonly, addedparams);
			} else {
				stockview.initializeGrid(x, isreadonly, [], true, function (data) { //FEED TYPE FORMAT
					$(stockdiv).html(data);
					enableCheckboxValues(stockdiv);
					if (isreadonly) {
						stockview.disabledGridviewEditing(true);
					} //end if
				});

				//stockview.initializeGrid(x,isreadonly); //NON-FEED TYPE FORMAT
			} //end if
			break;
	} //end switch

	$('.dpYears').datepicker();
	$('.dpMonths').datepicker();
} //end f

function loadtables() {
	var moduleid = $('#viewmoduleid').val();
	tablesgrid = new GridViewGenerator(domain + '/' + moduleid + '/loadtables', '.tablesdiv');
	tablesgrid.initializeGrid('', false, [], true, function (data) {
		$('.tablesdiv').html(data);
		checkinactivetables();
	});
} //END FUNCT


function loadprincipalgrid() {
	var moduleid = $('#viewmoduleid').val();
	stockview = new GridViewGenerator(domain + '/' + moduleid + '/buildstockview', '.principaldiv');
	stockview.initializeGrid('');
}

function loadcollectiontypes() {
	var moduleid = $('#viewmoduleid').val();
	masterfilegrid = new GridViewGenerator(domain + '/' + moduleid + '/loadcolltypes', '.colltypegrid');
	masterfilegrid.initializeGrid();
}

function loadcostcenters() {
	var moduleid = $('#viewmoduleid').val();
	costcentergrid = new GridViewGenerator(domain + '/' + moduleid + '/loadcostcenters', '.costcenterdiv');
	costcentergrid.initializeGrid();
}

function loadtermsgrid() {
	var moduleid = $('#viewmoduleid').val();
	stockview = new GridViewGenerator(domain + '/' + moduleid + '/buildstockview', '.termsdiv');
	stockview.initializeGrid();
}

function loadewtlistgrid() {
	var moduleid = $('#viewmoduleid').val();
	stockview = new GridViewGenerator(domain + '/' + moduleid + '/buildstockview', '.ewtdiv');
	stockview.initializeGrid();
}

function loadpricehistorygrid(dateclicked) {
	var addedparams = [];
	addedparams.push({
		name: "clickdate",
		value: dateclicked
	});
	stockview = new GridViewGenerator(domain + '/admin/getitempriceupdates', '.priceupdatesdiv');
	stockview.initializeGrid(null, null, addedparams);
}

function loadnotifgrid() {
	var moduleid = $('#viewmoduleid').val();
	notifgrid1 = new GridViewGenerator(domain + '/' + moduleid + '/loadnotifgrid1', '.notifdiv1');
	notifgrid1.initializeGrid();
}


function loadposlistsgrid() {
	var moduleid = $('#viewmoduleid').val();

	poslistsgrid = new GridViewGenerator(domain + '/' + moduleid + '/loadposlistsgrid1', '.poslists');
	poslistsgrid.initializeGrid();
} //end f


function loaddocprefix() {
	var moduleid = $('#viewmoduleid').val();
	stockview = new GridViewGenerator(domain + '/' + moduleid + '/loaddocprefix', '.docprefixdiv');
	stockview.initializeGrid();
} //end f

function loadmasterfilegrid() {
	var moduleid = $('#viewmoduleid').val(),
		mastergrid = '#masterfilegrid';
	masterfilegrid = new GridViewGenerator(domain + '/' + moduleid + '/buildmasterfilegrid', mastergrid);
	masterfilegrid.initializeGrid('', false);
} //end f

function loadequiptoolgrid() {
	var moduleid = $('#viewmoduleid').val(),
		equiptoolgrid = '#equiptoolgrid';
	equiptoolgrid = new GridViewGenerator(domain + '/' + moduleid + '/buildequiptoolgrid', equiptoolgrid);
	equiptoolgrid.initializeGrid('', false);
} //end f


function generateIndexpageLineChart(callback) {
	$.get(domain + '/admin/monthlyrecap', {}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end function

function generateIndexpageSJList(callback) {
	$.get(domain + '/admin/listopsj', {}, function (data) {
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end function


function generatechangeItemamtdates(callback) {
	$.get(domain + '/admin/getpriceupdatedates', {}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end function


$(document).on('click', '.btnviewitemupdates', debounce(function () {
	$('#modal-showitemamtupdates').modal();
	loadpricehistorygrid($(this).text());
}, 300));

function generateIndexPageTransCounting(callback) {
	$.get(domain + '/admin/counttrans', {}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	}); //end $.get
} //end function


$(document).ready(function () {

	varstorage.data('universe-changedexpiry', false);

	$('.dpYears').datepicker();
	$('.dpMonths').datepicker();
	requestCompanyConfig(function (data) {
		cconfig = data.cconfig;
		var moduleid = $('#viewmoduleid').val();
		//var quote = new quotationConstructor('waims');
		//quote.setDefaultModules();
		switch (cconfig) {
			case 'UNIVERSE':
				enterqtysize = 'med';
				break;

			default:
				enterqtysize = 'min';
				break;
		} //end switch

		switch (cconfig) {
			case 'PANDATOOLS':
				$('.viewcopyclipboard').css('display', 'block');
				break;

			default:
				$('.viewcopyclipboard').css('display', 'none');
				break;
		} //end switch

		var initparam = checkforInitialParameters(); //STILL ON BETA PHASE ######################################################
		setInterval(TickClock, 1000);
		getScreenDimensions();

		checkConfidentialAccess(function (data) {
			confiaccess = data.confiaccess;
		});

		requestDecimalDisplay(function (data) {
			qtydecimal = data.qtydecimal;
			amtdecimal = data.amtdecimal;
		});

		if (typeof moduleid === "undefined" || moduleid === null) {
			console.log('Error moduleid');
		} else {
			requestSystemLockdate(function (data) {
				syslockdate = data.syslockdate;
			});
		} //end if

		requestEditableEntryLimiter(function (data) {
			maxeditables = data.limiter;
		});

		processWatermarks(); //ENABLES WATER MARKED IMAGES

		// ============= FUNCTION FOR modal-pick HEAD TITLE ============= //
		switch (moduleid) {
			case 'SJ':
				var headtitle = 'Pick SO';
				break;
			case 'RR':
				var headtitle = 'Pick PO';
				break;
			case 'DM':
				var headtitle = 'Pick RR';
				break;
			case 'CM':
				var headtitle = 'Pick SJ';
				break;
			case 'PO':
				var headtitle = 'Pick RR';
				break;
			case 'customer':
				var headtitle = 'Pending Orders';
				break;

			default:
				var headtitle = '';
				break;
		} //end switch 
		// ============================================================== //

		switch (moduleid) {
			case 'manageitem':
				var modalclasslookup = 'Category';
				var modalbrandlookup = 'Major Category';
				var modalmodellookup = 'Printer';
				var modalgrouplookup = 'Groupings';
				break;

			case 'stockcard':
				switch (cconfig) {
					case 'UNIVERSE':
						var modalclasslookup = 'Classifications';
						var modalbrandlookup = 'Brand';
						var modalmodellookup = 'Generic';
						var modalgrouplookup = 'Divisions';

						var modalpartlookup = 'Category';
						var modalbodylookup = 'Form';
						var modalsizelookup = 'Bin';
						break;


					default:
						var modalclasslookup = 'Class';
						var modalbrandlookup = 'Brand';
						var modalmodellookup = 'Model';
						var modalgrouplookup = 'Groups';

						var modalpartlookup = 'Part';
						var modalbodylookup = 'Body';
						var modalsizelookup = 'Sizes';
						break;
				} //end switch
				break;

			default:
				switch (cconfig) {
					case 'UNIVERSE':
						var modalclasslookup = 'Classifications';
						var modalbrandlookup = 'Brand';
						var modalmodellookup = 'Generic';
						var modalgrouplookup = 'Divisions';

						var modalpartlookup = 'Category';
						var modalbodylookup = 'Form';
						var modalsizelookup = 'Bin';
						break;


					default:
						var modalclasslookup = 'Class';
						var modalbrandlookup = 'Brand';
						var modalmodellookup = 'Model';
						var modalgrouplookup = 'Groups';

						var modalpartlookup = 'Part';
						var modalbodylookup = 'Body';
						var modalsizelookup = 'Sizes';
						break;
				} //end switch
				break;
		} //end swtich


		switch (cconfig) {
			case 'UNIVERSE':
				switch (moduleid) {
					case 'RR':
					case 'PO':
						var viewpricechangebtn = {
							'btnclass': 'itemviewpricechange btn-warning btn-xs',
							'label': '<i class="fa fa-refresh"></i> Price Changes'
						};
						break;

					default:
						var viewpricechangebtn = '';
						break;
				} //end switch
				break;

			default:
				var viewpricechangebtn = '';
				break;
		} //end switch

		//INITILIZE MODALS
		modulemodals = new modalConstructor({ // modal-copyclipboard
				'modal-copyclipboard': {
					'size': 'max',
					'bodyclass': 'copyclipboarddiv',
					'footerbtns': [{
						'closemodal': false,
						'label': '<i class="fa fa-copy"></i> Copy to Clipboard',
						'btnclass': 'copyclipbtn btn-primary'
					}]
				} //end if
			}, { // modal-fg_colors
				'modal-fg_colors': {
					'size': 'med',
					'headtitle': 'Color Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Color',
						'txtclass': 'txtsearchfgcolor'
					}],
					'bodyclass': 'fg_colorsbody',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-fg_material
				'modal-fg_material': {
					'size': 'med',
					'headtitle': 'Material Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Material',
						'txtclass': 'txtsearchfgmaterial'
					}],
					'bodyclass': 'fg_materialbody',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-fg_cylinder
				'modal-fg_cylinder': {
					'size': 'med',
					'headtitle': 'Cylinder Lookup',
					'modaltype': 'lookup',
					'bodyclass': 'fg_cylinderbody',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-fg_process
				'modal-fg_process': {
					'size': 'med',
					'headtitle': 'Process Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Process',
						'txtclass': 'txtsearchfgprocess'
					}],
					'bodyclass': 'fg_processbody',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-progressbar
				'modal-progressbar': {
					'size': 'max',
					'modaltype': 'html',
					'htmlcontent': '<h6 class="progress-msg" style="margin:0;">Please wait...</h6><br>\
									<div class="progress progress-striped active" style="margin-bottom:0;">\
									<div id="progressbar-load" class="progress-bar" style="width: 50%"></div>\
									</div>',
					'data_backdrop': 'static',
					'data_keyboard': 'false',
					'addedstyles': 'padding-top:15%;overflow-y:visible;',
				}
			}, { // modal-ewtlookup
				'modal-ewtlookup': {
					'size': 'med',
					'headtitle': 'Choose EWT',
					'modaltype': 'lookup',
					'bodyclass': 'ewtlookuptbl',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}],
				}
			}, { // modal-loclookup
				'modal-loclookup': {
					'size': 'max',
					'headtitle': 'Choose Location',
					'modaltype': 'lookup',
					'bodyclass': 'loclookuptbl',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}],
				}
			}, { // modal-whlookup
				'modal-whlookup': {
					'size': 'max',
					'headtitle': 'Choose Warehouse',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Warehouse',
						'txtclass': 'txtsearchwh'
					}],
					'bodyclass': 'whlookuptbl',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}],
				}
			}, { // modal-showclientstats
				'modal-showclientstats': {
					'size': 'min',
					'headtitle': 'Stats',
					'modaltype': 'txtlookup',
					'modalcontent': [
						// {'type':'label','value':'SELECT YEAR:'},
						{
							'type': 'a',
							'label': 'Select Year:',
							'inputclass': 'setstatview clickable pull-right',
							'value': '<label class="aimslabel">SHOW ANNUAL</label>'
						},
						{
							'type': 'select',
							'inputclass': 'statyear form-control'
						},
						{
							'type': 'hidden',
							'inputid': 'statview',
							'value': 'MONTHLY'
						},
						{
							'type': 'divonly',
							'divclass': 'tbl-showclientstats'
						},
						{
							'type': 'label',
							'value': '',
							'inputclass': 'stats_gtotal'
						}
					],
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-uomlookup
				'modal-uomlookup': {
					'size': 'max',
					'headtitle': 'Pick your UOM',
					'modaltype': 'lookup',
					'bodyclass': 'uomlookuptbl',
					'footerbtns': [{
							'closemodal': true,
							'label': 'Close',
							'btnclass': 'btn-github'
						},
						{
							'btnclass': 'btn-twitter uomformnew',
							'label': 'Add new UOM'
						}
					]
				}
			}, {
				'modal-principal': {
					'size': 'max',
					'headtitle': 'Principal Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Principal',
						'txtclass': 'txtsearchprincipal'
					}],
					'bodyclass': 'principallookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, {
				'modal-uvcategory': {
					'size': 'min',
					'headtitle': 'Category',
					'bodyclass': 'uvcategorylookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, {
				'modal-prodtype': {
					'size': 'max',
					'headtitle': 'Product Type',
					'bodyclass': 'prodtypelookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
				//[KIM][2019.09.17][modal-material]
			}, {
				'modal-material': {
					'size': 'max',
					'headtitle': 'Material',
					'bodyclass': 'materiallookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-uomprint 
				'modal-uomprint': {
					'size': 'min',
					'headtitle': 'Pick Print Uom',
					'bodyclass': 'uomprintlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-itemlookup
				'modal-itemlookup': {
					'size': 'max',
					'headtitle': 'Search desired Item',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search desired item',
						'txtclass': 'txtsearchitem'
					}],
					'bodyclass': 'itemlookuptbl',
					'footerLabels': [
						{
							'label': '<b>Customer Price Group:</b>',
							'labelClass': 'itemlookup-customer-pricegrp',
							'valueClass': 'itemlookup-customer-pricegrp-val'
						}
					],
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { //[KIM][2019.11.11][modal-fgitemlookup]
				'modal-fgitemlookup': {
					'size': 'max',
					'headtitle': 'Search Desired Item',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Desired item',
						'txtclass': 'txtsearchfgitem'
					}],
					'bodyclass': 'fgitemlookuptbl',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-clientlookup
				'modal-clientlookup': {
					'size': 'max',
					'headtitle': 'Search Customer',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Customer',
						'txtclass': 'txtsearchcustomer'
					}],
					'bodyclass': 'cutomerlookup',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}, {
						'closemodal': false,
						'label': 'Quick Add Customer',
						'btnclass': 'customerquickadd pull-left btn-success'
					}]
				}
			}, { // modal-tablelookup
				'modal-tablelookup': {
					'size': 'max',
					'headtitle': 'Choose Table',
					'modaltype': 'lookup',
					'bodyclass': 'tablemasterlookuptbl',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}],
				}
			}, { // modal-reminders
				'modal-reminders': {
					'size': 'max',
					'headtitle': 'Manage Reminders',
					'modaltype': 'lookup',
					'bodyclass': 'remindersdiv',
					'footerbtns': [{
						'btnclass': 'btn-success btnnewreminder',
						'label': 'Add Reminder'
					}, {
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-schedlist
				'modal-schedlist': {
					'size': 'med',
					'headtitle': 'Schedules',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Scheduler',
						'txtclass': 'txtsearchsched'
					}],
					'bodyclass': 'schedlistdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'OK',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-agentlookup
				'modal-agentlookup': {
					'size': 'max',
					'headtitle': 'Search Agent',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Agent',
						'txtclass': 'txtsearchagent'
					}],
					'bodyclass': 'agentlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-agentpickerlookup
				'modal-agentpickerlookup': {
					'size': 'max',
					'headtitle': 'Search Agent Picker',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Agent Picker',
						'txtclass': 'txtsearchagent'
					}],
					'bodyclass': 'pickerlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-agentcheckerlookup
				'modal-agentcheckerlookup': {
					'size': 'max',
					'headtitle': 'Search Agent Checker',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Agent Checker',
						'txtclass': 'txtsearchagent'
					}],
					'bodyclass': 'checkerlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-showterms
				'modal-showterms': {
					'size': 'min',
					'headtitle': 'Terms',
					'modaltype': 'lookup',
					'bodyclass': 'termstbl',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-docnolookup
				'modal-docnolookup': {
					'size': 'max',
					'headtitle': 'Document Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Document',
						'txtclass': 'txtsearchdocno'
					}],
					'bodyclass': 'docnolookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-contra
				'modal-contra': {
					'size': 'max',
					'headtitle': 'Accounts',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Account',
						'txtclass': 'txtsearchcontra'
					}],
					'bodyclass': 'accountlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-alias
				'modal-alias': {
					'size': 'med',
					'headtitle': 'Aliases',
					'bodyclass': 'aliaslookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-part 
				'modal-part': {
					'size': 'min',
					'headtitle': modalpartlookup,
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Part',
						'txtclass': 'txtsearchpart'
					}],
					'bodyclass': 'partlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-model
				'modal-model': {
					'size': 'min',
					'headtitle': modalmodellookup,
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Model',
						'txtclass': 'txtsearchmodel'
					}],
					'bodyclass': 'modellookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-class
				'modal-class': {
					'size': 'max',
					'headtitle': modalclasslookup,
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Class',
						'txtclass': 'txtsearchclass'
					}],
					'bodyclass': 'classlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { //[KIM][2019.10.29][modal-loc]
				'modal-loc': {
					'size': 'min',
					'headtitle': 'Location',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Location',
						'txtclass': 'txtsearchloc'
					}],
					'bodyclass': 'loclookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, {
				'modal-jobno': {
					'size': 'min',
					'headtitle': 'J.O. No',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search JO No',
						'txtclass': 'txtsearchjobno'
					}],
					'bodyclass': 'jobnolookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-brand
				'modal-brand': {
					'size': 'min',
					'headtitle': modalbrandlookup,
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Brand',
						'txtclass': 'txtsearchbrand'
					}],
					'bodyclass': 'brandlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-clientgroup // [JLY][2019.08.17][KINGG CONCERNS][ADD GROUP FILTER]
				'modal-clientgroup': {
					'size': 'min',
					'headtitle': 'Client Group',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Brand',
						'txtclass': 'txtsearchclientgroup'
					}],
					'bodyclass': 'clientgrouplookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-body 
				'modal-body': {
					'size': 'min',
					'headtitle': modalbodylookup,
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Body',
						'txtclass': 'txtsearchbody'
					}],
					'bodyclass': 'bodylookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-size 
				'modal-size': {
					'size': 'min',
					'headtitle': modalsizelookup,
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Size',
						'txtclass': 'txtsearchsize'
					}],
					'bodyclass': 'sizelookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-category 
				'modal-category': {
					'size': 'min',
					'headtitle': 'Category',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Category',
						'txtclass': 'txtsearchcategory'
					}],
					'bodyclass': 'categorylookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-priority
				'modal-priority': {
					'size': 'min',
					'headtitle': 'Priority',
					'bodyclass': 'prioritylookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-department
				'modal-department': {
					'size': 'min',
					'headtitle': 'Department',
					'bodyclass': 'departmentlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-suppitemcode
				'modal-suppitemcode': {
					'size': 'min',
					'headtitle': 'Supplier Item Code',
					'bodyclass': 'suppitemcodelookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-group 
				'modal-group': {
					'size': 'min',
					'headtitle': modalgrouplookup,
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Group',
						'txtclass': 'txtsearchgroup'
					}],
					'bodyclass': 'grouplookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-collectionarea
				'modal-collectionarea': {
					'size': 'min',
					'headtitle': 'Collection Lookup',
					'bodyclass': 'collectionareadiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-distributionarea
				'modal-distributionarea': {
					'size': 'min',
					'headtitle': 'Distribution Lookup',
					'bodyclass': 'distributionareadiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-area
				'modal-area': {
					'size': 'min',
					'headtitle': 'Area',
					'bodyclass': 'arealookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-province
				'modal-province': {
					'size': 'min',
					'headtitle': 'Province',
					'bodyclass': 'provincelookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-region
				'modal-region': {
					'size': 'min',
					'headtitle': 'Region',
					'bodyclass': 'regionlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-supplier
				'modal-supplier': {
					'size': 'max',
					'headtitle': 'Supplier Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Supplier',
						'txtclass': 'txtsearchsupp'
					}],
					'bodyclass': 'supplookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-unpaid
				'modal-unpaid': {
					'size': 'max',
					'headtitle': 'Pick Unpaid',
					'modaltype': 'searchlookup',
					'searchfilters': [{
							'type': 'text',
							'placeholder': 'Unpaid Accounts',
							'txtclass': 'txtunpaidsearchlookup'
						},
						{
							'type': 'lookup',
							'placeholder': 'Search Customer',
							'txtclass': 'reptxt customerfilter txtclientcodeunpaid',
							'aclass': 'unpaidclientlookup'
						}
					],
					'bodyclass': 'unpaidlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}, {
						'btnclass': 'btn-twitter theunpaidtaker',
						'label': 'Retrieve'
					}]
				}
			}, { // modal-pick
				'modal-pick': {
					'size': 'max',
					'headtitle': headtitle,
					'modaltype': 'searchlookup',
					'searchfilters': [{
							'type': 'select',
							'txtclass': 'pickup-po-format',
							'width': '3',
							'values': [{
								'val': 'Summarized Format',
								'value': 'summary'
							}, {
								'val': 'Detailed Format',
								'value': 'detail'
							}]
						},
						{
							'type': 'text',
							'placeholder': 'Search Orders',
							'txtclass': 'txtorderitemslookup',
							'width': '9'
						}
					],
					'bodyclass': 'pickpo',
					'footerbtns': [{
						'btnclass': 'btn-success theorderbutton',
						'label': 'Retrieve Orders'
					}, {
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-success'
					}]
				}
			}, { // modal-users
				'modal-users': {
					'size': 'min',
					'headtitle': 'Users',
					'modaltype': 'lookup',
					'bodyclass': 'usersdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'OK',
						'btnclass': 'btn-success'
					}]
				}
			}, { // modal-route
				'modal-route': {
					'size': 'min',
					'headtitle': 'Route',
					'modaltype': 'lookup',
					'bodyclass': 'routediv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'OK',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-checks
				'modal-checks': {
					'size': 'max',
					'headtitle': 'Pick Checks',
					'modaltype': 'lookup',
					'bodyclass': 'checkslookup',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}, {
						'btnclass': 'btn-twitter thechecktaker',
						'label': 'Ok'
					}]
				}
			}, { // modal-pdcchecks
				'modal-pdcchecks': {
					'size': 'max',
					'headtitle': 'Post Dated Checks',
					'modaltype': 'lookup',
					'bodyclass': 'pdctbl',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}, {
						'btnclass': 'btn-twitter thepdcchecktaker',
						'label': 'Ok'
					}]
				}
			}, { // modal-taxmenu
				'modal-taxmenu': {
					'size': 'max',
					'headtitle': 'Tax Menu Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Tax Menu',
						'txtclass': 'txtsearchtaxmenu'
					}],
					'bodyclass': 'taxmenulookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-expiry
				'modal-expiry': {
					'size': 'max',
					'headtitle': 'Choose Expiry',
					'modaltype': 'lookup',
					'bodyclass': 'expirylookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-newpass
				'modal-newpass': {
					'size': 'min',
					'headtitle': 'Change Password',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Old Password:</b>'
					}, {
						'type': 'password',
						'inputclass': 'txtoldpass'
					}, {
						'type': 'labelfull',
						'value': '<b>New Password:</b>'
					}, {
						'type': 'password',
						'inputclass': 'txtnewpass'
					}, {
						'type': 'labelfull',
						'value': '<b>Retype New Password</b>'
					}, {
						'type': 'password',
						'inputclass': 'txtretypenew'
					}],
					'footerbtns': [{
						'btnclass': 'btnchangepass btn-success',
						'label': 'OK'
					}, {
						'closemodal': true,
						'label': 'Cancel',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-quickadd
				'modal-quickadd': {
					'size': 'min',
					'headtitle': '<span class="quickaddtitle">Quick Add Items</span>',
					'modaltype': 'txtlookup',
					'bodyclass': 'quickadddiv',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Enter Barcode:</b>'
					}, {
						'type': 'textwithicon',
						'inputclass': 'txtquickadd',
						'icontype': 'fa-search'
					}, {
						'type': 'label',
						'style': 'text-align:center;color:red;display:none;',
						'value': '<b>Invalid Barcode! Please try again!</b>',
						'divclass': 'quickadderr'
					}]
				}
			}, { // modal-quickadditem 
				'modal-quickadditem': {
					'size': 'min',
					'headtitle': 'Quick Qty',
					'modaltype': 'txtlookup',
					'bodyclass': 'quickadditemdiv',
					'modalcontent': [{
							'type': 'labelfull',
							'value': '<b>Enter Qty:</b>'
						}, {
							'type': 'text',
							'inputclass': 'txtquickadditem',
							'icontype': 'fa-search'
						},
						{
							'type': 'labelfull',
							'value': '<b>Enter Amount:</b>'
						}, {
							'type': 'text',
							'inputclass': 'txtamountitem',
							'icontype': 'fa-search'
						},
						{
							'type': 'label',
							'style': 'text-align:center;color:red;display:none;',
							'value': '<b>No Value ! Please try again!</b>',
							'divclass': 'quickadditemerr'
						}, {
							'type': 'hidden',
							'inputid': 'quickadditembarcode',
							'value': ''
						}
					]
				}
			}, { // modal-logs
				'modal-logs': {
					'size': 'max',
					'headtitle': 'Modules Logs',
					'modaltype': 'lookup',
					'bodyclass': 'modulelogsdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'OK',
						'btnclass': 'btn-success'
					}]
				}
			}, { // modal-announcements
				'modal-announcements': {
					'size': 'max',
					'headtitle': 'Manage Announcements',
					'modaltype': 'lookup',
					'bodyclass': 'announcementsdiv',
					'footerbtns': [{
						'btnclass': 'btnaddanon btn-success',
						'label': 'Add Announcement'
					}, {
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-showacctg
				'modal-showacctg': {
					'size': 'max',
					'headtitle': 'Accounting Distribution',
					'modaltype': 'lookup',
					'bodyclass': 'tbl-acctg',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, {
				//MADE NEW MODAL
				'modal-showdisc': {
					'size': 'min',
					'headtitle': 'Enter Discount',
					'modaltype': 'txtlookup',
					'modalcontent': [{
							'label': 'New Discount:',
							'type': 'text',
							'inputclass': 'newdisc'
						}

					],
					'footerbtns': [{
						'btnclass': 'discplotbtn btn-success btn-xs',
						'label': 'OK'
					}]
				}
			}, { // modal-changebarcode
				'modal-changebarcode': {
					'size': 'min',
					'headtitle': 'Change Item Barcode',
					'modaltype': 'txtlookup',
					'modalcontent': [{
							'type': 'label',
							'value': 'Enter New Barcode:'
						},
						{
							'type': 'text',
							'inputname': 'barcode',
							'inputclass': 'txtchangebarcode'
						}
					],
					'footerbtns': [{
						'btnclass': 'btnchangebarcode btn-success',
						'label': 'Change Barcode'
					}, {
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // components_lookup
				'modal-components': {
					'size': 'max',
					'headtitle': 'Components Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Components',
						'txtclass': 'txtsearchcomponents'
					}],
					'bodyclass': 'itemcomponentsgrid',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}, {
						'btnclass': 'btn-twitter btnaddcomponentitem',
						'label': 'Add Components'
					}]
				}
			}, { // modal-sonotes
				'modal-sonotes': {
					'size': 'min',
					'headtitle': 'Add SO Notes',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'text',
						'label': 'Station:',
						'inputclass': 'sonoteform',
						'inputname': 'sonotestation'
					}, {
						'type': 'text',
						'label': 'Serial #:',
						'inputclass': 'sonoteform',
						'inputname': 'sonoteserial'
					}, {
						'type': 'text',
						'label': 'Remarks:',
						'inputclass': 'sonoteform',
						'inputname': 'sonoteremarks'
					}, {
						'type': 'text',
						'label': 'Others:',
						'inputclass': 'sonoteform',
						'inputname': 'sonoteothers'
					}],
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}, {
						'btnid': 'add-new-sonote',
						'btnclass': 'btn-success',
						'label': 'Add Note'
					}]
				}
			}, { // modal-showacctg
				'modal-last10trans': {
					'size': 'max',
					'headtitle': 'Show Last 20 Transactions',
					'modaltype': 'lookup',
					'bodyclass': 'tbl-last10trans',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-entercoa
				'modal-entercoa': {
					'size': 'min',
					'headtitle': 'Account',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'text',
						'label': 'Post/CheckDate:',
						'inputclass': 'coapostdate'
					}, {
						'type': 'hidden',
						'inputclass': 'coaacnoid'
					}, {
						'type': 'hidden',
						'inputclass': 'coaacno'
					}, {
						'type': 'text',
						'label': 'Acnoname:',
						'inputclass': 'coaacnoname',
						'readonly': true
					}, {
						'type': 'text',
						'label': 'Debit:',
						'inputclass': 'coadb'
					}, {
						'type': 'text',
						'label': 'Credit:',
						'inputclass': 'coacr'
					}, {
						'type': 'text',
						'label': 'Check #:',
						'inputclass': 'coacheckno',
						'divclass': 'coarowcheckno'
					}, {
						'type': 'hidden',
						'inputclass': 'coaclienttxt'
					}, {
						'type': 'lookup',
						'label': 'Cstmr/Supplr:',
						'inputclass': 'coaclientnametxt',
						'btnclass': 'coaclientlookup'
					}, {
						'type': 'textarea',
						'label': 'Notes:',
						'inputclass': 'coanotes'
					}, {
						'type': 'text',
						'label': 'Reference:',
						'inputclass': 'coareference'
					}],
					'footerbtns': [{
						'btnclass': 'coaplotbtn btn-success',
						'label': 'Add Account'
					}]
				}
			}, { // modal-adminpass
				'modal-adminpass': {
					'size': 'min',
					'headtitle': 'Administrator Password',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'hidden',
						'inputclass': 'txtadministrator-line'
					}, {
						'type': 'hidden',
						'inputclass': 'txtadministrator-trno'
					}, {
						'type': 'hidden',
						'inputclass': 'txtadministrator-void'
					}, {
						'type': 'hidden',
						'inputclass': 'txtadministrator-voidstyle'
					}, {
						'type': 'select',
						'label': 'Select User:',
						'inputclass': 'pincode-userlist'
					}, {
						'type': 'password',
						'label': 'Input Administrator Password',
						'inputclass': 'txtadministrator-pin'
					}],
					'footerbtns': [{
						'closemodal': true,
						'label': 'Cancel',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-multivoid
				'modal-multivoid': {
					'size': 'max',
					'headtitle': 'Void Multiple Orders',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Items on this Document',
						'txtclass': 'txtmultiplevoidsearch'
					}],
					'bodyclass': 'multivoidtbl',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}, {
						'btnclass': 'btn-success thevoidtaker',
						'label': 'Void Selected Items'
					}]
				}
			}, { // modal-enterqty
				'modal-enterqty': {
					'size': enterqtysize,
					'headtitle': 'Enter Qty',
					'modaltype': 'txtlookup',
					'modalcontent': [{
							'label': 'Barcode:',
							'type': 'label',
							'inputclass': 'qtybarcode'
						}, {
							'label': 'Itemname:',
							'type': 'label',
							'inputclass': 'qtyitemname'
						}, {
							'label': 'Qty:',
							'type': 'text',
							'inputclass': 'enterqtytxt enteredqty autocomputenet',
							'divclass': 'lblqty'
						}, {
							'type': 'hidden',
							'inputclass': 'qtyitemid'
						}, {
							'type': 'hidden',
							'inputclass': 'qtyeditid'
						}, {
							'label': 'Price:',
							'type': 'text',
							'inputclass': 'enterqtytxt qtyitemamt autocomputenet'
						}, {
							'label': 'Discount:',
							'type': 'text',
							'inputclass': 'enterqtytxt qtydisc autocomputenet',
							'divclass': 'discountrow'
						}, {
							'label': 'Net:',
							'type': 'text',
							'inputclass': 'txtNet',
							'divclass': 'netclass hidden'
						},
						//
						{
							'label': 'Warehouse:',
							'type': 'lookup',
							'inputclass': 'txtwarehouseitem',
							'btnclass': 'whlookupitem',
							'divclass': 'itemqtywh'
						}, {
							'type': 'divonly',
							'divclass': 'location-qtydisplay',
							'label': 'Location:',
							'childdiv': 'locationrow'
						}, {
							'type': 'divonly',
							'divclass': 'location2-qtydisplay',
							'style': 'display:none;',
							'label': 'Location 2:',
							'childdiv': 'location2row'
						}, {
							'type': 'divonly',
							'divclass': 'expiry-qtydisplay',
							'label': 'Expiry:',
							'childdiv': 'expiryrow'
						}, {
							'label': 'Notes:',
							'type': 'text',
							'inputclass': 'enterqtytxt txtNotes',
							'divclass': 'notesclass hidden'
						}, {
							'type': 'lookup',
							'label': 'UOM:',
							'inputclass': 'selectuompopup',
							'btnclass': 'uomlookups'
						}, {
							'label': 'Selected UOM Factor:',
							'type': 'label',
							'inputclass': 'qtyfactor'
						}, {
							'type': 'hidden',
							'inputid': 'hiddenitemrem'
						}, {
							'type': 'divonly',
							'divclass': 'expirytbl_enterqty',
							'label': 'Available Expiries',
							'childdiv': 'expirytbl'
						}, {
							'label': 'Latest SPC:',
							'type': 'label',
							'inputclass': 'qtyspc'
						}
					],
					'footerbtns': [viewpricechangebtn, {
						'btnclass': 'itemshowbalance itmqty-showbalance btn-github btn-xs',
						'label': '<i class="fa fa-eye"></i> Show Stock'
					}, {
						'btnclass': 'itemplotbtn btn-success btn-xs',
						'label': '<i class="fa fa-sign-in"></i> OK'
					}]
				}
			}, { // modal-showattachment
				'modal-showattachment': {
					'size': 'max',
					'headtitle': 'View Attachment',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'img',
						'style': 'width:870px;height:520px;',
						'inputclass': 'thumbnail attachframe'
					}],
					'footerbtns': [{
							'closemodal': false,
							'label': 'Set as Blank Image',
							'btnclass': 'imgremover btn-danger'
						},
						{
							'closemodal': true,
							'label': 'Close',
							'btnclass': 'btn-github'
						}
					]
				}
			}, { // modal-showbalance
				'modal-showbalance': {
					'size': 'max',
					'headtitle': 'Item Balance',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'label',
						'inputclass': 'showbalanceuomlabel',
						'value': 'View by:',
					}, {
						'type': 'lookup',
						'inputclass': 'showbal-viewuom form-control input-sm',
						'btnclass': 'btnshowbal-viewbyuom'
					}, {
						'type': 'blankrow',
					}, {
						'type': 'divonly',
						'divclass': 'showbalancetbl',
					}, {
						'type': 'label',
						'inputclass': 'showbalance-totalitembal'
					}, {
						'type': 'label',
						'inputclass': 'unpostedpobal'
					}, {
						'type': 'label',
						'inputclass': 'postedpobal'
					}, {
						'type': 'label',
						'inputclass': 'unpostedsobal'
					}, {
						'type': 'label',
						'inputclass': 'postedsobal'
					}],
				}
			}, { // modal-lockdate
				'modal-lockdate': {
					'size': 'min',
					'headtitle': 'Set-up Lockdate',
					'modaltype': 'txtlookup',
					'modalcontent': [{
							'type': 'labelfull',
							'value': 'Date:'
						},
						{
							'type': 'date',
							'inputclass': 'txtbackdate'
						}
					],
					'footerbtns': [{
						'btnclass': 'btnupdatelockdate btn-success',
						'label': 'Update'
					}, {
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-costcenter
				'modal-costcenter': {
					'size': 'med',
					'headtitle': 'Choose Cost Center',
					'modaltype': 'lookup',
					'bodyclass': 'costcenterdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-centers
				'modal-centers': {
					'size': 'min',
					'headtitle': 'Centers',
					'modaltype': 'lookup',
					'bodyclass': 'centersdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'OK',
						'btnclass': 'btn-success'
					}]
				}
			}, { // modal-sample
				'modal-sample': {
					'size': 'min',
					'headtitle': 'sample',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'label': 'input1',
						'type': 'text',
						'inputclass': 'txtsample txtinput1 form-control input-sm',
					}, {
						'label': 'input2',
						'type': 'select',
						'inputclass': 'txtsample txtinput2 form-control input-sm',
					}, {
						'label': '',
						'type': 'date',
						'inputclass': 'txtsample txtdate form-control input-sm',
					}, {
						'label': 'sample lookup',
						'type': 'lookup',
						'inputclass': 'txtsamplelookup form-control input-sm',
						'btnclass': 'btnsamplelookup'
					}, {
						'label': '',
						'type': 'hidden',
						'inputclass': 'txthidden',
						'inputid': 'hupaws'
					}],
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-clientquickadd
				'modal-clientquickadd': {
					'size': 'min',
					'headtitle': 'Quickadd Masterfiles',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Name:</b>'
					}, {
						'type': 'text',
						'inputclass': 'quickforms qrequired quickclient quickname',
						'inputname': 'quickname'
					}, {
						'type': 'labelfull',
						'value': '<b>Address:</b>'
					}, {
						'type': 'textarea',
						'inputclass': 'quickforms quickclient quickaddress',
						'inputname': 'quickaddress'
					}, {
						'type': 'labelfull',
						'value': '<b>Mobile #</b>'
					}, {
						'type': 'text',
						'inputclass': 'quickforms quickclient quickmobile',
						'inputname': 'quickmobile'
					}, {
						'type': 'labelfull',
						'value': '<b>Email</b>'
					}, {
						'type': 'text',
						'inputclass': 'quickforms quickclient quickemail',
						'inputname': 'quickemail'
					}],
					'footerbtns': [{
						'btnclass': 'quickclientsave btn-success',
						'label': 'Save'
					}, {
						'closemodal': true,
						'label': 'Cancel',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-setendingdate
				'modal-setendingdate': {
					'size': 'min',
					'headtitle': 'Set As Closing Entry Date',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Ending Date:</b>'
					}, {
						'type': 'date',
						'inputclass': 'endingdateasof',
						'inputname': 'endingdateasof'
					}],
					'footerbtns': [{
						'btnclass': 'getendingentries btn-success',
						'label': 'Generate'
					}, {
						'closemodal': true,
						'label': 'Cancel',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-actnotes
				'modal-actnotes': {
					'size': 'med',
					'headtitle': 'Add Activity Notes',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Activity Note:</b>'
					}, {
						'type': 'text',
						'inputname': 'actnote',
						'inputclass': 'actnote',
						'inputid': 'actnote'
					}],
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}, {
						'btnid': 'add-new-activitynote',
						'btnclass': 'btn-success',
						'label': 'Add Note'
					}]
				}
			}, { // modal-quickadds
				'modal-quickadds': {
					'size': 'min',
					'headtitle': 'Quick Add',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'hidden',
						'inputclass': 'quickaddstype'
					}, {
						'type': 'label',
						'inputclass': 'quickaddlabel'
					}, {
						'type': 'text',
						'inputclass': 'txtquickadds'
					}],
					'footerbtns': [{
						'btnclass': 'btnsavequickadds btn-success',
						'label': 'Save'
					}, {
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-colltypelookup
				'modal-colltypelookup': {
					'size': 'max',
					'headtitle': 'Collection Type',
					'bodyclass': 'colltypelookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-showitemamtupdates
				'modal-showitemamtupdates': {
					'size': 'max',
					'headtitle': 'Price Update History',
					'modaltype': 'lookup',
					'bodyclass': 'priceupdatesdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-progressbar
				'modal-dash-explinegraph': {
					'size': 'max',
					'headtitle': 'Expense Chart',
					'modaltype': 'html',
					'htmlcontent': '<div class="chart">\
							        <div style="width: 800px;padding: 4px;margin: 20px;">\
							        <canvas id="expnsChart" style="height: 250px;"></canvas>\
							        </div>\
							        </div>',
				}
			}, { // modal-progressbar
				'modal-dash-collectlinegraph': {
					'size': 'max',
					'headtitle': 'Collection Chart',
					'modaltype': 'html',
					'htmlcontent': '<div class="chart">\
							          <div style="width: 800px;padding: 4px;margin: 20px;">\
							             <canvas id="slsChart" style="height: 250px;"></canvas>\
							          </div>\
							        </div>',
				}
			}, { // modal-showacctg
				'modal-dashrecentsj': {
					'size': 'max',
					'headtitle': 'Recent SJ Transactions',
					'modaltype': 'lookup',
					'bodyclass': 'tbl-recentsjtrans',
					'footerbtns': [{
						'closemodal': true,
						'label': 'View All Invoices',
						'btnclass': 'btnviewsj btn-github'
					}]
				}
			}, {
				'modal-details': {
					'size': 'max',
					'headtitle': 'Account Details',
					'modaltype': 'html',
					'htmlcontent': '<p class="coa-datefilter"></p><p class="coa-acc-details"></p>\
									<div class="box box-solid accountdetailslookupdiv"></div>',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-showacctg
				'modal-copyso': {
					'size': 'max',
					'headtitle': 'Pending / Unserved SO',
					'modaltype': 'lookup',
					'bodyclass': 'tbl-copylistso',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-approvedreimbursements
				'modal-approvedreimbursements': {
					'size': 'max',
					'headtitle': 'Approved Reimbursements',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'date',
						'placeholder': 'From',
						'txtclass': 'txtappreimbfrom'
					}, {
						'type': 'date',
						'placeholder': 'To',
						'txtclass': 'txtappreimbto'
					}, {
						'type': 'button',
						'placeholder': 'View',
						'icon': 'fa fa-eye',
						'txtclass': 'btnviewappreimb btn btn-success btn-flat'
					}, {
						'type': 'select',
						'txtclass': 'cbxapproved',
						'width': '3',
						'values': [{
							'val': 'Unapproved',
							'value': 'unapproved'
						}, {
							'val': 'Approved',
							'value': 'approved'
						}]
					}, ],
					'bodyclass': 'appreimbdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // WTODO JAD 06-03-2019 
				'modal-eventprojectlookup': {
					'size': 'max',
					'headtitle': 'Search Project',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Project',
						'txtclass': 'txtsearcheventproject'
					}],
					'bodyclass': 'eventprojectlookup',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-createevent
				'modal-createevent': {
					'size': 'med',
					'headtitle': 'Create Event',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Enter Schedule Desc:</b>'
					}, {
						'type': 'hidden',
						'inputid': 'sched_seq',
						'inputclass': 'sched_seq schedtxt'
					}, {
						'type': 'hidden',
						'inputid': 'event-type',
						'inputclass': 'event-type schedtxt'
					}, {
						'type': 'text',
						'inputid': 'new-event',
						'inputclass': 'new-event schedtxt'
					}, {
						'type': 'labelfull',
						'value': '<b>Select Customer:</b>'
					}, {
						'type': 'lookup',
						'inputclass': 'calendarclientcode1 schedtxt',
						'btnclass': 'calendarclientlookup1'
					}, {
						'type': 'labelfull',
						'value': '<b>Time:</b>'
					}, {
						'type': 'timepicker',
						'inputclass': 'event-txttime schedtxt',
						'inputid': 'txttime'
					}, {
						'type': 'labelfull',
						'childdiv': 'tagsched',
						'value': '<b>Tag Schedule as:</b>'
					}, {
						'type': 'select',
						'inputclass': 'schedtagging form-control'
					}, {
						'type': 'labelfull',
						'value': '<b>Tag to project:</b>'
					}, {
						'type': 'hidden',
						'inputid': 'projectidtag',
						'inputclass': 'projectidtag schedtxt'
					}, {
						'type': 'lookup',
						'inputclass': 'projectnametag schedtxt',
						'btnclass': 'projectlookup'
					}, {
						'type': 'labelfull',
						'value': '<b>Location:</b>'
					}, {
						'type': 'text',
						'inputid': 'event-loc',
						'inputclass': 'event-loc schedtxt'
					}, {
						'type': 'labelfull',
						'value': '<b>Schedule Type:</b>'
					}, {
						'type': 'select',
						'inputclass': 'txtreporttypeevent form-control'
					}, {
						'type': 'labelfull',
						'value': '<b>JO #:</b>'
					}, {
						'type': 'text',
						'inputid': 'event-jo',
						'inputclass': 'event-jo schedtxt'
					}, {
						'type': 'textarea',
						'inputid': 'event-rem',
						'inputclass': 'event-rem schedtxt',
						'style': 'display:none;'
					}, {
						'type': 'labelfull',
						'value': '<b>Amount:</b>'
					}, {
						'type': 'text',
						'inputid': 'event-amt',
						'inputclass': 'event-amt schedtxt'
					}, {
						'type': 'labelfull',
						'value': '<b>Notes:</b>',
						'childdiv': 'eventnotes'
					}, {
						'type': 'a',
						'inputclass': 'clickable btncalendar-viewnotes'
					}],
					'footerbtns': [{
						'btnclass': 'event-updatebtn btn-success',
						'label': 'Update'
					}, {
						'btnclass': 'btn-success add-new-event',
						'btnid': 'add-new-event',
						'label': 'Add Event'
					}, {
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-jbuinput
				'modal-jbuinput': {
					'size': 'min',
					'headtitle': 'Add new Input',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Input Code:</b>',
						'childdiv': ''
					}, {
						'type': 'lookup',
						'inputclass': 'jbu_inputtxt jbu_inputcode',
						'inputname': 'jbu_inputcode',
						'btnclass': 'jbuinputlookup'
					}, {
						'type': 'labelfull',
						'value': '<b>Rolls:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_inputtxt jbu_inputrolls',
						'inputname': 'jbu_inputrolls'
					}, {
						'type': 'labelfull',
						'value': '<b>KGS:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_inputtxt jbu_inputkgs',
						'inputname': 'jbu_inputkgs'
					}, {
						'type': 'labelfull',
						'value': '<b>Meter:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_inputtxt jbu_inputmeter',
						'inputname': 'jbu_inputmeter'
					}, {
						'type': 'labelfull',
						'value': '<b>PCS:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_inputtxt jbu_inputpcs',
						'inputname': 'jbu_inputpcs'
					}],
					'footerbtns': [{
							'btnclass': 'jbu_inputinsert btn-success',
							'label': 'Insert'
						},
						{
							'closemodal': true,
							'label': 'Cancel',
							'btnclass': 'btn-github'
						},
						{
							'btnclass': 'jbuinputcomputepcs pull-left btn-success',
							'label': 'Compute PCS'
						}
					]
				}
			}, { // modal-jbuinput
				'modal-jbuoutput': {
					'size': 'min',
					'headtitle': 'Add new Output',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Output Code:</b>',
						'childdiv': ''
					}, {
						'type': 'lookup',
						'inputclass': 'jbu_outputtxt jbu_inputcode',
						'inputname': 'jbu_outputcode',
						'btnclass': 'jbuoutputlookup'
					}, {
						'type': 'labelfull',
						'value': '<b>Rolls:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_outputtxt jbu_outputrolls',
						'inputname': 'jbu_outputrolls'
					}, {
						'type': 'labelfull',
						'value': '<b>KGS:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_outputtxt jbu_outputkgs',
						'inputname': 'jbu_outputkgs'
					}, {
						'type': 'labelfull',
						'value': '<b>Meter:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_outputtxt jbu_outputmeter',
						'inputname': 'jbu_outputmeter'
					}, {
						'type': 'labelfull',
						'value': '<b>PCS:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_outputtxt jbu_outputpcs',
						'inputname': 'jbu_outputpcs'
					}],
					'footerbtns': [{
							'btnclass': 'jbu_outputinsert btn-success',
							'label': 'Insert'
						},
						{
							'closemodal': true,
							'label': 'Cancel',
							'btnclass': 'btn-github'
						},
						{
							'btnclass': 'jbuoutputcomputepcs pull-left btn-success',
							'label': 'Compute PCS'
						}
					]
				}
			}, { // modal-inputlookup
				'modal-jbuinputlookup': {
					'size': 'max',
					'headtitle': 'Input / Output Lookup',
					'bodyclass': 'jbuinputlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-inputlookup
				'modal-jbuoutputlookup': {
					'size': 'max',
					'headtitle': 'Output',
					'bodyclass': 'jbuoutputlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-showbalance
				'modal-showpricechange': {
					'size': 'max',
					'headtitle': 'Item Price Change',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'divonly',
						'divclass': 'showpricechangetbl',
					}],
				}
			}, { // modal-jbuinput
				'modal-twenter': {
					'size': 'min',
					'headtitle': 'Tax Menu Details',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Tax Name:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'twinput twtaxname',
						'inputname': 'taxname',
						'readonly': 'true'
					}, {
						'type': 'labelfull',
						'value': '<b>ATC:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'twinput twtaxatc',
						'inputname': 'taxatc',
						'readonly': 'true'
					}, {
						'type': 'labelfull',
						'value': '<b>Rate:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'twinput twtaxrate',
						'inputname': 'taxrate'
					}, {
						'type': 'labelfull',
						'value': '<b>Income:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'twinput twincome',
						'placeholder': '0.00',
						'inputname': 'taxincome'
					}, {
						'type': 'labelfull',
						'value': '<b>Tax Withheld:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'twinput twtaxwithheld',
						'placeholder': '0.00',
						'inputname': 'taxwithheld',
						'readonly': 'true'
					}, {
						'type': 'labelfull',
						'childdiv': 'tagsched',
						'value': '<b>Month:</b>'
					}, {
						'type': 'select',
						'inputid': 'twtaxmonth',
						'inputclass': 'twtaxmonth form-control input-sm',
					}, {
						'type': 'hidden',
						'inputid': 'twtaxline',
						'value': '',
						'inputclass': 'twinput twtaxline',
					}],
					'footerbtns': [{
						'btnclass': 'twtaxmenuinsert btn-success',
						'label': 'Save'
					}, {
						'closemodal': true,
						'label': 'Cancel',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-showacctg
				'modal-serveddocs': {
					'size': 'med',
					'headtitle': 'Served Documents',
					'modaltype': 'lookup',
					'bodyclass': 'tbl-serveddocs',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-showacctg
				'modal-fgprodtypelookup': {
					'size': 'med',
					'headtitle': 'Product Type Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Product Type',
						'txtclass': 'txtsearchfgprodtype'
					}],
					'bodyclass': 'tbl-producttypelookup',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-showacctg
				'modal-fgplasticcolorlookup': {
					'size': 'med',
					'headtitle': 'Plastic Color Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Plastic Color',
						'txtclass': 'txtsearchfgplasticcolor'
					}],
					'bodyclass': 'tbl-plasticcolorlookup',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-showacctg
				'modal-fgsealinglookup': {
					'size': 'med',
					'headtitle': 'Sealing Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Sealing',
						'txtclass': 'txtsearchsealing'
					}],
					'bodyclass': 'tbl-sealinglookup',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-showacctg
				'modal-fgtransformationlookup': {
					'size': 'med',
					'headtitle': 'Transformation Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Sealing',
						'txtclass': 'txtsearchtransform'
					}],
					'bodyclass': 'tbl-fgtransformationlookup',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { //[KIM][2019.10.31][add modal-fgaddspecslookup]
				'modal-fgaddspecslookup': {
					'size': 'med',
					'headtitle': 'Additional Specs Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Additional Specs',
						'txtclass': 'txtsearchaddspecs'
					}],
					'bodyclass': 'tbl-fgaddspecslookup',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-inputlookup
				'modal-joborderlookup': {
					'size': 'max',
					'headtitle': 'Job Order Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Plastic Color',
						'txtclass': 'txtsearchjonums'
					}],
					'bodyclass': 'joborderlookuptbl',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-adminpass
				'modal-mlcpstocknotes': {
					'size': 'max',
					'headtitle': 'View Stock Notes',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'textarea',
						'inputrows': 15,
						'inputcols': 5,
						'inputclass': 'txtmlcpstocknotes'
					}, {
						'type': 'hidden',
						'inputclass': 'txtmlcpstockline'
					}],
					'footerbtns': [{
							'closemodal': true,
							'label': 'Update Stock Notes',
							'btnclass': 'mlcpupdatestocknotes btn-success'
						},
						{
							'closemodal': true,
							'label': 'Cancel',
							'btnclass': 'btn-github'
						}
					]
				}
			}, { // modal-docnolookup
				'modal-sv_docnolookup': {
					'size': 'max',
					'headtitle': 'RR Document Lookup',
					'modaltype': 'searchlookup',
					'searchfilters': [{
						'type': 'text',
						'placeholder': 'Search Document',
						'txtclass': 'txtsearchsvrr'
					}],
					'bodyclass': 'svrrdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-docnolookup
				'modal-sv_docnolist': {
					'size': 'med',
					'headtitle': 'Linked Documents',
					'modaltype': 'lookup',
					'bodyclass': 'svdocumentsdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-jbuinput
				'modal-jbureject': {
					'size': 'min',
					'headtitle': 'Add new Reject',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Reject Code:</b>',
						'childdiv': ''
					}, {
						'type': 'lookup',
						'inputclass': 'jbu_rejecttxt jbu_rejectcode',
						'inputname': 'jbu_rejectcode',
						'btnclass': 'jburejectlookupbtn'
					}, {
						'type': 'labelfull',
						'value': '<b>Operator:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_rejecttxt jbu_rejectoperator',
						'inputname': 'jbu_rejectoperator'
					}, {
						'type': 'labelfull',
						'value': '<b>Rolls:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_rejecttxt jbu_rejectrolls',
						'inputname': 'jbu_rejectrolls'
					}, {
						'type': 'labelfull',
						'value': '<b>KGS:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_rejecttxt jbu_rejectkgs',
						'inputname': 'jbu_rejectkgs'
					}, {
						'type': 'labelfull',
						'value': '<b>Meter:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_rejecttxt jbu_rejectmeters',
						'inputname': 'jbu_rejectmeters'
					}],
					'footerbtns': [{
							'btnclass': 'jbu_rejectinsert btn-success',
							'label': 'Insert'
						},
						{
							'closemodal': true,
							'label': 'Cancel',
							'btnclass': 'btn-github'
						},
					]
				}
			}, { // modal-inputlookup
				'modal-jburejectlookup': {
					'size': 'max',
					'headtitle': 'Reject Lookup',
					'bodyclass': 'jburejectlookupdiv',
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-jbuinput
				'modal-jbuink': {
					'size': 'min',
					'headtitle': 'Add new Ink Consumption',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Color Code:</b>',
						'childdiv': ''
					}, {
						'type': 'lookup',
						'inputclass': 'jbu_inkttxt jbu_inkcolorcode',
						'inputname': 'jbu_inkcolorcode',
						'btnclass': 'jbuinkcolorlookupbtn'
					}, {
						'type': 'labelfull',
						'value': '<b>Color:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_inkttxt jbu_inkcolor',
						'inputname': 'jbu_inkcolor',
						'readonly': 'true',
					}, {
						'type': 'labelfull',
						'value': '<b>WT:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_inkttxt jbu_inkwt',
						'inputname': 'jbu_inkwt'
					}, {
						'type': 'labelfull',
						'value': '<b>Returned:</b>',
						'childdiv': ''
					}, {
						'type': 'text',
						'inputclass': 'jbu_inkttxt jbu_inkreturned',
						'inputname': 'jbu_inkreturned'
					}, {
						'type': 'hidden',
						'inputid': 'jbu_inkline',
						'value': '',
						'inputname': 'jbu_inkline',
						'inputclass': 'jbu_inkttxt jbu_inkline',
					}, {
						'type': 'hidden',
						'inputid': 'jbu_inktrno',
						'value': '',
						'inputname': 'jbu_inktrno',
						'inputclass': 'jbu_inkttxt jbu_inktrno',
					}],
					'footerbtns': [{
							'btnclass': 'jbu_inkcolorinsert btn-success',
							'label': 'Save'
						},
						{
							'closemodal': true,
							'label': 'Cancel',
							'btnclass': 'btn-github'
						},
					]
				}
			}, { // modal-quickadd
				'modal-jbmaterialqty': {
					'size': 'min',
					'headtitle': 'Enter Material Qty',
					'modaltype': 'txtlookup',
					'bodyclass': 'materialqtydiv',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Enter Qty:</b>'
					}, {
						'type': 'textwithicon',
						'inputclass': 'txtjbmaterialqty',
						'icontype': 'fa-plus'
					}]
				}
			}, { // modal-enterqty
				'modal-quickinquiry': {
					'size': 'max',
					'headtitle': 'Quick Inquiry',
					'modaltype': 'txtlookup',
					'modalcontent': [{
						'label': 'Itemname:',
						'type': 'label',
						'inputclass': 'quickinqitemname'
					}, {
						'label': 'Principal:',
						'type': 'label',
						'inputclass': 'quickinqprincipal'
					}, {
						'label': 'Division:',
						'type': 'label',
						'inputclass': 'quickinqdivision'
					}, {
						'type': 'divonly',
						'divclass': 'quickinquiry-tbl',
						'label': 'Available Inventory',
						'childdiv': 'quickinquirydiv'
					}],
					'footerbtns': [{
						'closemodal': true,
						'label': 'Close',
						'btnclass': 'btn-github'
					}]
				}
			}, { // modal-quickadd
				'modal-setdocno': {
					'size': 'min',
					'headtitle': '<span class="setdocnotitle">Set Document #</span>',
					'modaltype': 'txtlookup',
					'bodyclass': 'setdocnodiv',
					'modalcontent': [{
						'type': 'labelfull',
						'value': '<b>Enter Desired Document #:</b>'
					}, {
						'type': 'textwithicon',
						'inputclass': 'txtsetdocno',
						'icontype': 'fa-search'
					}]
				}
			}, { // modal-progressbar
				'modal-product-movement': {
					'size': 'med',
					'headtitle': '<span class="movement_asof"></span>',
					'modaltype': 'html',
					'htmlcontent': '<div style="width: 800px;padding: 4px;margin: 20px;">\
							        <label>Total IN: </label><span class="movement_total_in">---</span><br> \
									<label>Total OUT: </label><span class="movement_total_out">---</span><br> \
									<label>On Hand: </label><span class="movement_onhand">---</span><br> \
									<label>Movement: </label><span class="movement_movement">---</span><br> \
									<label> Mo.to go: </label><span class="movement_mon_togo">---</span > \
							        </div>',
				}
			}, { // modal-progressbar
				'modal-transupdate': {
					'size': 'med',
					'headtitle': '<span class="rt_docnoupdate"></span>',
					'modaltype': 'html',
					'htmlcontent': '<label class="aimslabel">Select Trnx Type:</label>\
								      <select id="trnxtype" class="form-control trnxtype input-sm"></select>\
								      </br>\
								      <label class="aimslabel">Select Tax Type:</label>\
								      <select id="vattype" class="form-control vattype input-sm"></select>\
								      </br>\
								      <label class="aimslabel">Update Yourref:</label>\
								      <input value ="" type="text" class="rttransupdateyourref form-control input-sm">\
								      </br>\
								      <label class="aimslabel">Update Ourref:</label>\
								      <input value ="" type="text" class="rttransupdateourref form-control input-sm">\
								      </br>',
					'data_backdrop': 'static',
					'data_keyboard': 'false',
					'addedstyles': 'padding-top:15%;overflow-y:visible;',
					'footerbtns': [{
							'btnclass': 'rttupdatetrans btn-success',
							'label': 'Save'
						},
						{
							'closemodal': true,
							'label': 'Cancel',
							'btnclass': 'btn-github'
						},
					]

				}
			}, //c0ntinue add here <=====
		);

		modulemodals.create('modal-itemlookup');
		modulemodals.create('modal-showbalance');
		modulemodals.create('modal-lockdate');
		modulemodals.create('modal-logs');
		modulemodals.create('modal-announcements');
		modulemodals.create('modal-newpass');
		modulemodals.create('modal-copyclipboard');
		modulemodals.create('modal-quickadd');
		modulemodals.create('modal-quickinquiry');

		$('.dpYears').datepicker();
		$('.dpMonths').datepicker();

		switch (moduleid) {
			// WTODO G
			case 'FG':
				modulemodals.create('modal-fg_colors');
				modulemodals.create('modal-fg_material');
				modulemodals.create('modal-fg_cylinder');
				modulemodals.create('modal-fg_process');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-clientquickadd');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-fgsealinglookup');
				modulemodals.create('modal-fgplasticcolorlookup');
				modulemodals.create('modal-fgprodtypelookup');
				modulemodals.create('modal-fgtransformationlookup');
				//[KIM][2019.10.31][add modal-fgaddspecslookup]
				modulemodals.create('modal-fgaddspecslookup');
				break;

			case 'quickcollect':
				loadstockview();
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-colltypelookup');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-unpaid');
				break;

			case 'SV':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-sv_docnolookup');
				modulemodals.create('modal-sv_docnolist');
				modulemodals.create('modal-showacctg');
				break

			case 'transupdate':
				var ttype = $('#transtype option:selected').val();
				searchDocumentToUpdate(ttype, '');
				modulemodals.create('modal-transupdate');
				break;

			case 'TW':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-twenter');
				modulemodals.create('modal-itemlookup');
				break;

			case 'taxmenu':
				loadstockview();
				break;

			case 'indexpage':
				modulemodals.create('modal-showitemamtupdates');
				modulemodals.create('modal-progressbar');
				modulemodals.create('modal-dash-explinegraph');
				modulemodals.create('modal-dash-collectlinegraph');
				modulemodals.create('modal-dashrecentsj');
				//$('#modal-progressbar').modal();
				/* generatechangeItemamtdates();
				generateIndexPageTransCounting();
				generateIndexpageLineChart();
				generateIndexpageSJList();

				generateIndexPageDocList();
				generateIndexPageTransList(); */
				//generateIndexPageSchedList();
				//generateIndexPageTotalUsers();
				break;

			case 'manageitem':
				modulemodals.create('modal-class');
				modulemodals.create('modal-brand');
				modulemodals.create('modal-group');
				modulemodals.create('modal-model');
				modulemodals.create('modal-quickadds');
				loadmanageitems();
				break;

			case 'principal':
				loadprincipalgrid();
				break;

			case 'tbmasterfile':
				loadtables();
				break;

			case 'JBU':
				modulemodals.create('modal-jbuinput');
				modulemodals.create('modal-jbuoutput');
				modulemodals.create('modal-jbureject');
				modulemodals.create('modal-jbuinputlookup');
				modulemodals.create('modal-jbuoutputlookup');
				modulemodals.create('modal-jburejectlookup');
				modulemodals.create('modal-jbuink');
				modulemodals.create('modal-fg_colors');
				modulemodals.create('modal-fg_process');

				retrieveJBUDocuments();
				break;

			case 'JB':
				loadstockview();
				var txt = $('.txtboxtrno').val();
				showprocesstab = new GridViewGenerator(domain + '/' + moduleid + '/showavailprocess', '#jbprocessview');
				showprocesstab.initializeGrid(txt, false, [], true, function (data) {
					$(showprocesstab.initdiv).html(data);
					if ($(stockview.initdiv).attr('poststatus') == 1 || $(stockview.initdiv).attr('lockedstatus') == 1) {
						showprocesstab.disabledGridviewEditing(true);
						$('.jb_addprocess').css('display', 'none');
					} else {
						if ($(stockview.initdiv).attr('poststatus') == 0 && $(stockview.initdiv).attr('lockedstatus') == 0) {
							$('.jb_addprocess').css('display', 'inline');
						} //end if
					} //end if
				});

				showmaterialtab = new GridViewGenerator(domain + '/' + moduleid + '/showavailmaterials', '#jbmaterialview');
				showmaterialtab.initializeGrid(txt, false, [], true, function (data) {
					$(showmaterialtab.initdiv).html(data);

					if ($(stockview.initdiv).attr('poststatus') == 1 || $(stockview.initdiv).attr('lockedstatus') == 1) {
						showmaterialtab.disabledGridviewEditing(true);
						$('.jb_addmaterials').css('display', 'none');
					} else {
						if ($(stockview.initdiv).attr('poststatus') == 0 && $(stockview.initdiv).attr('lockedstatus') == 0) {
							$('.jb_addmaterials').css('display', 'inline');
						} //end if
					} //end if		
				});

				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-docnolookup');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-pick');
				modulemodals.create('modal-multivoid');
				modulemodals.create('modal-adminpass');
				modulemodals.create('modal-showbalance');
				modulemodals.create('modal-clientquickadd');
				modulemodals.create('modal-agentpickerlookup');
				modulemodals.create('modal-agentcheckerlookup');
				modulemodals.create('modal-fg_process');
				modulemodals.create('modal-jbmaterialqty');
				break;

			case 'tpshipping':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;


			case 'tphandling':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;

			case 'branch':
				modulemodals.create('modal-contra');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-users');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-brand');
				modulemodals.create('modal-tablelookup');
				break;

				// WTODO JAD 06-03-2019
			case 'scheduler':
				modulemodals.create('modal-users');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-reminders');
				modulemodals.create('modal-schedlist');
				modulemodals.create('modal-clientquickadd');
				modulemodals.create('modal-createevent');
				modulemodals.create('modal-approvedreimbursements');
				break;

			case 'SP':
				loadstockview();
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-supplier');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-multivoid');
				modulemodals.create('modal-adminpass');
				modulemodals.create('modal-pick');
				modulemodals.create('modal-clientquickadd');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;

			case 'reportlist':
				modulemodals.create('modal-eventprojectlookup'); // WTODO JAD 06-03-2019
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-centers');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-group');
				modulemodals.create('modal-category');
				modulemodals.create('modal-part');
				modulemodals.create('modal-model');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-brand');
				modulemodals.create('modal-class');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-area');
				modulemodals.create('modal-region');
				modulemodals.create('modal-province');
				modulemodals.create('modal-users');
				modulemodals.create('modal-progressbar');
				modulemodals.create('modal-principal');
				modulemodals.create('modal-uvcategory');
				//[JLY][2019.08.17][KINGG CONCERNS][ADD GROUP FILTER]
				modulemodals.create('modal-clientgroup');
				//[KIM][2019.09.16][modal-prodtype and modal-material]
				modulemodals.create('modal-prodtype');
				modulemodals.create('modal-material');
				//[KIM][2019.10.03][modal-jobno]
				modulemodals.create('modal-jobno');
				//[KIM][2019.10.29][modal-loc][filter for inventory checksheet]
				modulemodals.create('modal-loc');
				//[KIM][2019.11.11][modal-fgitemlookup]
				modulemodals.create('modal-fgitemlookup');
				modulemodals.create('modal-department');
				break;

			case 'colltype':
				loadcollectiontypes();
				modulemodals.create('modal-contra');
				break;

			case 'proj':
				loadcostcenters();
				break;

			case 'notification':
				loadnotifgrid();
				break;


			case 'POSRetail':
				loadposlistsgrid();
				initializePOSShortcuts();
				break;

			case 'collection':
			case 'distribution':
			case 'categories':
			case 'taxmenu':
			case 'itemclass':
			case 'stype':
			case 'stockgrp':
			case 'model':
			case 'part':
			case 'fg_colors':
			case 'fg_material':
			case 'fg_process':
			case 'prodtype':
			case 'transform':
			case 'sealing':
			case 'plastic':
			case 'prodspec':
			case 'inout':
			case 'reject': // WTODO[jad][2019-09-07]
			case 'mlocation':
				loadmasterfilegrid();
				break;

			case 'fg_cylinder':
				loadequiptoolgrid();
				break;

			case 'DM':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-contra');

				modulemodals.create('modal-quickadditem');

				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-showacctg');
				modulemodals.create('modal-pick');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-clientquickadd');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;

			case 'useraccess':
				modulemodals.create('modal-supplier');
				break;


			case 'RR':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-contra');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-showacctg');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-pick');
				modulemodals.create('modal-clientquickadd');
				modulemodals.create('modal-showpricechange');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;

			case 'PR':
				loadstockview();
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-supplier');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-multivoid');
				modulemodals.create('modal-clientquickadd');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;

			case 'PO':
				loadstockview();
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-supplier');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-multivoid');
				modulemodals.create('modal-adminpass');
				modulemodals.create('modal-pick');
				modulemodals.create('modal-clientquickadd');
				modulemodals.create('modal-showpricechange');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;


			case 'pscheme':
			case 'PS':
				loadstockview();
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-showterms');

				modulemodals.create('modal-docnolookup');


				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-multivoid');
				modulemodals.create('modal-adminpass');
				modulemodals.create('modal-showbalance');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;

			case 'QA':
				loadstockview();
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-docnolookup');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-multivoid');
				modulemodals.create('modal-adminpass');
				modulemodals.create('modal-showbalance');
				modulemodals.create('modal-clientquickadd');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;

			case 'SO':
				loadstockview();

				switch (cconfig) {
					case 'UNIVERSE':
						loadTranstype();
						break;
				} //end switch

				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-docnolookup');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-pick');
				modulemodals.create('modal-multivoid');
				modulemodals.create('modal-adminpass');
				modulemodals.create('modal-showbalance');
				modulemodals.create('modal-clientquickadd');
				modulemodals.create('modal-agentpickerlookup');
				modulemodals.create('modal-agentcheckerlookup');

				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;

			case 'QA':
				loadstockview();
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				break;

			case 'SJ':
				loadstockview();

				switch (cconfig) {
					case 'UNIVERSE':
						loadAvailableAgents_UV('default', function (data) {
							$('.agentcombo option:not(:selected)').remove();
							$.each(data.agents, function (i, x) {
								if (x.clientname != $('.agentcombo option:selected').text()) {
									$('.agentcombo').append('<option>' + x.client + '~' + x.clientname + '</option>');
								} //END IF
							});
						});

						loadAvailableAgents_UV('picker', function (data) {
							$('.pickercombo option:not(:selected)').remove();
							$.each(data.agents, function (i, x) {
								if (x.clientname != $('.pickercombo option:selected').text()) {
									$('.pickercombo').append('<option>' + x.client + '~' + x.clientname + '</option>');
								} //END IF
							});
						});

						loadAvailableAgents_UV('checker', function (data) {
							$('.checkercombo option:not(:selected)').remove();
							$.each(data.agents, function (i, x) {
								if (x.clientname != $('.checkercombo option:selected').text()) {
									$('.checkercombo').append('<option>' + x.client + '~' + x.clientname + '</option>');
								} //END IF
							});
						});
						break;
				} //end switch

				modulemodals.create('modal-setdocno');
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-contra');

				modulemodals.create('modal-pick');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-showacctg');
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-showdisc');
				modulemodals.create('modal-clientquickadd');
				//modulemodals.create('modal-actnotes'); // WTODO JAD 03-15-2019 customer notes
				modulemodals.create('modal-last10trans');
				modulemodals.create('modal-copyso');
				modulemodals.create('modal-fgprodtypelookup');
				modulemodals.create('modal-joborderlookup');
				modulemodals.create('modal-mlcpstocknotes');

				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;


			case 'quotation':
				loadstockview();
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-itemlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-enterqty');
				break;

			case 'MI':
				loadstockview();
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-pick');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-showacctg');
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-showdisc');
				modulemodals.create('modal-clientquickadd');
				break;

			case 'MX':
				loadstockview();
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-pick');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-showacctg');
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-showdisc');
				modulemodals.create('modal-clientquickadd');
				break;

			case 'CM':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-logs');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-pick');
				modulemodals.create('modal-showacctg');
				modulemodals.create('modal-showdisc');
				modulemodals.create('modal-clientquickadd');
				break;

			case 'IS':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-showbalance');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-showacctg');
				break;

			case 'PC':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-whlookup');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-showbalance');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-uomlookup');
				break;

			case 'TS':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-expiry');
				modulemodals.create('modal-loclookup');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-pick');
				modulemodals.create('modal-showbalance');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-route');
				break;

			case 'TR':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-multivoid');
				modulemodals.create('modal-adminpass');
				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-showbalance');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-route');
				break;

			case 'AJ':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-contra');

				modulemodals.create('modal-quickadditem');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-showbalance');
				modulemodals.create('modal-showacctg');
				break;

			case 'coa':
				modulemodals.create('modal-alias');
				modulemodals.create('modal-contra');

				modulemodals.create('modal-details');
				break;

			case 'stockcard':
			case 'posstockcard':
				getSuggestionLibrary();
				modulemodals.create('modal-part');
				modulemodals.create('modal-model');
				modulemodals.create('modal-class');
				modulemodals.create('modal-brand');
				modulemodals.create('modal-loclookup');
				modulemodals.create('modal-body');
				modulemodals.create('modal-size');
				modulemodals.create('modal-category');
				modulemodals.create('modal-group');
				modulemodals.create('modal-whlookup');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-uomlookup');
				modulemodals.create('modal-logs');
				modulemodals.create('modal-changebarcode');
				modulemodals.create('modal-enterqty');
				modulemodals.create('modal-components');
				modulemodals.create('modal-showattachment');
				modulemodals.create('modal-priority');
				modulemodals.create('modal-department');
				modulemodals.create('modal-suppitemcode');
				modulemodals.create('modal-uomprint');
				modulemodals.create('modal-principal');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-serveddocs');
				modulemodals.create('modal-fgsealinglookup');
				modulemodals.create('modal-fgplasticcolorlookup');
				modulemodals.create('modal-fgprodtypelookup');
				modulemodals.create('modal-product-movement');
				break;

			case 'customer':
				getSuggestionLibrary();
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-collectionarea');
				modulemodals.create('modal-distributionarea');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-group');
				modulemodals.create('modal-category');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-area');
				modulemodals.create('modal-province');
				modulemodals.create('modal-region');
				modulemodals.create('modal-logs');
				modulemodals.create('modal-unpaid');
				modulemodals.create('modal-pick');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-showclientstats');
				modulemodals.create('modal-actnotes'); // WTODO JAD 03-15-2019 customer notes
				modulemodals.create('modal-last10trans');
				break;

			case 'supplier':
				getSuggestionLibrary();
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-group');
				modulemodals.create('modal-category');
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-area');
				modulemodals.create('modal-province');
				modulemodals.create('modal-region');
				modulemodals.create('modal-logs');
				modulemodals.create('modal-unpaid');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-showclientstats');
				break;

			case 'agent':
				getSuggestionLibrary();
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-group');
				modulemodals.create('modal-area');
				modulemodals.create('modal-province');
				modulemodals.create('modal-region');
				break;

			case 'warehouse':
				getSuggestionLibrary();
				modulemodals.create('modal-whlookup');
				break;

			case 'GJ':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-unpaid');
				modulemodals.create('modal-checks');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-entercoa');
				modulemodals.create('modal-costcenter');
				modulemodals.create('modal-clientquickadd');
				modulemodals.create('modal-setendingdate');
				break;

			case 'DS':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-checks');
				modulemodals.create('modal-entercoa');
				break;

			case 'bankrecon':
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-unpaid');
				modulemodals.create('modal-showterms');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-logs');
				modulemodals.create('modal-entercoa');
				modulemodals.create('modal-checks');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
				break;

			case 'AP':
				loadstockview();
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-logs');
				modulemodals.create('modal-entercoa');
				modulemodals.create('modal-costcenter');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-clientquickadd');
				break;

			case 'PV':
				loadstockview();
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-unpaid');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-logs');
				modulemodals.create('modal-entercoa');
				modulemodals.create('modal-costcenter');
				modulemodals.create('modal-clientquickadd');
				modulemodals.create('modal-ewtlookup');
				break;

			case 'CV':
				loadstockview();
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-unpaid');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-logs');
				modulemodals.create('modal-entercoa');
				modulemodals.create('modal-costcenter');
				modulemodals.create('modal-clientquickadd');
				break;

			case 'AR':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-agentlookup');
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-logs');
				modulemodals.create('modal-entercoa');
				modulemodals.create('modal-clientquickadd');
				modulemodals.create('modal-showterms');
				break;

			case 'VR':
				modulemodals.create('modal-users');
				break;
			case 'VC':
				modulemodals.create('modal-users');
				break;

			case 'CR':
				loadstockview();
				modulemodals.create('modal-unpaid');
				modulemodals.create('modal-contra');
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-supplier');
				modulemodals.create('modal-pdcchecks');
				modulemodals.create('modal-logs');
				modulemodals.create('modal-entercoa');
				modulemodals.create('modal-clientquickadd');
				break;

			case 'KR':
				loadstockview();
				modulemodals.create('modal-docnolookup');
				modulemodals.create('modal-clientlookup');
				modulemodals.create('modal-unpaid');
				modulemodals.create('modal-logs');
				modulemodals.create('modal-entercoa');
				modulemodals.create('modal-clientquickadd');
				break;

			case 'docprefix':
				loaddocprefix();
				modulemodals.create('modal-logs');
				break;

			case 'terms':
				loadtermsgrid();
				break;

			case 'ewtsetup':
				loadewtlistgrid();
				break;

			case 'changeitem':
				loadstockview();
				modulemodals.create('modal-brand');
				modulemodals.create('modal-group');
				modulemodals.create('modal-model');
				modulemodals.create('modal-part');
				modulemodals.create('modal-size');
				break;
		} //end switch

		switch (moduleid) {
			case 'PO':
			case 'RR':
			case 'DM':
			case 'SO':
			case 'SJ':
			case 'CM':
			case 'IS':
			case 'AJ':
			case 'PC':
			case 'TS':
			case 'TR':
			case 'AP':
			case 'PV':
			case 'CV':
			case 'DS':
			case 'AR':
			case 'CR':
			case 'KR':
			case 'GJ':
			case 'MI':
				if (!$.isEmptyObject(initparam)) {
					ajaxSearchDoc(initparam.q);
				} //end if
				break;
		} //end switch


		var moduleid = $('#viewmoduleid').val();
		switch (moduleid) {
			case 'TX':
				var trno = $('.txtboxtrno').val();
				if (trno != '') {
					retrieveTX_Invoices(trno);
				} //end if
				break;

			case 'RF':
				var trno = $('.txtboxtrno').val();
				if (trno != '') {
					retrieveRFTaggedSO();
				} //end if
				break;

			case 'KL':
				retrieveAgentCollectionList();
				break;

			case 'indexpage':
				viewAllDatedAnnouncement();
				break;

				// case 'stockcard':
				// 	var barcode = $('.txtbarcode').val();
				// 	loadAvailableUom(barcode,0);
				// break;

			case 'SJ':
				requestInvoiceLimiter(function (data) {
					invoicelimiting = data.limiter;
				});

				requestStockAccess(function (data) {
					$.each(data, function (i, x) {
						allowedstockaccess[i] = x;
					});
				});
				break;

			case 'AJ':
			case 'PC':
			case 'IS':
			case 'RR':
				viewCostAccess(function (data) {
					viewcostaccess = data.viewcosting;
				});
				break;

			case 'adminsignin':
				$('#dashusername').focus();
				break;

			case 'lanemanager':
				$('#lanelisting').html("<img src='" + domain + "/backendassets/img/loading.gif' style='position:absolute;margin-left:45%;margin-top:10%;' width='5%'/>");
				retrieveFrontendLanes('', function (data) {
					plotLanes(data.lanes);
				});
				break;

			case 'logtracer':
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();

				loadReportLogTraces();
				break;

			case 'ordermanager':
				loadAvailableOrderStatuses();
				break;

			case 'fsalemanager':
				retrieveAvailableOnSaleItems('');
				break;

			case 'managedod':
				$('.fdodlisttbl').html("<img src='" + domain + "/backendassets/img/loading.gif' style='position:absolute;margin-left:45%;margin-top:10%;' width='5%'/>");
				manageDOD('', 'RETRIEVE_DODLIST', function (data) {
					plotDODlist(data);
				}); //end function manage dod
				break;

			case 'managefdeals':
				$('.ffdlisttbl').html("<img src='" + domain + "/backendassets/img/loading.gif' style='position:absolute;margin-left:45%;margin-top:10%;' width='5%'/>");
				var params = {
					searchstring: ''
				};
				manageFlashDeals(params, 'RETRIEVE_FLASHDEAL_LIST', function (data) {
					plotFlashDealList(data);
				});
				break;

			default:
				break;
		} //end swtich

		$(".timepicker").timepicker({
			showInputs: false
		});

		$('#modal-itemlookup').on('shown.bs.modal', function () {
			$('.txtsearchitem').focus().trigger("keyup");
		});

		$('#modal-setdocno').on('shown.bs.modal', function () {
			$('.txtsetdocno').focus();
		});


		$('#modal-setdocno').on('hidden.bs.modal', function () {
			varstorage.removeData("copytranskey");
		});


		$('#modal-jbmaterialqty').on('shown.bs.modal', function () {
			$('.txtjbmaterialqty').focus().val(1);
		});

		$('#modal-agentpickerlookup').on('shown.bs.modal', function () {
			$('.txtsearchagent').focus().trigger("keyup");
		});

		$('#modal-agentcheckerlookup').on('shown.bs.modal', function () {
			$('.txtsearchagent').focus().trigger("keyup");
		});

		$('#modal-quickadditem').on('shown.bs.modal', function () {
			$('.txtquickadditem').focus();
			itemInfo();
		});

		$('#modal-unpaid').on('shown.bs.modal', function () {
			$('.txtunpaidsearchlookup').focus().trigger("keyup");
		});

		$('#modal-quickadd').on('shown.bs.modal', function () {
			$('.txtquickadd').focus();
		});

		$('#modal-contra').on('shown.bs.modal', function () {
			$('.txtsearchcontra').focus().trigger("keyup");;
		});

		$('#modal-docnolookup').on('shown.bs.modal', function () {
			$('.txtsearchdocno').focus().trigger("keyup");;
		});

		$('#modal-whlookup').on('shown.bs.modal', function () {
			$('.txtsearchwh').focus().trigger("keyup");;
		});

		$('#modal-clientlookup').on('shown.bs.modal', function () {
			$('.txtsearchcustomer').focus().trigger("keyup");;
		});

		$('#modal-agentlookup').on('shown.bs.modal', function () {
			$('.txtsearchagent').focus().trigger("keyup");;
		});

		$('#modal-supplier').on('shown.bs.modal', function () {
			$('.txtsearchsupp').focus().trigger("keyup");
		});

		$(document).on('show.bs.modal', '#modal-detailclientlookup', function () {
			$('.txtsearchdetailclient').focus().trigger('click');
		});

		$('#modal-supplookup').on('shown.bs.modal', function () {
			$('.txtsearchsupp').focus().trigger('click');
		});

		$('#modal-contra').on('shown.bs.modal', function () {
			$('.txtsearchcontra').focus().trigger('click');;
		});

		$('#modal-vendorlookup').on('shown.bs.modal', function () {
			$('.txtsearchvendor').focus().trigger('click');
		});

		$('#modal-locationlookup').on('shown.bs.modal', function () {
			$('.txtsearchlocation').focus().trigger('click');
		});

		$('#modal-ourref2').on('shown.bs.modal', function () {
			$('.txtsearchourref2').focus().trigger("keyup");
		});

		$('#modal-newpass').on('shown.bs.modal', function () {
			$('.txtoldpass').focus().trigger("keyup");
		});

		$('#modal-ourref').on('shown.bs.modal', function () {
			$('.txtsearchourref').focus().trigger("keyup");
		});

		$('#modal-yourref2').on('shown.bs.modal', function () {
			$('.txtsearchyourref2').focus().trigger("keyup");
		});

		$('#modal-changebarcode').on('shown.bs.modal', function () {
			$('.txtchangebarcode').focus().val('').trigger("keyup");
		});

		$('#modal-addnewbrand').on('shown.bs.modal', function () {
			$('#txtnewbrand').val('');
			$('#txtnewbrand').focus().trigger("keyup");
		});

		$('#modal-taxmenulookup').on('shown.bs.modal', function () {
			$('.txtsearchtaxmenu').focus();
			$('.txtsearchtaxmenu').val('').trigger("keyup");
		});

		$('#modal-enterqty').on('shown.bs.modal', function () {
			$('.enteredqty').focus();
		});

		$('#modal-frontendcatlist').on('shown.bs.modal', function () {
			$('#fdescription').focus().trigger("keyup");
		});

		$('#modal-adminpass').on('shown.bs.modal', function () {
			getUser();
		});

		//CLOSE MODAL TRIGGERS
		$('#modal-itemlookup').on('hidden.bs.modal', function () {
			$('#item-lookuptype').val('');
		});

		$('#modal-quickadd').on('hidden.bs.modal', function () {
			varstorage.removeData('quickaddtype');
		});

	}); //end promise cconfig
}); //END FUNCTION ONLOAD (PAGE READY)

//THIS FUNCTION IS USED TO GET SCREEN DIMENSION OF THE CURRENT SCREEN
function getScreenDimensions() {
	var hsize = $(window).height();
	var wsize = $(window).width();
	//THIS SETS THE SCROLLBAR FOR LEFTSIDE MENU
	$('.main-sidebar').css({
		"height": hsize,
		"max-height": "100%"
	});

	$('.wrapper').css({
		"height": hsize,
		"max-height": "100%"
	});

	$('.content-header').css({
		"height": hsize,
		"max-height": "100%"
	});
} //end function

//THIS FUNCTION IS USED TO SET THE LAYOUT SETTING (EITHER HAS MINIMIZED SIDEBAR OR EXPANDED SIDEBAR)
//THE SET LAYOUT WILL BE AVAILABLE FOR THE WHOLE USER SESSION OF USING AIMS
function setLayoutsetting() {
	$.get(domain + '/admin/setlayoutsetting', {}, function (data) {
		//data = $.parseJSON(data);
		if (data.isminimized) {
			$('body').addClass('sidebar-collapse');
			$('.tt-cursor').css('width', '98%');
			$('.tt-dataset').css('width', '451%');
		} else {
			$('body').removeClass('sidebar-collapse');
			$('.tt-cursor').css('width', '98%');
			$('.tt-dataset').css('width', '382%');
		} //end if
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end if set layout setting

//THIS FUNCTION IS USED TO CHECK ACTIVE OR PENDING REQUESTS
function checkActiveRequests() {
	if ($.active < 2) {
		console.log('There are no active requests - ' + $.active);
		$('#overlay').css('display', 'none');
	} //end if
} //end function checkactiverequest

//THIS FUNCTION IS USED TO REQUEST AND RETRIEVE DECIMAL DISPLAY SETTINGS
function requestDecimalDisplay(callback) {
	$.get(domain + '/admin/requestdecimal', {}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end function


function generateIndexPageDocList() {
	unpgrid1 = new GridViewGenerator(domain + '/admin/loadunpgrid1', '.unpdiv1');
	unpgrid1.initializeGrid();
}


function generateIndexPageTransList() {
	transgrid1 = new GridViewGenerator(domain + '/admin/loadtransgrid1', '.transdiv1');
	transgrid1.initializeGrid();
}


/* function generateIndexPageSchedList() {
	schedgrid1 = new GridViewGenerator(domain + '/admin/loadschedgrid1', '.scheddiv1');
	schedgrid1.initializeGrid();
} */



/* function generateIndexPageTotalUsers() {
	$.get(domain + '/admin/totalschedusers', {}, function (data) {
		//data = $.parseJSON(data);
		$('#totalscheduledusers').html(data.total[0]['count']);
	});
} */

//THIS FUNCTION IS USED TO REQUEST AND RETRIEVE THE COMPANY SETTING INTERNALLY
function requestCompanyConfig(callback) {
	$.get(domain + '/admin/requestcompanyconfig', {}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end function

//THIS FUNCTION IS USED TO REQUEST AND RETRIEVE THE SYSTEM LOCKDATE
function requestSystemLockdate(callback) {
	$.get(domain + '/admin/reqsysdate', {}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end function

//THIS FUNCTION IS USED TO REQUEST AND RETRIEVE THE INVOICE LIMIT FOR (SJ) (CAN ALSO BE USED ON OTHER MODULES)
function requestInvoiceLimiter(callback) {
	$.get(domain + '/admin/requestinvoicelimiter', {}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end function

function requestEditableEntryLimiter(callback) {
	$.get(domain + '/admin/requesteditablentrylimiter', {}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end function

//THIS FUNCTION IS USED TO REQUEST AND RETRIEVE THE VIEW COST ACCESS OF A USER
function viewCostAccess(callback) {
	$.get(domain + '/admin/viewcostaccess', {}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end action view cost access


function requestStockAccess(callback) {
	var moduleid = $('#viewmoduleid').val();
	$.get(domain + '/admin/reqstockaccess', {
		doc: moduleid
	}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end action view cost access

//THIS FUNCTION IS USED TO HAVE OUR CLOCK GIVE THE LIVE TIME (BASED ON TIMEZONE)
function TickClock() {
	$('#clock').html(moment().format('dddd, MMMM DD, YYYY, h:mm:ss a'));
} //END FUNCTION TICKCLOCK

//THIS FUNCTION IS USED TO REQUEST AND RETRIEVE THE CONFIDENTIAL ACCESS OF A USER
function checkConfidentialAccess(callback) {
	$.get(domain + '/admin/checkconfidentialaccess', {}, function (data) {
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error', 'System Error: Status Code ' + jqXHR.status, 'ERROR');
	});
} //end function 

//########################################### UNFINISHED FUNCTIONS ####################################################

//STILL IN BETA PHASE (WILL BE USED TO HAVE GET PARAMETERS BETWEEN MODULES SO WE COULD HAVE MORE OPTIONS)
//OR SETTINGS BETWEEN MODULES
function checkforInitialParameters() {
	var uri = new URI(window.location);
	initparam = uri.query();
	var initparams = getParameters();
	return initparams;
} //end function

function getParameters() {
	var searchString = window.location.search.substring(1),
		params = searchString.split("&"),
		hash = {};
	if (searchString == "") return {};
	for (var i = 0; i < params.length; i++) {
		var val = params[i].split("=");
		hash[unescape(val[0])] = unescape(val[1]);
	} //end f
	return hash;
} //end f


function loadautocomplete() {
	var moduleid = $('#viewmoduleid').val();
	switch (moduleid) {
		case 'SO':
			var tableid = '#sostockview';
			break;
	} //end switch

	$(tableid + ' tbody tr[id].temprow').each(function () {
		$(this).find('input[coltype=barcode]').autocomplete({
			source: availableTags
		});
	}); //nd  each
} //end fn


$(document).on('click', '.ui-menu-item', function () {
	var data = $(this).html().split('~');
	var barcode = data[0];
	triggerPullItemdata(barcode);

});

function triggerPullItemdata(barcode) {
	stockview.saveAllButtons();
	var trno = $('.txtboxtrno').val(),
		moduleid = $('#viewmoduleid').val();

	$.ajax({
		type: 'post',
		url: domain + '/admin/loaditemname',
		data: {
			barcode: barcode,
			trno: trno,
			doc: moduleid
		},
		success: function (data) {
			//data = $.parseJSON(data);
			var tr = $('body').data('tr');
			tr.find('input[coltype=barcode]').val(data.item[0].barcode);
			tr.find('input[coltype=itemname]').val(data.item[0].itemname);
			tr.find('input[coltype=uom]').val(data.item[0].uom);
			tr.find('input[coltype=whcode]').val(data.item[0].wh);
		}
	});
} //end f1


function loadReportLogTraces() {
	let moduleid = $('#viewmoduleid').val();
	let addedparams = [];
	let logstart = $('.logstartdate').val();
	let logend = $('.logenddate').val();
	let user = $('.selectedusers option:selected').val();
	let logtype = $('.selectmodule option:selected').val();

	addedparams.push({
		name: "startdate",
		value: logstart
	});

	addedparams.push({
		name: "enddate",
		value: logend
	});

	addedparams.push({
		name: "user",
		value: user
	});

	addedparams.push({
		name: "logtype",
		value: logtype
	});

	let searchString = $('.logsearcher').val();

	var logtable = new GridViewGenerator(domain + '/' + moduleid + '/tracelogs', '.tbltracelogs');
	logtable.initializeGrid(searchString, null, addedparams);
} //end fn


$(document).on('keyup', '.txtgridbarcode', function () {
	var tr = $(this).closest('tr');
	$('body').data('tr', tr);
});