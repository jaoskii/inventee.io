// WTODO JAD 06-03-2019

function modalConstructor(...modalproperties){
	this.g = '';
	this.modalproperties = modalproperties;
	this.availablemodals = new Array();
}//End function

modalConstructor.prototype = {
	constructor: modalConstructor,
	create:function(index){
			var strg = '';
			var modalproperty;
			$.each(this.modalproperties,function(i,mdx){
				var mproperty = this;
				$.each(this,function(me){
					if(me == index){
						modalproperty = mproperty;
						return false;
					}//end if
				});//end for each
			});//end for each create modal

			$.each(modalproperty,function(i,mdx){
			if(typeof index === "undefined" || index === null) { 
					index = "";
			}//end if
			if(typeof this.size === "undefined" || this.size === null) { 
				this.size = "";
			}//end if

			if(typeof this.headtitle === "undefined" || this.headtitle === null) { 
				this.headtitle = "";
			}//end if

			if(typeof this.tabletitle === "undefined" || this.tabletitle === null) { 
				this.tabletitle = "";
			}//end if

			if(typeof this.modaltype === "undefined" || this.modaltype === null) { 
				this.modaltype = "default";
			}//end if

			if(typeof this.bodyclass === "undefined" || this.bodyclass === null) { 
				this.bodyclass = "default";
			}//end if

			if(typeof this.modalcontent === "undefined" || this.modalcontent === null) {
				this.modalcontent = "";
			}

			if(typeof this.footerLabels === "undefined" || this.footerLabels === null) {
				this.footerLabels = [];
			}

			strg += '<div class="modal fade" id="'+index+'" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">';
			switch(this.size){
				case 'min':
					strg += '<div class="modal-dialog modal-sm">';
				break;

				case 'med':
					strg += '<div class="modal-dialog modal-md">';
				break;

				case 'max':
					strg += '<div class="modal-dialog modal-lg">';
				break;

				default:
					strg += '<div class="modal-dialog modal-md">';
				break;
			}//end switch

			strg += '<div class="modal-content">';
			strg += '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			if(this.headtitle != ''){
				strg +='<h4 class="modal-title aims-lookup-title" id="myModalLabel">'+this.headtitle+'</h4>';
			}//end if
			strg +='</div>';
			
			

			strg +='<div class="modal-body">';
			
			if(this.tabletitle != ''){
				strg +='<label class="aims-lookup-title">'+this.tabletitle+'</label></br>';
			}//end if

			switch(this.modaltype){
				case 'html':
					strg  += this.htmlcontent;
				break;

				case 'searchlookup':
					if($.isEmptyObject(this.searchfilters) || typeof this.searchfilters === "undefined" || this.searchfilters === null){
						strg += '<div class="input-group">';
				        strg += '</div>';
					}else{
						var colperfilter = 0;
						if(this.searchfilters.length > 1){
							var searchfilterslen = this.searchfilters.length;
							//PER FILTER - SETS SIZE FOR EACH FILTER (MAX NUMBER OF FILTERS WILL BE BASED ON THE SIZE OF THE MODAL)
							strg += '<div class="row">'
							$.each(this.searchfilters,function(filtertype,filterproperties){
								if($.isEmptyObject(filterproperties.width) || typeof filterproperties.width === "undefined" || filterproperties.width === null) {
									colperfilter = 12 / searchfilterslen;
								} else {
									colperfilter = filterproperties.width;
								}
								if($.isEmptyObject(filterproperties.placeholder) || typeof filterproperties.placeholder === "undefined" || filterproperties.placeholder === null) {
									filterproperties.placeholder = '';
								}
								strg += '<div class="col-md-'+colperfilter+'">';
								switch(filterproperties.type){
									case 'select':
										strg += '<select class="form-control '+filterproperties.txtclass+'">';
											$.each(filterproperties.values,function(select,val){
												strg += '<option value="'+val.value+'">'+val.val+'</option>';
											});
										strg += '</select>';
									break;
									case 'text':
										strg += '<div class="input-group">';
										strg += '<input value ="" type="'+filterproperties.type+'" class="'+filterproperties.txtclass+' input-sm form-control" placeholder="'+filterproperties.placeholder+'">';
										strg += '<div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i></div>';
			      						strg += '</div>';
									break;
									case 'lookup':
										strg += '<div class="input-group">\
													<input readonly="true" name="" value ="" placeholder="'+filterproperties.placeholder+'" type="text" class="'+filterproperties.txtclass+' form-control input-sm">\
													<div class="input-group-addon"><a class ="'+filterproperties.aclass+'" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>\
												</div>';
									break;
									case 'date':
										strg += '<h6 class="aimslabel dateidlookup" style="margin-top:0;"><b>\
		                  							<div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="" class="paedit input-group date dpYears">\
		                    							<input type="text" name = "dateid" readonly="" value="" placeholder="'+filterproperties.placeholder+'" size="12" class="'+filterproperties.txtclass+' moduletxt form-control input-sm" disabled="true">\
		                    						<div class="dateid-lookup input-group-addon add-on"><a href="#"><i class="fa fa-chevron-circle-down"></i></a></div>\
		                  							</div></b>\
		                						</h6>';
									break;
									case 'button':
										strg += "<button class='"+filterproperties.txtclass+"'><i class='"+filterproperties.icon+"'></i> "+filterproperties.placeholder+"</button>";
									break;
								}//end switch case 
								strg += '</div>';
							});
							strg += '</div>';
						}else{
							//JUST PLOTS 1 FILTER . BUT SAME PROCESS OF LOOPING
							$.each(this.searchfilters,function(filtertype,filterproperties){
								switch(filterproperties.type){
									case 'text':
									strg += '<div class="input-group">';
									strg += '<input value ="" type="'+filterproperties.type+'" class="'+filterproperties.txtclass+' input-sm form-control">';
									strg += '<div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i></div>';
		      						strg += '</div>';
									break;
								}//end switch case 
							});
						}//end if
						strg += '<br>';

						var footLabels = '';
						if(this.footerLabels.length > 0){
							$.each(this.footerLabels,function(filtertype,filterproperties){
								footLabels += '<div class="row '+filterproperties.labelClass+'"><div class="col-md-12 "><h6>'+filterproperties.label+' <span class='+filterproperties.valueClass+'></span></h6></div></div>';
							});
						}//end if

						strg += '<div class="box box-solid '+this.bodyclass+'"></div>' + footLabels;
					}//end 
				break;
				case 'txtlookup':
					strg += "<div class='box box-solid'>";
					$.each(this.modalcontent,function(key,input) {
						if($.isEmptyObject(input.inputid) || typeof input.inputid === "undefined" || input.inputid === null) {
							input.inputid = '';
						}
						if($.isEmptyObject(input.inputclass) || typeof input.inputclass === "undefined" || input.inputclass === null) {
							input.inputclass = '';
						}
						if($.isEmptyObject(input.divclass) || typeof input.divclass === "undefined" || input.divclass === null) {
							input.divclass = '';
						}
						if($.isEmptyObject(input.style) || typeof input.style === "undefined" || input.style === null) {
							input.style = '';
						}
						if($.isEmptyObject(input.childdiv) || typeof input.childdiv === "undefined" || input.childdiv === null) {
							input.childdiv = '';
						}
						if($.isEmptyObject(input.value) || typeof input.value === "undefined" || input.value === null) {
							input.value = '';
						}
						
						if($.isEmptyObject(input.inputname) || typeof input.inputname === "undefined" || input.inputname === null) {
							input.inputname = '';
						}

						if($.isEmptyObject(input.readonly) || typeof input.readonly === "undefined" || input.readonly === null) {
							input.readonly = '';
						} else {
							input.readonly = 'readonly';
						}

						if($.isEmptyObject(input.hidden) || typeof input.hidden === "undefined" || input.hidden === null) {
							input.hidden = 'display:block;';
						} else {
							input.hidden = 'display:none;';
						}

						if($.isEmptyObject(input.inputcols) || typeof input.inputcols === "undefined" || input.inputcols === null) {
							input.inputcols = 0;
						}//end if

						if($.isEmptyObject(input.inputrows) || typeof input.inputrows === "undefined" || input.inputrows === null) {
							input.inputrows = 4;
						}//end if

						strg += "<div class='row "+input.divclass+"' style='"+input.style+"'>";
							if($.isEmptyObject(input.label) || typeof input.label === "undefined" || input.label === null) {
								var inputdiv = '12';
							} else {
								strg += "<div class='col-md-4'>";
									strg += "<h6 class='aimslabel'><b>"+input.label+"</b></h6>";
								strg += "</div>";
								var inputdiv = '8';
							}
							strg += "<div class='col-md-"+inputdiv+" "+input.childdiv+"'>";
								switch(input.type) {
									case 'button':
										strg += '<button class="'+input.inputclass+'" style="'+input.style+'" id="'+input.inputid+'" name="'+input.inputname+'"><i class="'+input.icon+'"></i> '+input.label+'</button>';
									break;
									case 'img':
										strg += '<img src="" class="'+input.inputclass+'" style="'+input.style+'" id="'+input.inputid+'" name="'+input.inputname+'">';
									break;
									case 'textarea':
										strg += '<textarea '+input.readonly+' rows = '+input.inputrows+' cols = '+input.inputcols+' class="'+input.inputclass+' form-control" id="'+input.inputid+'" name="'+input.inputname+'" style="resize:none;'+input.hidden+'"></textarea>';
									break;
									case 'labelfull':
										strg += '<h6>'+input.value+'</h6>';
									break;
									case 'label':
										strg += '<h6 id="'+input.inputid+'" style="'+input.style+' '+input.hidden+'" class="'+input.inputclass+'">'+input.value+'</h6>';
									break;
									case 'hidden':
										strg += '<input type="hidden" name="'+input.inputname+'" class="'+input.inputclass+'" value="" id="'+input.inputid+'">';
									break;
									case 'password':
										strg += '<input '+input.readonly+' style="'+input.hidden+'" type="password" name="'+input.inputname+'" id="'+input.inputid+'" class="'+input.inputclass+' input-sm form-control" id="'+input.inputid+'">';
									break;
									case 'text':
										strg += "<input type='text' "+input.readonly+" style='"+input.hidden+"' id='"+input.inputid+"' class='"+input.inputclass+" form-control input-sm' name='"+input.inputname+"'>";
									break;
									case 'select':
										strg += "<select name='"+input.inputname+"' id='"+input.inputid+"' style='"+input.hidden+"' class='"+input.inputclass+"'></select>";
									break;
									case 'textwithicon':
										strg += '<div class="input-group">';
											strg += '<input value ="" type="text" class="'+input.inputclass+' input-sm form-control">';
											strg += '<div class="input-group-addon"><i class="fa '+input.icontype+'"></i></div>';
			      						strg += '</div>';
									break;
									case 'a':
										strg += '<a href="#" class="'+input.inputclass+'" id="'+input.inputid+'" style="'+input.style+'">'+input.value+'</a>';
									break;
									case 'date':
										strg += "<div data-date-viewmode='days' data-date-format='yyyy-mm-dd' data-date=''  class='input-group date dpYears' style='"+input.hidden+"'>";
	                  						strg += "<input type='text' name='dateid' style='"+input.hidden+"' readonly='' size='12' class='"+input.inputclass+" form-control input-sm' disabled='true'>";
	                  						strg += "<div class='dateid-lookup input-group-addon add-on' style='"+input.hidden+"'><a href='#'><i class='fa fa-chevron-circle-down'></i></a></div>";
                						strg += "</div>";
									break;
									case 'lookup':
										strg += '<div class="input-group">';
											strg += '<input readonly="true" name="'+input.inputname+'" value ="" type="text" class="'+input.inputclass+' form-control input-sm">';
											strg += '<div class="input-group-addon"><a class ="'+input.btnclass+'" href="#"><i class="fa fa-chevron-circle-down"></i></a></div>';
										strg += '</div>';
									break;
									case 'timepicker':
										strg += '<div class="form-group">';
											strg += '<div class="input-group">';
												strg += '<input type = "text" class="'+input.inputclass+' input-sm form-control timepicker" name="'+input.inputname+'" value="00:00" id="'+input.inputid+'">';
												strg += '<div class="input-group-addon">';
													strg += '<i class="fa fa-clock-o"></i>';
												strg += '</div>';
											strg += '</div>';
										strg += '</div>';
									break;
									default:

									break;
								}
							strg += "</div>";
						strg += "</div>";
					});
					strg += "</div>";
					// console.log(strg);
				break;
				default:
					strg += '<div class="box box-solid '+this.bodyclass+'"></div>';
				break;
			}//end switch
			strg +='</div>'; //END MODAL - BODY
			if(typeof this.footerbtns === "undefined" || this.footerbtns === null) {
				
			} else {
				strg += '<div class="modal-footer aims-lookup-footer">';
					$.each(this.footerbtns,function(fbtn){
						if(this != ""){
							if($.isEmptyObject(this.btnid) || typeof this.btnid === "undefined" || this.btnid === null) {
								this.btnid = '';
							}
							if(typeof this.btnclass === "undefined" || this.btnclass === null) { 
								this.btnclass = "";
							}//end if
							if(typeof this.label === "undefined" || this.label === null) { 
								this.label = "Click Me";
							}//end if
							if(typeof this.closemodal === "undefined" || this.closemodal === null) { 
								this.closemodal = '';
							}else if(this.closemodal){
								this.closemodal = 'data-dismiss="modal"';
							}else{
								this.closemodal = '';
							}//end if

							strg += '<button type="button" id="'+this.btnid+'" class="'+this.btnclass+' btn btn-flat" '+this.closemodal+'>'+this.label+'</button>';
						}//end if
					});
		      	strg += '</div>';
			}
			strg += '</div></div></div>';//LAST CLOSING
			});//end for each create modal

			this.g = strg;
			$('body').append(this.g);
	},//end function
	checkModalAvailability:function(){

	},//end action
	remove:function(modal){
		$('#'+modal).remove();
	},//end function
	popup:function(index,zindex){
		var me = this;
		if(typeof zindex === "undefined" || zindex === null) { 
			$('#'+index).modal().css('z-index',zindex);
		}else{
			$('#'+index).modal();
		}//end if
		console.log(this.modalproperties);
		$('#'+index+' .box.box-solid').html('<br><br><br><br><br><br><br><br><br>');
	},//end function
	popdown:function(index){
		$('#'+index).modal('hide');
	},
	dumpmodals:function(){
		$.each(this.modalproperties,function(i,mdx){
			console.log(this);
		});//end for each create modal
	},//end funciton
	setLoadingPreloader:function(styler,preloaderurl){
		//SET YOUR OWN PATH FOR DEFAULT PRELOADER
		var preloader = "";
		if(typeof preloaderurl === "undefined" || preloaderurl === null) { 
			preloader = "<img src='"+domain+"/backendassets/img/loading.gif' style='"+styler+"'>";
		}else{
			preloader = "<img src='"+preloaderurl+"' style='"+styler+"'>";
		}//end if
		return preloader;
	},//end function
}//end combooptionloader prototype