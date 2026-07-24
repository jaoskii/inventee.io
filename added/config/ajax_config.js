//#################################################GLOBAL VARIABLES
//FOR ONLINE
	var ajax_configuration = 'ONLINE'; // ONLINE = site root (Herd); OFFLINE = app in subdirectory


switch(ajax_configuration){
	case 'ONLINE':
		var domain = ''; 
	break;

	case 'OFFLINE':
		var pathname = window.location.pathname.split( '/' );
		var domain =  '/'+pathname[1];
	break;
}//end switch case