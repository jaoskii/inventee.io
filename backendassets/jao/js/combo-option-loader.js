//ANOTHER PROTOTYPE STRUCTURED CLASS
//COMBO OPTION LOADER 
//THIS CLASS HAS ALL THE OPTION LOADERS FOR COMBO BOXES NATURALLY USED BY TRANSACTIONAL MODULE COMBOBOXES 
function comboOptionLoader(){
	//PUT ADDITIONAL PROPERTIES HERE
	this.discrepancytype = {0:'PL',1:'L',2:'D',3:'R',4:'DM.CM',5:'C/A',6:'TR',7:'PS'};
}//End function

comboOptionLoader.prototype = {
	constructor: comboOptionLoader,

	loadAvailableDiscrepancyType:function(){
		dtype = this.discrepancytype;
		$('.discrepancytype option:not(:selected)').remove();
		$.each(dtype, function(modeindx, modename) {
			if(dtype[modeindx] != $('.discrepancytype option:selected').text()){
				$('.discrepancytype').append('<option>'+dtype[modeindx]+'</option>');
			}//END IF
		});
	},//end load available discrepancy type
}//end combooptionloader prototype