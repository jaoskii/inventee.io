var HTMLChanger = (function() {
  var contents = 'contents'

  var changeHTML = function() {
    var element = 'huwak';
    element.innerHTML = contents;
  }

  return {
    callChangeHTML: function() {
      changeHTML();
      console.log(contents);
    }
  };

})();


$(document).ready(function(){
  /*HTMLChanger.callChangeHTML();       // Outputs: 'contents'
  console.log(HTMLChanger.contents);  // undefined*/
});