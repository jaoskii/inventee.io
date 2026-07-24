

function initializePOSShortcuts(){
    var elements = ["f1","f2","f3","f4","f5","f6","f7","f8","f9","f10","f11","f12"];
    
    //BIND EACH ELEMENTS
    $.each(elements, function(i, e) { // i is element index. e is element as text.
       var newElement = ( /[\+]+/.test(elements[i]) ) ? elements[i].replace("+","_") : elements[i];
       
       // Binding keys
       $(document).bind('keydown', elements[i], function assets() {
           retailFunctions(newElement); //TRIGGERS SHORTCUT TRIGGER
       });
    });
}//end if


$(document).on('click','.posretailbtn',debounce(function(){
	var x = $(this).attr('x');
	retailFunctions(x);
},300))

function retailFunctions(x){
	switch(x){
		case 'f1':
			alert('f1');
		break;
		case 'f2':
			alert('f2');
		break;
		case 'f3':
			alert('f3');
		break;
		case 'f4':
			alert('f4');
		break;
		case 'f5':
			alert('f5');
		break;
		case 'f6':
			alert('f6');
		break;
		case 'f7':
			alert('f7');
		break;
		case 'f8':
			alert('f8');
		break;
		case 'f9':
			alert('f9');
		break;
		case 'f10':
			alert('f10');
		break;
		case 'f11':
			alert('f11');
		break;
		case 'f12':
			alert('f12');
		break;
	}//end if
}//end f




