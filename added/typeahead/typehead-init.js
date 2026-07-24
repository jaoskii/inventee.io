var library = [];

function getSuggestionLibrary(){
  var q = $('#viewmoduleid').val();

  switch(q){
    case 'stockcard':
      var obj = $('.txtitemname');
    break;

    default:
      var obj = $('.txtclientnameview');
    break;
  }//end switch
  $.get(domain+'/admin/getlibrary',{q:q},function(data){
      data = $.parseJSON(data);
      if(data.dataset != ''){
          $.each(data.dataset, function(i,x) {
            library.push(x.page);
          });
      }//end if

      var bloodsource = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        //library: data set where typehead suggestions are searched.
        local: library
      });

      $(obj).typeahead({
        hint: true,
        highlight: true,
        minLength: 1,
      },{
        name: 'masterfiles',
        source: bloodsource
      });
  }).fail(function (jqXHR, textStatus, error) {
    generateAlert('error','System Error: Status Code ' +jqXHR.status,'ERROR');
  });
}//end f