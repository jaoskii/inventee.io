//ANOTHER PROTOTYPE STRUCTURED CLASS
//TABLE CONSTRUCTOR CLASS
//THIS CLASS HAS ALL THE OPTION LOADERS FOR COMBO BOXES NATURALLY USED BY TRANSACTIONAL MODULE COMBOBOXES 
function tableConstructor(apto,...tableFields){
	this.doc = $('#viewmoduleid').val();
	this.trno = $('.txtboxtrno').val();
	//THIS SERVES AS THE ACITON URL FOR ALL ACTIONSLINKS RELATED TO AJAX
	this.actionurl = '';
	this.actionparams = {};
	//PUT ADDITIONAL PROPERTIES HERE
	this.appendto = apto;
	this.tblheaders = tableFields;
	this.tabs;
	this.hastabs = false;

	//TABLE SKELETONS
	this.tablestartpad = '<div class="col-md-12">';
	this.tabstartpad = '<div class="nav-tabs-custom">';
    this.innertablestartpad = '<div class="nav-tabs-custom">\
            				   <div class="tab-content">\
                               <div class="tab-pane active" id="tab_1">\
                  			   <div class="row">\
                    		   <div class="col-md-12">\
                               <div class="box box-solid box-success">\
                               <div class="box-body mod-tble">';    
    this.innertableendpad = '</div></div></div></div></div></div></div>';
    this.tabendpad = '</div>';
    this.tableendpad = '</div>';
}//End function

tableConstructor.prototype = {
	constructor: tableConstructor,

	setTabs:function(settabbing,...tableTabs){
		this.tabs = tableTabs;
		this.hastabs = settabbing;
	},//end set tabs

	generateTable:function(){
		var strhtml = this.tablestartpad;
		if(this.hastabs){
			strhtml += this.tabstartpad;
			strhtml += '<ul class="nav nav-tabs bg-green">';
			$.each(this.tabs, function(i, data) {
				switch(data.tabtype){
					case 'tab':
					strhtml += '<li class="'+data.state+'"><a href="#'+data.href+'" data-toggle="tab">'+data.tabtitle+'</a></li>';
					break;

					case 'tabtxt':
					strhtml += '<li class="pull-right"><h6 class="'+data.tabclass+' tabtxt">'+data.tabtitle+'</h6></li>';
					break;
				}//end switch
			});//end for each
			strhtml += '</ul>';
			strhtml += this.innertablestartpad;
			strhtml += '<table class="table tbl-fix bodytable table-hover">';
			strhtml += '<thead><tr>';

			$.each(this.tblheaders, function(i, data) {
				var hsize = 'col-'+data.hsize;
				if(data.hsize == 'hidden'){
					hsize = 'nobody';
				}//end if
				strhtml += '<th class="'+hsize+' aimslabel">'+data.headertitle+'</th>';
			}); // end each column header
			
            strhtml += '</tr></thead>';
            strhtml += '<tbody class="modulebody"></tbody>';
			strhtml += this.innertableendpad;
		}//end if
		strhtml += this.tabendpad;
		strhtml += this.tableendpad;
		
		$(strhtml).appendTo(this.appendto);
		
		/*$.each(this.tblheaders, function(index, data) {
			console.log(data);
		});*/
	},//end function 1

	retrieveTableData: function(loadtype,...loadParams){
		switch(loadtype){
			case 'index':
			this.actionurl = 'getstockdata';
			this.actionparams = {};
			break;
		}//end switch

		$.get(domain+'/'+this.doc+'/'+actionurl,this.actionparams,function(data){
			data = $.parseJSON(data);

		}).fail(function (jqXHR, textStatus, error) {
			generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
	  	});//END AJAX
	},//end function retrieve table data
}//end combooptionloader prototype