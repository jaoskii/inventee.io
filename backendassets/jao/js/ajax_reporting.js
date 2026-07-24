var varstorage = $("body");

function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

$(document).ready(function(){
   var rptname = '';
   var formfilters = [];
   //ENABLE WHEN EDITING VICTORY SOURCE - JAO 12/27/2018 11:55:17 AM
   /*if($('#rptname').val() != ''){
   		rptname = $('#rptname').val();
   		//SWITCH CASE PER REPORTS
   		switch(rptname){
   			case 'Daily Collection (Victory Mall)':
   				generateReport_Inputs(rptname,function(data){
		   			var loops = 0;
					var afterloops = 0;
					var splice_min = 0;
					var splice_max = 3;
					var addons = {}; //PUT ADD ON PARAMS (e.g date, type, report format)
					$.each(data.transfilters, function(i, x) {
						formfilters.push(x);
					});//end each

					loops = formfilters.length / 3;
					$('#modal-loading').modal();
					$('.progress-msg').html('GENERATING REPORT (<span id="progressbatch">'+parseInt(afterloops)+'</span>/'+parseInt(Math.ceil(loops))+')');
					varstorage.data('progressbar-load',0);
					generateReport_Output(rptname,splice_min,splice_max,afterloops,Math.ceil(loops),formfilters,addons);
		   		});
   			break;
   		}//end switch
   		
   }//end if*/
});


function generateReport_Inputs(reportname,callback){
	$.get(domain+'/reports/getinputs',{rpt:reportname},function(data){
		//data = $.parseJSON(data);
		callback(data);
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  	});
}//end f


function generateReport_Output(rpt,min,max,loops,mloops,params,addons){
	var addedprogress = 100/parseFloat(mloops);
	var oldprogress = varstorage.data('progressbar-load');
	var currentprogress = (parseFloat(oldprogress) + parseFloat(addedprogress))+'%';
	varstorage.data('progressbar-load',currentprogress);
	$('#overlay').css('display','block');		

	$.get(domain+'/reports/getoutputs',{rpt:rpt,params:params.slice(min,max),addons:addons},function(data){
		//data = $.parseJSON(data);
		min += 3;
		max += 3;

		if(max > params.length){
			max = params.length;
		}//end if

		loops += 1;

		if(loops < mloops){
    		$('#progressbatch').html(parseInt(loops));
    		$('#progressbar-load').css('width',varstorage.data('progressbar-load'));
    		generateReport_Output(rpt,min,max,loops,mloops,params);
    	}else{
    		$('#overlay').css('display','none');		
    		$('#modal-loading').modal('hide');
    		varstorage.removeData('progressbar-load');
    		$('#progressbar-load').css('width','0%');
    	}//end if
	}).fail(function (jqXHR, textStatus, error) {
		generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  	});
}//end f