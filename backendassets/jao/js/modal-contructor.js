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

			
			strg += '<div class="modal fade" id="'+index+'" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">';
			switch(this.size){
				case 'min':
					strg += '<div class="modal-dialog modal-sm">';
				break;

				case 'med':
					tstrg += '<div class="modal-dialog modal-md">';
				break;

				case 'max':
					strg += '<div class="modal-dialog modal-lg">';
				break;

				default:
					strg += '<div class="modal-dialog modal-md">';
				break;
			}//end switch

			strg += '<div class="modal-content">';
			if(this.headtitle != ''){
				strg += '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
				strg +='<h4 class="modal-title aims-lookup-title" id="myModalLabel">'+this.headtitle+'</h4>';
				strg +='</div>';
			}//end if

			strg +='<div class="modal-body">';
			
			if(this.tabletitle != ''){
				strg +='<label class="aims-lookup-title">'+this.tabletitle+'</label></br>';
			}//end if

			switch(this.modaltype){
				case 'html':
					$strg  += this.htmlcontent;
				break;

				case 'searchlookup':
					if($.isEmptyObject(this.searchfilters) || typeof this.searchfilters === "undefined" || this.searchfilters === null){
						strg += '<div class="input-group">';
				        strg += '</div>';
					}else{
						
						var colperfilter = 0;
						if(this.searchfilters.length > 1){
							//PER FILTER - SETS SIZE FOR EACH FILTER (MAX NUMBER OF FILTERS WILL BE BASED ON THE SIZE OF THE MODAL)
							colperfilter = 12 / this.searchfilters.length;
							strg += '<div class="row">'
							$.each(this.searchfilters,function(filtertype,filterproperties){
								strg += '<div class="col-md-'+colperfilter+'">';
								switch(filterproperties.type){
									case 'text':
									strg += '<div class="input-group">';
									strg += '<input value ="" type="'+filterproperties.type+'" class="'+filterproperties.txtclass+' input-sm form-control">';
									strg += '<div class="frmdocumentno input-group-addon"><i class="fa fa-search"></i></div>';
		      						strg += '</div>';
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
					}//end 
				break;

			}//end switch

			strg += '<div class="box box-solid '+this.bodyclass+'"></div>';
			strg +='</div>'; //END MODAL - BODY

			if($.isEmptyObject(this.footerbtns) || typeof this.footerbtns === "undefined" || this.footerbtns === null){

			}else{
				strg += '<div class="modal-footer aims-lookup-footer">';
					$.each(this.footerbtns,function(fbtn){
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

						strg += '<button type="button" class="'+this.btnclass+' btn btn-flat" '+this.closemodal+'>'+this.label+'</button>';
					});
		      	strg += '</div>';
			}//end if
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