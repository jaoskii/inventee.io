function GridViewGenerator(sourceurl,bind_div){
	//PUT ADDITIONAL PROPERTIES HERE
		var stockview;
		var sonotes;
		var masterfilegrid;
		var changeitemgrid;
		var costcentergrid;
		var brandsgrid;
		var componentslookup;
		var tblanon;
		var reminderslookup;
		var fgtabgrid1, fgtabgrid2, fgtabgrid3, fgtabgrid4;

		this.gridsourceurl = sourceurl;
		this.initdiv = bind_div;
		this.editedcolor = '#afd9ee'; //DEFAULT EDITED COLOR
		this.savedrowcolor = '';
		this.newrowcolor = '#4E62F7';
		this.temprowcount = 0;
		this.availablebtns = '';
		this.stockaccess = 'bbbb';
		this.isinitialized = false;
		this.voidbtns = {
			'void':'<a class="voidbtn btn btn-social-icon btn-google aimslabel" title="" txtclass="bodytextbox" style="width:40px;height:18px;margin-left:2px;margin-right:2px;text-align:center;">Void</a>',
			'unvoid':'<a class="unvoidbtn btn btn-social-icon btn-github aimslabel" title="" txtclass="bodytextbox" style="width:40px;height:18px;margin-left:2px;margin-right:2px;text-align:center;">Unvoid</a>'
		};
}//End function

GridViewGenerator.prototype = {
	constructor: GridViewGenerator,
	initializeGrid: function(x,isreadonly,addedparams,isfeed,callback){
		var me = this;
		var idiv = this.initdiv;

		if(typeof isfeed === "undefined" || isfeed === null) { 
			isfeed = false;
			callback = null;
		}//end if

		if(typeof readonly === "undefined" || readonly === null) { 
			readonly = false;
		}//end if

		if(typeof x === "undefined" || x === null) { 
			var gridparams = [];
		}else{
			var gridparams = [];
			gridparams.push({name: "x", value:x});
		}//end if

		if(typeof addedparams === "undefined" || addedparams === null) {
			addedparams = [];
		} else {
			$.each(addedparams,function(index,value){
				gridparams.push(value);
			});
		}//end if
				
		//$('#overlay').css('display','block');
		$(idiv).html("<img src='"+domain+"/backendassets/img/loading.gif' class='preloader' style='position:relative;margin-left:45%;margin-top:10%;' width='5%'/>");

		$.ajax({
			type: 'post',url: this.gridsourceurl,
			data: gridparams,
			success: function(datagrid) {
				if(isfeed) {
					callback(datagrid);
				} else {
					$(idiv).html(datagrid);
					
					if(isreadonly){
						me.disabledGridviewEditing(true);
					}//end if
				}
				//$('#overlay').css('display','none');
				$('.dpYears').datepicker();
				$('.dpMonths').datepicker();
			}//end switch success
		});//end ajax
	
	},//end function
	dumpDetails:function(){
		console.log('Binded Location / Init Location: ' + this.initdiv);
		console.log('Edited Color: ' + this.editedcolor);
		console.log('Temporary Row Index Interval: ' + this.temprowcount);
		console.log('Total # of Rows: ' + $(this.initdiv+' table tbody tr').length);
	},
	disabledGridviewEditing:function(booleanedit){
		var initdiv = this.initdiv;
		if(booleanedit){
			$(initdiv+' .bodytextbox').attr("disabled",true);
			
			$(initdiv+' .jbprocesstxt').attr("disabled",true);
			$(initdiv+' .jbmaterialtxt').attr("disabled",true);

			$(initdiv+' .gv-options').css("display","none");
			$(initdiv+' .gvbtns').css("display","none");
			$(initdiv+' input.gridcheckbox, '+initdiv+' input.checkbox_all').prop('disabled',true); // WTODO
		}else{
			$(initdiv+' .bodytextbox').attr("disabled",false);
			$(initdiv+' .bodytextbox').removeAttr('disabled');
			
			$(initdiv+' .jbprocesstxt').attr("disabled",false);
			$(initdiv+' .jbprocesstxt').removeAttr("disabled");
			$(initdiv+' .jbmaterialtxt').attr("disabled",false);
			$(initdiv+' .jbmaterialtxt').removeAttr('disabled');

			$(initdiv+' .gv-options').css("display","table-cell");
			$(initdiv+' .gvbtns').css("display","inline-block");
			$(initdiv+' input.gridcheckbox, '+initdiv+' input.checkbox_all').prop('disabled',false); // WTODO
		}//end if
	},
	getProperty:function(type){
		switch(type){
			case 'initdiv':
				return this.initdiv;
			break;
		}//end switch
	},//end function
	addNewRow : function(tableid,line,type){
		var placeholder = '',newrow = '', hiddenbuttons = [], hiddencheckbox = [], hiddeninput = [], template = [], i  = line, moduleid  = $('#viewmoduleid').val(), saveclass = '';
		switch(moduleid) { // SAVE BUTTON CLASS
			case 'stockcard': case 'posstockcard':
				 var lookuptype = $('body').data('lookuptype');
				 
				 if(lookuptype == 'component'){
				 	saveclass = 'savecomponentitem';
				 } else {
					saveclass = 'uomformsave';
				 }
			break;
			case 'manageitem':
				var lookuptype = $('body').data('manageitemtype');
				if(lookuptype == 'component') {
					saveclass = 'savecomponentitem';
				} else if(lookuptype == 'addmenuchoice') {
					saveclass = 'savemenuchoice';
				} else {
					saveclass = 'savemenuchoices';
				}
			break;

			case 'branch':
				saveclass = 'savebranchgrid';
			break;
			case 'tbmasterfile':
 				saveclass = 'savetable';
 			break;
			case 'stype': case 'taxmenu': case 'itemclass': case 'categories': case 'distribution': case 'collection': 
			case 'stockgrp': case 'model': case 'part': case 'colltype':
			case 'fg_colors': case 'fg_material': case 'fg_cylinder': case 'fg_process':
			case 'prodtype': case 'transform': case 'sealing': case 'plastic':
			case 'prodspec': case 'inout': case 'reject': case 'mlocation':
				saveclass = 'mastersave';
 			break;
 			// WTODO G
 			case 'FG':
 				saveclass = 'btnsavefggrid';
 			break;
 			case 'terms':
 				saveclass = 'saveterms';
 			break;

 			case 'ewtsetup':
 				saveclass = 'saveewt';
 			break;

 			case 'principal':
 				saveclass = 'saveprincipal';
 			break;

 			case 'proj':
 				saveclass = 'savecostcenter';
 			break;
 			case 'scheduler':
 				saveclass = 'savereminder';
 			break;
 			default:
 				saveclass = 'stocksavebtn';
 			break;
		}//end switch

		if($('#modal-announcements').hasClass('in')) {
			saveclass = 'saveanon';
			if(typeof type === "undefined" || type === null) {
				var newrowbuttons = {'save':'<a class="'+saveclass+' btn btn-social-icon btn-bitbucket" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i></a>',
									'cancel':'<a class="stockcanceladdbtn btn btn-social-icon btn-github" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-times" style="font-size:12px;margin-top:-8px;"></i></a>'};
			} else {
				var newrowbuttons = {'save':'<a class="'+saveclass+' btn btn-social-icon btn-bitbucket" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i></a>',
									'cancel':'<a class="stockcanceladdbtn btn btn-social-icon btn-github" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-times" style="font-size:12px;margin-top:-8px;"></i></a>'};
			}
		} else {
			switch(moduleid) { // BUILD BUTTONS
				case 'stockcard': case 'stype': case 'taxmenu': case 'itemclass': case 'categories': case 'distribution': case 'collection': case 'stockgrp': case 'model': case 'part': case 'GJ': case 'DS': case 'AP': case 'CV': case 'PV': case 'terms': case 'AR': case 'CR': 
				case 'proj': case 'scheduler': case 'branch': case 'tbmasterfile': case 'manageitem': case 'colltype': case 'posstockcard': case 'ewtsetup':
				case 'principal': case 'quotation':
				case 'fg_colors': case 'fg_material': case 'fg_cylinder': case 'fg_process': case 'FG':
				case 'prodtype': case 'transform': case 'sealing': case 'plastic':
				case 'prodspec': case 'inout': case 'reject': case 'mlocation':
					if(typeof type === "undefined" || type === null) {
						var newrowbuttons = {'save':'<a class="'+saveclass+' btn btn-social-icon btn-bitbucket" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i></a>',
											'cancel':'<a class="stockcanceladdbtn btn btn-social-icon btn-github" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-times" style="font-size:12px;margin-top:-8px;"></i></a>'};
					} else {
						var newrowbuttons = {'save':'<a class="'+saveclass+' btn btn-social-icon btn-bitbucket" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i></a>',
											'cancel':'<a class="stockcanceladdbtn btn btn-social-icon btn-github" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-times" style="font-size:12px;margin-top:-8px;"></i></a>'};
					}
				break;
				default:
					if(typeof type === "undefined" || type === null) { 
						var newrowbuttons = {'save':'<a class="'+saveclass+' btn btn-social-icon btn-bitbucket" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i></a>',
										'cancel':'<a class="stockcanceladdbtn btn btn-social-icon btn-github" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-times" style="font-size:12px;margin-top:-8px;"></i></a>',
										'showbalance':'<a class="showbalance btn btn-social-icon btn-github" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-eye" style="font-size:12px;margin-top:-8px;"></i></a>'};
					} else {
						var newrowbuttons = {'save':'<a class="'+saveclass+' btn btn-social-icon btn-bitbucket" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-save" style="font-size:12px;margin-top:-8px;"></i></a>',
										'cancel':'<a class="stockcanceladdbtn btn btn-social-icon btn-github" title="" txtclass="bodytextbox" style="width:18px;height:18px;margin-left:2px;margin-right:2px;"><i class="fa fa-times" style="font-size:12px;margin-top:-8px;"></i></a>'};
					}//end if
				break;
			}
		}//end switch
		
		var availbtns = '';
		hiddenbuttons = $.parseJSON($('.jadgridview-'+tableid).attr('hiddenbuttons'));
		hiddencheckbox = $.parseJSON($('.jadgridview-'+tableid).attr('hiddencheckbox'));
		hiddeninput = $.parseJSON($('.jadgridview-'+tableid).attr('hiddeninput'));
		template = $.parseJSON($('.jadgridview-'+tableid).attr('template'));
		newrow+= "<tr class='temprow' id='gvrow-"+i+"' style='background:"+this.editedcolor+";'>";
		
		$.each(template, function(index,key){
				if(key == 'buttons') {
					// BUTTONS
						if(hiddenbuttons.length > 0) {
							newrow+= "<td class='gv-options' style='text-align:center;'>";
								//NEW BUTTON SET (FOR NEW ROW)
								$.each(newrowbuttons,function(ndx,nbtn){
									newrow+= nbtn;
								});
								//AVAILABLE BUTTONS ON GRID VIEW
								$.each(hiddenbuttons,function(index,key){
									availbtns+= "<button title='"+this.title+"' tableid='"+this.tableid+"' class='"+this.class+"' txtclass='"+this.txtclass+"' style='"+this.style+"'>"+this.caption+"</button>";
								});
							newrow+= "</td>";
						}//end hidden button length
				} else if(key == 'checkbox') {
					// CHECKBOX
						if(hiddencheckbox.length > 0) {
							newrow+= "<td style='text-align:center;'>";
								$.each(hiddencheckbox,function(){
									newrow+= "<input type='checkbox' id='"+i+"' class='"+this.class+"'>";
								});
							newrow+= "</td>";
						}
				} else {
					// INPUTS
						if(hiddeninput.length > 0) {
							var styler = '';
							$.each(hiddeninput,function(){
								switch(this.type){
									case 'lookup':
										newrow+= "<td>";
										newrow+= '<div class="'+this.lookupbutton.colw+' input-group" style="margin-top:-3px;">';
										newrow+= '<input name="'+this.name+'" coltype="'+this.coltype+'" readonly value="'+this.placeholder+'" class="'+this.class+' '+this.lookupbutton.lookuptxtclass+' form-control input-sm " type="text">';
										newrow+= '<div style="padding:0px;height:21px;width:25px;" class="frmwh input-group-addon">';
										newrow+= '<a class="'+this.lookupbutton.lookupclass+'" lookup="'+this.lookupbutton.autocall+'" data-toggle="modal">';
										newrow+= '<i class="fa fa-chevron-circle-down" style="margin-right:3px;margin-left:3px;">';
										newrow+= '</i></a></div></div>';
										newrow+= "</td>";
									break;

									case 'elookup':
										newrow+= "<td>";
										newrow+= '<div class="'+this.lookupbutton.colw+' input-group" style="margin-top:-3px;">';
										newrow+= '<input name="'+this.name+'" coltype="'+this.coltype+'" value="'+this.placeholder+'" class="'+this.class+' '+this.lookupbutton.lookuptxtclass+' form-control input-sm " type="text">';
										newrow+= '<div style="padding:0px;height:21px;width:25px;" class="frmwh input-group-addon">';
										newrow+= '<a class="'+this.lookupbutton.lookupclass+'" lookup="'+this.lookupbutton.autocall+'" data-toggle="modal">';
										newrow+= '<i class="fa fa-chevron-circle-down" style="margin-right:3px;margin-left:3px;">';
										newrow+= '</i></a></div></div>';
										newrow+= "</td>";
									break;

									case 'datepicker':
										newrow += '<td>';
											newrow += '<div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="'+this.placeholder+'" class="input-group date dpYears '+this.class+'" style="margin-top:-3px;">';
											newrow += '<input type="text" name="'+this.name+'" style="margin-top:0px;" coltype="'+this.coltype+'" value="'+this.placeholder+'" class="form-control input-sm '+this.class+'" readonly>';
											newrow += '<div class="dateid-lookup input-group-addon add-on" style="padding:0px;height:18px;width:25px;"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>'
										newrow += '</td>';
									break;

									case 'checkbox':
										newrow += "<td>";
											newrow += "<input type='checkbox' for = '"+this.for+"' class='"+this.class+"' style='margin-top:-3px;'>";
										newrow += "</td>";
									break;

									case 'text': case 'hidden': case 'number':
										if(this.type == "hidden"){
											styler = "style='display:none;'";
										} else {
											styler = '';
										}//end if
										newrow+= "<td "+styler+">";
										if(this.readonly === true) {
											newrow+= "<input type='"+this.type+"' id='"+i+"' name='"+this.name+"' class='"+this.class+"' coltype='"+this.coltype+"' value='"+this.placeholder+"' readonly>";
										} else {
											newrow+= "<input type='"+this.type+"' id='"+i+"' name='"+this.name+"' class='"+this.class+"' coltype='"+this.coltype+"' value='"+this.placeholder+"'>";
										}
										newrow+= "</td>";
									break;
								}//end switch
							});
						}
				}//end if else
		});//end for each
		this.availablebtns = availbtns;

		newrow+= "</tr>";
		$('.jadgridview-'+tableid+' tbody').append(newrow);
		$('.dpYears').datepicker();
		$('.dpMonths').datepicker();
		this.totalrowcount += 1;
	},//end function
	plotNewRowData:function(line,data){
		//LOOPS THROUGH THE ARRAY OF ROWS
		$.each(data.primarydata, function(index,x){
			//LOOPS ATTRIBUTES INSIDE A ROW ARRAY
			$.each(x, function(name,y){
				$('#gvrow-'+line+'.temprow input[coltype="'+name+'"]').val(y);
			});//end for each
		});//end for each
	},//end function
	checkForSaveableRows: function(){
		if($(this.initdiv+' table tbody tr').hasClass('edited') || $(this.initdiv+' table tbody tr').hasClass('temprow')){
			return true;
		}else{
			return false;
		}//END IF
	},//end function
	plotUpdatedRowData: function(row,stockline){
		if(stockline['savingtype'] == "add"){

			$.each(stockline, function(name,x){
				$('#'+row+'.temprow input[coltype="'+name+'"]').val(x);
			});//end for each
			
			$('#'+row+'.temprow').css('background','');
			$('#'+row+'.temprow .gv-options').html(this.availablebtns);
				$('#'+row+'.temprow').prop('id','gvrow-'+stockline['line']).addClass('merow');
			$('#gvrow-'+stockline['line']+'.temprow.merow').removeClass();

		}else{
			$.each(stockline, function(name,x){
				$('#'+row+' input[coltype="'+name+'"]').val(x);
			});//end for each
			$('#'+row).css('background','').removeClass('edited');
		}//end if
		$('#overlay').css('display','none');
	},//end function
	getTemprowIndex:function(){
		this.temprowcount +=1;
		return this.temprowcount;
	},//end ufnction
	changeRowColor:function(rowobj){
		if(rowobj.hasClass('temprow') === false && rowobj.hasClass('edited') === false) {
			rowobj.addClass('edited').css({'background':this.editedcolor});
		}//end function
	},//end function
	saveAllButtons:function(type){
		//DEFAULT PARAMETER WILL SHOW ALL SAVE ALL BUTTONS
		switch(type){
			case 'hide':
				$('.stocksaveall').css('display','none');
				$('.detailsaveall').css('display','none');
			break;

			default:
				$('.stocksaveall').css('display','block');
				$('.detailsaveall').css('display','block').prop('disabled',false);
			break;
		}//end swtich
	},
	enterGridviewEditingMode:function(){
		if($(".module-btnheadcollapse" ).hasClass('headediting')){
			$('#overlay').css('display','block');
			$( ".module-btnheadcollapse").trigger( "click" );
		}//end if
	},//end function
	triggerGridviewEvent:function(parentrow,eventtype,autocall){
		var me = this;
		me.enterGridviewEditingMode();
		if(typeof autocall === "undefined" || autocall === null) { 
			autocall = "";
		}//end if

		if(!parentrow.hasClass('edited')) {
			verifyaccess('clickedititem', function(data) {
				if(data){
					switch(eventtype){
						case 'lookup':
							var temprow = parentrow.hasClass('temprow');
							if(temprow === false) {
								var formval = parentrow.find('.bodytextbox').serializeArray();
								// alert(parentrow.find('input[coltype=wh]').attr('value'));
								
								//TODO: UPDATE THIS PART
								//THIS IS FUNCTION WAS REVISED TO BE A PROMISE
								//UPDATES TIL line 328
								checkrowrecord(formval,parentrow,function(data){
									plotcheckrowrecords(data,parentrow,'lookup',autocall);
								});
								//update function end
							} else {
								me.triggerLookup(autocall,parentrow);
							}
						break;

						case 'textedit':
							me.triggerTextEditing(parentrow);
						break;
					}//end switch

				}else{
					generateAlert('error','Invalid Access!','ERROR');
				}//end if
			});
		} else {
			switch(eventtype){
				case 'lookup':
					me.triggerLookup(autocall,parentrow);
				break;

				case 'textedit':
					me.triggerTextEditing(parentrow);
				break;
			}//end switch
		}//end if
	},
	triggerLookup:function(autocall,row){
		switch(autocall){
			case 'expiry':
				var barcode = row.children('td').children('input[coltype="barcode"]').val();
				var factor = row.children('td').children('input[coltype="uomfactor"]').val();
				modulemodals.popup('modal-loclookup');
				loadAvailableLocations(barcode,factor);
				$('body').data("loc-plotlocation",row);
				$('#modal-loclookup .aims-lookup-title').html('Expiry');
			break;
			case 'location':
				var barcode = row.children('td').children('input[coltype="barcode"]').val();
				var factor = row.children('td').children('input[coltype="uomfactor"]').val();
				modulemodals.popup('modal-loclookup');
				loadAvailableLocations(barcode,factor);
				$('body').data("loc-plotlocation",row);
				$('#modal-loclookup .aims-lookup-title').html('Location');
			break;

			case 'ewt':
				modulemodals.popup('modal-ewtlookup');
				loadAvailableEWTs();
				varstorage.data("ewt-plotlocation",row);
			break;

			case 'warehouse':
				modulemodals.popup('modal-whlookup');
				$('body').data("wh-plotlocation",row);
			break;

			case 'uom':
				var itemid = row.children('td').children('input[coltype="itemid"]').val();
				$('.uomformnew').hide();
				$('#modal-uomlookup').modal();
				loadUOMlookup(itemid);
				$('body').data("uom-plotlocation",row);
			break;

			case 'contra':
				$('body').data('parentrow',row);
				$('body').data('coatype','stock');
				$('#modal-contra').modal();
			break;
		}//end swtich case autocall modals
	},
	triggerTextEditing:function(row){
		// var me = this;
		// $(document).on('focusin','.bodytextbox',function(event){
		// 	rowparent = $(this).closest("tr");
		// 	$(this).data('val', $(this).val());
		// }).on('change','.bodytextbox',function(event){
		// }).on('blur','.bodytextbox',function(event){
		// 	rowparent = $(this).closest("tr");
		// 	var prev = $(this).data('val'),
		// 		current = $(this).val(),
		// 		moduleid = $('#viewmoduleid').val();
		// 	if(prev != current){
		// 		if(rowparent.hasClass('edited')) {
		// 			me.changeRowColor(rowparent);
		// 			me.saveAllButtons();
		// 		} else {
		// 			checkrowrecord(rowparent);
		// 		}
		// 	}//end if
		// });
		// $('#overlay').hide();
	},//end function
}//end GridViewGenerator prototype


$(document).on('focusin','.bodytextbox',function(){
	$(this).data('val',$(this).val());
}).on('blur','.bodytextbox',function(){
	rowparent = $(this).closest('tr'),
	inputname = $(this).attr('coltype');

	var prev = $(this).data('val'),
		current = $(this).val(),
		moduleid = $('#viewmoduleid').val();

	if(inputname != 'barcode'){
		if(prev != current) {
			var edited = rowparent.hasClass('edited'), temprow = rowparent.hasClass('temprow');
			if(edited === true && temprow === false) {
				stockview.changeRowColor(rowparent);
				stockview.saveAllButtons();
			} else {
				if(temprow === false) {
					var formval = rowparent.find('input.bodytextbox').serializeArray();
					$.each(formval,function(index,val){
						if(val.name == inputname) {
							val.value = prev;
						}
					});
					
					//TODO: UPDATE THIS PART
					//THIS IS FUNCTION WAS REVISED TO BE A PROMISE
					//UPDATES TIL line 444
					checkrowrecord(formval,rowparent,function(data){
						plotcheckrowrecords(data,rowparent,'textedit','');
					});
					//end update
				}//end if ;v; 4
			}//end if lvl 3
		}//end if lvl 2
	
	}//end if
});

//FOR CHECKING AND ENABLING VALUES OF CHECKBOX - JAO 9/1/2018 11:35:44 AM
function enableCheckboxValues(gridid) {
	$(gridid+' tbody tr').each(function(){
		var tr = $(this).attr('id');
		$('#'+tr+':not(.temprow) input:checkbox').each(function(){
			var forv = $(this).attr('for');
			var forval = $('#'+tr+':not(.temprow) input[coltype='+forv+']').val();

			if(forval == 1){
				$(this).prop('checked',true);
			}else{
				$(this).prop('checked',false);
			}//end if
		});//end each
	});//end each
}//end f

//FOR SEARCHING ROW CHECKBOXES AND UPDATE IT CONNECTED HIDDEN TEXTBOX - JAO 9/1/2018 11:36:11 AM
function searchRowCheckboxes(rowid,istemp){
	//input:checkbox
	if(istemp == 1){
		$('#'+rowid+'.temprow input:checkbox').each(function(){
			if($(this).is(':checked')){ 
				$('#'+rowid+'.temprow input[coltype="'+$(this).attr('for')+'"]').val(1);
			}else{ 
				$('#'+rowid+'.temprow input[coltype="'+$(this).attr('for')+'"]').val(0);
			}//end if
		});
	}else{
		$('#'+rowid+':not(.temprow) input:checkbox').each(function(){
			if($(this).is(':checked')){ 
				$('#'+rowid+':not(.temprow) input[coltype="'+$(this).attr('for')+'"]').val(1);
			}else{ 
				$('#'+rowid+':not(.temprow) input[coltype="'+$(this).attr('for')+'"]').val(0);
			}//end if
		});
	}//end if
}//end f

//TODO: UPDATE THIS PART 
//THIS IS FUNCTION WAS REVISED TO BE A PROMISE
//UPDATES TIL line 473
function checkrowrecord(formval,row,callback) {
	var arrval = {}, 
		temp_stockarraydata = {}, 
		moduleid = $('#viewmoduleid').val();

		formval.push({name:'trno',value:$('.txtboxtrno').val()});
		formval.push({name:'doc',value:moduleid});
		formval.push({name:'parentrow',value:row.attr('id')});
	
	$.each(formval,function(indexx,datum){
		arrval[datum['name']] = datum['value'];
	});//end .each
	
	$('.jaox').prop('disabled',true);
	$.get(domain+'/admin/checkrecord',arrval,function(data2){
		if(data2) {
		//data2 = $.parseJSON(data2);
			callback(data2);
		}else{
			console.log('ERROR OCCURED while checking rows');
		}//end data
	});//end $.get
}//end function

//TODO: UPDATE THIS PART 
//THIS IS FUNCTION WAS REVISED TO BE A PROMISE
//UPDATES TIL line 493
function plotcheckrowrecords(data2,row,type,autocall){
	var tr = row.attr('id');
	if(data2.stocklinedata[tr].changed === true) {
		stockview.plotUpdatedRowData(tr,data2.stocklinedata[tr]);
		$('#'+tr+':not(.temprow)').css('background','');
		generateAlert('warning','Row data is not latest, Row refreshed','ERROR');
	} else {
		if(type == 'textedit') {
			stockview.changeRowColor(row);
			stockview.saveAllButtons();
		} else {
			stockview.triggerLookup(autocall,row);
		}
	}
	$('.jaox').prop('disabled',false);
}//end function



$(document).on('click','.bodytextbox',debounce(function(event){
	stockview.enterGridviewEditingMode();
},500));


$(document).on('focusin','.txtuomlookup',function(event){
	rowparent = $(this).closest('tr');
	$(this).data('val',$(this).val());
}).on('change','.txtuomlookup',function(event){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val(),
		me = this;
	if(prev != current) {
		uomlookup.changeRowColor(rowparent);
	}
});

$(document).on('focusin','.costcentertxt',function(){
	$(this).data('val',$(this).val());
}).on('change','.costcentertxt',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		costcentergrid.changeRowColor(rowparent);
	}
});

$(document).on('focusin','.jbmaterialtxt',function(){
	$(this).data('val',$(this).val());
}).on('change','.jbmaterialtxt',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		showmaterialtab.changeRowColor(rowparent);
	}
});

$(document).on('focusin','.jbprocesstxt',function(){
	$(this).data('val',$(this).val());
}).on('change','.jbprocesstxt',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		showprocesstab.changeRowColor(rowparent);
	}
});

$(document).on('focusin','.reminderstxt',function(){
	rowparent = $(this).closest('tr');
	$(this).data('val',$(this).val());
}).on('change','.reminderstxt',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val(),
		me = this;
	if(prev != current) {
		reminderslookup.changeRowColor(rowparent);
	}
});

$(document).on('focusin','.mastertextbox',function(event){
	rowparent = $(this).closest('tr');
	$(this).data('val',$(this).val());
}).on('change','.mastertextbox',function(event){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val(),
		me = this;
	if(prev != current) {
		masterfilegrid.changeRowColor(rowparent);
	}
});

$(document).on('focusin','.changeitemtxt',function(){
	$(this).data('val',$(this).val());
}).on('change','.changeitemtxt',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val(),
		me = this;
	if(prev != current) {
		changeitemgrid.changeRowColor(rowparent);
	}
});


$(document).on('focusin','.docpreftext',function(){
	$(this).data('val',$(this).val());
}).on('change','.docpreftext',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		stockview.changeRowColor(rowparent);
	}
});

$(document).on('focusin','.comptextbox',function(){
	$(this).data('val',$(this).val());
}).on('change','.comptextbox',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		componentslookup.changeRowColor(rowparent);
	}
});

$(document).on('focusin','.termstextbox',function(){
	$(this).data('val',$(this).val());
}).on('change','.termstextbox',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		stockview.changeRowColor(rowparent);
	}
});

$(document).on('focusin','.annontextbox',function(){
	$(this).data('val',$(this).val());
}).on('change','.annontextbox',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		tblanon.changeRowColor(rowparent);
	}
});



$(document).on('focusin','.tablestextbox',function(){
	$(this).data('val',$(this).val());
}).on('change','.tablestextbox',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		tablesgrid.changeRowColor(rowparent);
	}//end if
});

$(document).on('click','.chkisinactivetable',function(){
	rowparent = $(this).closest('tr');
	tablesgrid.changeRowColor(rowparent);
});

$(document).on('click','.chkewt,.chkvat',function(){
	rowparent = $(this).closest('tr');
	stockview.changeRowColor(rowparent);
});

$(document).on('click','.componentitemtextbox',function(){
	$(this).data('val',$(this).val());
}).on('change','.componentitemtextbox',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		componentmenugrid.changeRowColor(rowparent);
	}
});

$(document).on('click','.setmenuchoicestxt',function(){
	$(this).data('val',$(this).val());
}).on('change','.setmenuchoicestxt',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		setmenugrid.changeRowColor(rowparent);
	}
});

$(document).on('click','.branchstationtextbox',function(){
	$(this).data('val',$(this).val());
}).on('change','.branchstationtextbox',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		branchstationgrid.changeRowColor(rowparent);
	}
});

$(document).on('click','.branchbrandtextbox',function(){
	$(this).data('val',$(this).val());
}).on('change','.branchbrandtextbox',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		branchbrandgrid.changeRowColor(rowparent);
	}
});

$(document).on('click','.branchbanktextbox',function(){
	$(this).data('val',$(this).val());
}).on('change','.branchbanktextbox',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		branchbankgrid.changeRowColor(rowparent);
	}
});


$(document).on('focusin','.ewttextbox',function(){
	$(this).data('val',$(this).val());
}).on('change','.ewttextbox',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		stockview.changeRowColor(rowparent);
	}
});

$(document).on('focusin','.principaltextbox',function(){
	$(this).data('val',$(this).val());
}).on('change','.principaltextbox',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		stockview.changeRowColor(rowparent);
	}
});

// WTODO G
$(document).on('focusin','.fgtextbox2',function(){
	$(this).data('val',$(this).val());
}).on('change','.fgtextbox2',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		fgtabgrid2.changeRowColor(rowparent);
	}
});
$(document).on('focusin','.fgtextbox4',function(){
	$(this).data('val',$(this).val());
}).on('change','.fgtextbox4',function(){
	rowparent = $(this).closest('tr');
	var prev = $(this).data('val'),
		current = $(this).val();
	if(prev != current) {
		fgtabgrid4.changeRowColor(rowparent);
	}
});