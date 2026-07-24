;(function($) {

  $.fn.dribbbleFeed = function (options) {

    var defaults = {
      
      count     : 10,
      title     : true,
      teaser    : true,
      linked    : true,
      stats     : true,

    }, settings = $.extend({}, defaults, options);

    this.each(function () {

      var el = $(this);

      if (options === undefined || options.username === undefined) {
        alert("You must provide a Dribbble username or ID.");
        return false;
      }

      // Generate the URL for the call to Dribbble.
      var username = settings.username;
      var url = "http://api.dribbble.com/players/" + username + "/shots?callback=?";

      $.getJSON(url, function (data) {

        var limit = settings.count;
        var list = $('<ul class="clean-list"></ul>').appendTo(el);


        // Add the number of list items we'll be needing later on.
        list.append(Array(limit).join('<li class="col-xs-4" />'));

        var imageSource = "";
        if (settings.teaser === true) { 

          imageSource = "image_teaser_url"; 

        } else {

          imageSource = "image_url";

        }

        list.children('li').each(function (index) {

          var imgSrc = data.shots[index][imageSource];

          $(this).prepend('<img src="' + imgSrc + '" alt="' + data.shots[index].title + '"/>');

        });

        if (settings.linked === true) {

          list.children('li').each(function (index) { 

            $(this).children('img').wrap('<a href="' + data.shots[index].url + '" target="_blank"></a>');

          });

        }

      });

    });

    return this;

  };

}(jQuery));