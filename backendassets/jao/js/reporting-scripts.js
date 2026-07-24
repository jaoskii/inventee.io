//MODULE BTN PRINT EVENT (MODULE)
$(document).on('click','.module-btnprint',debounce(function(){
	var moduleid = $('#viewmoduleid').val();
	switch(cconfig){
		case 'UNIVERSE':
			if(moduleid == 'SJ'){
				if($(".txtcheckcode").val() == '' || $(".txtpickcode").val() == ''){
					generateAlert('error','Please put Picker / Checker first. Try again.','ERROR');
				}else{
					verifyaccess('print', function(data) {
						if(data){
							showPrintModulemodal(moduleid);
						}else{
							generateAlert('error','Invalid Access!','ERROR');
						}//end if verfied
					});
				}//end if
			}else{
				verifyaccess('print', function(data) {
					if(data){
						showPrintModulemodal(moduleid);
						if($('#modulestockview').attr('poststatus') != 1){
							$('.module-btnpost').click();
						}//end if
					}else{
						generateAlert('error','Invalid Access!','ERROR');
					}//end if verfied
				});
			}//end if
		break;

		default:
			verifyaccess('print', function(data) {
				if(data){
					var moduleid = $('#viewmoduleid').val();
					showPrintModulemodal(moduleid);
				}else{
					generateAlert('error','Invalid Access!','ERROR');
				}//end if verfied
			});
		break;
	}//end switch
},300));

//FUNCTION THAT MAKES / SHOWS MODULE MODAL FOR PRINTING
function showPrintModulemodal(moduleid){
	switch(moduleid){
		case 'SP':
			var trno = $('.txtboxtrno').val();
			$('#SPmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		//JLY route form
		case 'RF':
		var trno = $('.txtboxtrno').val();
			$('#RFmod-report').modal();
			$('#report-txttrno').val(trno);

		case 'TX':
		var trno = $('.txtboxtrno').val();
			$('#TXmod2-report').modal();
			$('#report-txttrno').val(trno);
		break;


		case 'quotation':
			var trno = $('.txtboxtrno').val();
			$('#quotemod-report').modal();
			$('.quotewithout').hide();
			$('.quotewith').hide();
			$('.radio').show();
			$('#report-txttrno').val(trno);
			$('#report-txttrno2').val(trno);
		break;

		case 'QA':
		var trno = $('.txtboxtrno').val();
			$('#QAmod-report').modal();
			$('#report-txttrno').val(trno);
		break;

		//SALES
		case 'SO':
		var trno = $('.txtboxtrno').val();
			$('#SOmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		

		case 'SJ': case 'SJ2':
		var trno = $('.txtboxtrno').val();
			$('.wobatch').hide();
			$('.wbatch').hide();
			$('.drcharge').hide();
			$('.pickslip').hide();
			$('.univopt').hide();

			switch(cconfig){
				case 'UNIVERSE':
					$('.DR').hide();
					$('.univopt').show();

					var picker = $(".txtpickcode").val().split('~');
					var checker = $(".txtcheckcode").val().split('~');
					$(".printpickedby").val(picker[1]);
					$(".printcheckedby").val(checker[1]);
				break;
			}//end if

			$('#SJmod-report').modal();
			$('.radio').show();
			$('#report-txttrno').val(trno);
			$('#report-txttrno1').val(trno);
			$('#report-txttrno2').val(trno);
			$('#report-txttrno3').val(trno);
			$('#report-txttrno4').val(trno);
		break;

		case 'CM':
		var trno = $('.txtboxtrno').val();
			$('#CMmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		//PURCHASES
		case 'PR':
		var trno = $('.txtboxtrno').val();
			$('#PRmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'PO':
		var trno = $('.txtboxtrno').val();
			$('#POmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'RR':
		var trno = $('.txtboxtrno').val();
			$('#RRmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'DM':
		var trno = $('.txtboxtrno').val();
			$('#DMmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		//INVENTORY
		case 'IS':
		var trno = $('.txtboxtrno').val();
			$('#ISmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'PC':
		var trno = $('.txtboxtrno').val();
			$('#PCmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'AJ':
		var trno = $('.txtboxtrno').val();
			$('#AJmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'TS':
		var trno = $('.txtboxtrno').val();
			$('#TSmod-report').modal();
			$('#report-txttrno').val(trno);
		break;

		// [KIM][2019.10.06][JO printout]
		case 'JB':
			var trno = $('.txtboxtrno').val();
			$('#JBmod-report').modal();
			$('.JBjoborder').hide();
			$('.JBblowing').hide();
			$('.JBmatreq').hide();
			$('.JBdailydel').hide();
			$('.JBslitlaminate').hide();
			$('.JBprinting').hide();
			$('.JBcuttingreject').hide();
			$('.JBinspect').hide();
			$('.radio').show();
			$('#report-txttrno').val(trno);
			$('#report-txttrno2').val(trno);
			$('#report-txttrno3').val(trno);
			$('#report-txttrno4').val(trno);
			$('#report-txttrno5').val(trno);
			$('#report-txttrno6').val(trno);
			$('#report-txttrno7').val(trno);
			$('#report-txttrno8').val(trno);
		break;

		// [KIM][2019.11.20][update cv case]
		case 'CV':
		var trno = $('.txtboxtrno').val();
			$('#CVmod-report').modal();

			switch(cconfig){
				case 'MLCP':
					$('.txtparams').hide();
					$('.txt2params').hide();
					$('.optparams').hide();
					$('.opt2params').hide();
					$('.radio').show();
					$('#report-txttrno').val(trno);
					$('#report-txttrno2').val(trno);
					$('#report-txttrno3').val(trno);
					$('#report-txttrno4').val(trno);
				break;
				case 'RTT':
					$('.txtparams').hide();
					$('.radio').show();
					$('#report-txttrno').val(trno);
				break;

				default:
					$('.txtparams').hide();
					$('.txt2params').hide();
					$('.opt2params').hide();
					$('.optparams').hide();
					$('.radio').show();
					$('#report-txttrno').val(trno);
					$('#report-txttrno3').val(trno);
				break;
			}//end if
					
		break;

		//PRODUCTION
		case 'PI':
		var trno = $('.txtboxtrno').val();
			$('#PImod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'PD':
		var trno = $('.txtboxtrno').val();
			$('#PDmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'PK':
		var trno = $('.txtboxtrno').val();
			$('#PKmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		//accounting
		case 'GJ':
		var trno = $('.txtboxtrno').val();
			$('#GJmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'AP':
		var trno = $('.txtboxtrno').val();
			$('#APmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'AR':
		var trno = $('.txtboxtrno').val();
			$('#ARmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'DS':
		var trno = $('.txtboxtrno').val();
			$('#DSmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'CV':
		var trno = $('.txtboxtrno').val();
			$('#CVmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'PV':
		var trno = $('.txtboxtrno').val();			
			$('#PVmod-report').modal();

			$('.standard').hide();
			$('.bir').hide();
			$('.radio').show();
			$('#report-txttrno').val(trno);
			$('#report-txttrno2').val(trno);
		break;
		case 'CR':
		var trno = $('.txtboxtrno').val();
			$('#CRmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'KR':
		var trno = $('.txtboxtrno').val();
			$('#KRmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'agent':
		var trno = $('#clientid').val();
			$('#AGENTmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'warehouse':
		var trno = $('#clientid').val();
			$('#WAREHOUSEmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'customer':
		var trno = $('#clientid').val();
			$('#CUSTOMERmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'supplier':
		var trno = $('#clientid').val();
			$('#SUPPLIERmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		case 'stockcard':
			var trno = $('#itemid').val();
			$('#STOCKCARDmod-report').modal();
			$('#report-txttrno').val(trno);
			loadreportuom();
		break;

		// SALON MODIFICATION

		case 'TR':
		var trno = $('.txtboxtrno').val();
			$('#TRmod-report').modal();
			$('#report-txttrno').val(trno);
		break;

		case 'MI': case 'MX':
		// [KIM][2019.11.11][add option for MI printout]
		var trno = $('.txtboxtrno').val();
			$('#MImod-report').modal();
	
			$('.MIssue').hide();
			$('.WSlip').hide();
			$('.radio').show();
			$('#report-txttrno').val(trno);
			$('#report-txttrno1').val(trno);
		break;

		// END SALON

		case 'KL':
			var trno = 0;
			$('#KLmod-report').modal();
			$('#report-txttrno').val(trno);
		break;

		//KEYWORD LOCATION&VENDOR
		case 'location':
		var trno = $('#clientid').val();
			$('#LOCATIONmod-report').modal();
			$('#report-txttrno').val(trno);
		break;

		case 'vendor':
		var trno = $('#clientid').val();
			$('#VENDORmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		//KEYWORD LOCATION&VENDOR
		case 'TW':
		var trno = $('.txtboxtrno').val();
			$('#TWmod-report').modal();
			$('#report-txttrno').val(trno);
		break;
		default:
		break;
	}//END SWITCH
}//END SHOW PRINT MODAL

//PRINTS MODULE REPORT AND CLOSES THE MODAL
$(document).on('click','.report-btnprint',function(){
	var moduleid = $('#viewmoduleid').val();
	switch(cconfig){
		case 'SOUTHCENTRAL':
			switch(moduleid){
				case 'SJ': case 'AR': case 'AP': case 'PV': case 'CV':
					$(".module-btnpost").trigger("click");
				break;
			}//end switch
		break;
	}//end swtich
	$('.modal').modal('hide');
});// end report btn print



$(document).on('click','.report-btnok',function(){
	var moduleid = $('#viewmoduleid').val();	

	switch(moduleid){
		case 'SJ':
			if($('.DRwobatch').is(':checked')){
				$('.radio').hide();
				$('.wobatch').show();
				$('.wbatch').hide();
				$('.drcharge').hide();
				$('.pickslip').hide();
				$('.form_wobatch').submit();
				$('#SJmod-report').modal('hide');
    		}//end if
    		if($('.DRwbatch').is(':checked')){
    			$('.radio').hide();
				$('.wbatch').show();
				$('.wobatch').hide();
				$('.drcharge').hide();
				$('.pickslip').hide();
				$('.form_wbatch').submit();
				$('#SJmod-report').modal('hide');
    		}//end if
    		if($('.DRcharge').is(':checked')){
    			$('.radio').hide();
				$('.wbatch').hide();
				$('.wobatch').hide();
				$('.drcharge').show();
				$('.pickslip').hide();
				$('.form_drcharge').submit();
				$('#SJmod-report').modal('hide');
    		}//end if

    		if($('.DRpickslip').is(':checked')){
    			$('.radio').hide();
				$('.wbatch').hide();
				$('.wobatch').hide();
				$('.drcharge').hide();
				$('.pickslip').show();
    		}//end if

    		if($('.DRpickroll').is(':checked')){
				var trno = $('.txtboxtrno').val();
				$.get(domain+'/reports/sjpickroll',{q:trno},function(data){
						data = $.parseJSON(data);
						generateAlert('information', "Printing to POS Printer, Please wait..",'ERROR');
				}).fail(function (jqXHR, textStatus, error) {
					generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
			  	});
    		}//end if
		break;

		// [KIM][2019.10.06][job order printout]
		case 'JB':
			$('.radio').hide();
			if($('.JBjo').is(':checked')){
				$('.JBjoborder').show();
			}
			if($('.JBblow').is(':checked')){
				$('.JBblowing').show();
			}
			if($('.JBmreq').is(':checked')){
				$('.JBmatreq').show();
			}
			if($('.JBddaily').is(':checked')){
				$('.JBdailydel').show();
			}
			if($('.JBslitlam').is(':checked')){
				$('.JBslitlaminate').show();
			}
			if($('.JBprint').is(':checked')){
				$('.JBprinting').show();
			}
			if($('.JBcutrej').is(':checked')){
				$('.JBcuttingreject').show();
			}
			if($('.JBins').is(':checked')){
				$('.JBinspect').show();
			}
		break;
		
		// [KIM][2019.11.20][add case for CV]
		case 'CV':
			$('.radio').hide();

			switch(cconfig){
				case 'MLCP':
					if($('.voucher').is(':checked')){
						$('.txtparams').show();
					}
					if($('.voucherlx').is(':checked')){
						$('.txt2params').show();
					}
					if($('.check').is(':checked')){
						$('.optparams').show();
					}
					if($('.checklx').is(':checked')){
						$('.opt2params').show();
					}
				break;

				case 'RTT':
					$('.txtparams').show();
				break;

				default:
					if($('.voucher').is(':checked')){
						$('.txtparams').show();
					}
					
					if($('.check').is(':checked')){
						$('.optparams').show();
					}
				break;
			}//end if
		break;

		//[KIM][2019.11.11][add case for MI]
		case 'MI':
			$('.radio').hide();
			if($('.MI').is(':checked')){
				$('.MIssue').show();
			}
			if($('.WS').is(':checked')){
				$('.WSlip').show();
			}
		break;
		
		case 'quotation':
			$('.radio').hide();
			if($('.quotew').is(':checked')){
    			$('.quotewithout').hide();
				$('.quotewith').show();
    		}//end if
    		if($('.quotewo').is(':checked')){
    			$('.quotewithout').show();
			$('.quotewith').hide();
    		}//end if
		break;
		
		default:
			$('.radio').hide();
			if($('.birdo').is(':checked')){
    			$('.standard').hide();
				$('.bir').show();
    		}//end if
    		if($('.standrdo').is(':checked')){
    			$('.standard').show();
			$('.bir').hide();
    		}//end if
		break;
	}
});// end report btn ok

$(document).on('submit','#uniwobatchform,#uniwbatchform,#unidrchargeform',function(){
	if($('#modulestockview').attr('poststatus') != 1){
		$('.module-btnpost').click();
	}//end if
});


$(document).on('click','#checkallclassbox',function(){
	if($(this).is(":checked")){
		$('.mlcpcheckboxclass').prop('checked',true);
	}else{
		$('.mlcpcheckboxclass').prop('checked',false);
	}//end if
});// end report btn print

$(document).on('click','.fhilayoutreport',function(){
	var clickval = $(this).val();
	switch(cconfig){
		case 'FHI':
			switch(clickval){
				case '5':
					let wh = $('.txtwarehouse').val();
					$('.fhiwhfilter').css('display','block');
					$('.fhiwh').val(wh);
				break;

				default:
					$('.fhiwhfilter').css('display','none');
				break;
			}//end switch
		break;
	}//end switch
});// end report btn print