//ANOTHER PROTOTYPE STRUCTURED CLASS
//COMBO OPTION LOADER 
//THIS CLASS HAS ALL THE OPTION LOADERS FOR COMBO BOXES NATURALLY USED BY TRANSACTIONAL MODULE COMBOBOXES 
function floatingChatbox(chatboxid){
	//PUT ADDITIONAL PROPERTIES HERE
	this.appendto = $('body');
	this.chatboxInstance = $('#'+chatboxid);
	this.chatboxID = chatboxid;
}//End function

floatingChatbox.prototype = {
	constructor: floatingChatbox,
	//functions
	createFloatingChatbox:function(){
		var chatsectionstr = '';
	    chatsectionstr += '<div id="'+this.chatboxID+'" class="chatbox chatbox--tray chatbox--empty">';
	    chatsectionstr += '<div class="chatbox__title">';
	    chatsectionstr += '<h5><a href="#">Customer Service</a></h5>';
	    chatsectionstr += '<button class="chatbox__title__tray"><span></span></button>';
	    chatsectionstr += '<button class="chatbox__title__close">';
	    chatsectionstr += '<span>';
	    chatsectionstr += '<svg viewBox="0 0 12 12" width="12px" height="12px">';
	    chatsectionstr += '<line stroke="#FFFFFF" x1="11.75" y1="0.25" x2="0.25" y2="11.75"></line>';
	    chatsectionstr += '<line stroke="#FFFFFF" x1="11.75" y1="11.75" x2="0.25" y2="0.25"></line>';
	    chatsectionstr += '</svg>';
	    chatsectionstr += '</span>';
	    chatsectionstr += '</button>';
	    chatsectionstr += '</div>';

	    chatsectionstr += '<div class="chatbox__body">';
		chatsectionstr += '<div class="chatbox__body__message chatbox__body__message--left">';
		chatsectionstr += '<img src="https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg" alt="Picture">';
		chatsectionstr += '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>';
		chatsectionstr += '</div>';
		chatsectionstr += '<div class="chatbox__body__message chatbox__body__message--right">';
		chatsectionstr += '<img src="https://s3.amazonaws.com/uifaces/faces/twitter/arashmil/128.jpg" alt="Picture">';
		chatsectionstr += '<p>Nulla vel turpis vulputate, tincidunt lectus sed, porta arcu.</p>';
		chatsectionstr += '</div>';

		chatsectionstr += '<div class="chatbox__body__message chatbox__body__message--left">';
		chatsectionstr += '<img src="https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg" alt="Picture">';
		chatsectionstr += '<p>Curabitur consequat nisl suscipit odio porta, ornare blandit ante maximus.</p>';
		chatsectionstr += '</div>';
		chatsectionstr += '<div class="chatbox__body__message chatbox__body__message--right">';
		chatsectionstr += '<img src="https://s3.amazonaws.com/uifaces/faces/twitter/arashmil/128.jpg" alt="Picture">';
		chatsectionstr += '<p>Cras dui massa, placerat vel sapien sed, fringilla molestie justo.</p>';
		chatsectionstr += '</div>';
		chatsectionstr += '<div class="chatbox__body__message chatbox__body__message--right">';
		chatsectionstr += '<img src="https://s3.amazonaws.com/uifaces/faces/twitter/arashmil/128.jpg" alt="Picture">';
		chatsectionstr += '<p>Praesent a gravida urna. Mauris eleifend, tellus ac fringilla imperdiet, odio dolor sodales libero, vel mattis elit mauris id erat. Phasellus leo nisi, convallis in euismod at, consectetur commodo urna.</p>';
		chatsectionstr += '</div>';
		chatsectionstr += '</div>';

		chatsectionstr += '<form class="chatbox__credentials">';
		chatsectionstr += '<div class="form-group">';
		chatsectionstr += '<label for="inputName">Name:</label>';
		chatsectionstr += '<input type="text" class="form-control" id="inputName" required>';
		chatsectionstr += '</div>';
		chatsectionstr += '<div class="form-group">';
		chatsectionstr += '<label for="inputEmail">Email:</label>';
		chatsectionstr += '<input type="email" class="form-control" id="inputEmail" required>';
		chatsectionstr += '</div>';
		chatsectionstr += '<button type="submit" class="btn btn-success btn-block">Enter Chat</button>';
		chatsectionstr += '</form>';
		chatsectionstr += '<textarea class="chatbox__message" placeholder="Write something interesting"></textarea>';
		chatsectionstr += '</div>';

		this.appendto.append(chatsectionstr);
	},
	
	dumpDetails:function(){
		console.log('This Chatbox ID is '+ this.chatboxID);
	},
}//end combooptionloader prototype



$(document).on('click','.chatbox__title',function(){
   var chatbox =  $(this).parents().eq(0);
   chatbox.toggleClass('chatbox--tray');
});

$(document).on('click','.chatbox__title__close', function(e) {
    var chatbox = $(this).parents().eq(1);
    e.stopPropagation();
    chatbox.addClass('chatbox--closed');
});

$(document).on('transitionend','.chatbox', function() {
    var chatbox = $(this).parents().eq(0);
    if(chatbox.hasClass('chatbox--closed')) chatbox.remove();
});

$(document).on('submit','.chatbox__credentials',function(e) {
    var chatbox =  $(this).parents().eq(0);
    console.log(chatbox);
    e.preventDefault();
    chatbox.removeClass('chatbox--empty');
});
