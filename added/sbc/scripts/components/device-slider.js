;(function() {
	'use strict';

	$.fn.deviceSlider = function(options) {
		var settings = {
				autoplay: true
		};

		if ( options ) {
			$.extend( settings, options );
		}

		var deviceSlidesHolder = jQuery('[data-device-slider]'),
			deviceSlidesImg = deviceSlidesHolder.data('device-slider'),
			deviceNav = jQuery('.device-slider-nav').find('a'),
			slideSpan = deviceSlidesHolder.find('span'),
			n = slideSpan.length,
			autoplayIndex = 1,
			deviceAutoplay;

			function deviceSlider(realClick, navIndex) {
				var activeEl = deviceSlidesHolder.find('span').eq(navIndex);
					deviceNav.removeClass('bg-alpha');

				if(realClick === true) clearInterval(deviceAutoplay);

				deviceNav.eq(navIndex).addClass('bg-alpha');
				deviceNav.parent().removeClass('active-nav');
				deviceNav.eq(navIndex).parent().addClass('active-nav');

				if(activeEl.hasClass('active-device-screen')) {
					if(navIndex !== n-1) {
						jQuery('[data-device-slider] span:gt('+navIndex+')').velocity({translateX: '100%'}, { duration: 300 });
						jQuery('[data-device-slider] span:gt('+navIndex+')').removeClass('active-device-screen');
					}
				} else {
					activeEl.velocity({translateX: 0}, { duration: 300 });
					activeEl.addClass('active-device-screen');

					if(navIndex > 0) {
						jQuery('[data-device-slider] span:lt('+navIndex+')').addClass('active-device-screen');
					}
				}
			};

			if(deviceSlidesImg.slides.length) {
				$.each(deviceSlidesImg.slides, function(i) {
					deviceSlidesHolder.append('<span style="background: url('+deviceSlidesImg.slides[i]+') 0 0 no-repeat"></span>');
				});
			}

			deviceNav.eq(0).addClass('bg-alpha');
			deviceNav.eq(0).parent().addClass('active-nav');
			deviceSlidesHolder.find('span').eq(0).addClass('active-device-screen').velocity({translateX: 0}, { duration: 300 });

			deviceNav.click(function(e) {
				e.preventDefault();
				deviceSlider(true, deviceNav.index(this));
			});

			// Auto play

			if(settings.autoplay === true) {
				deviceAutoplay = setInterval(function() {
					deviceSlider(false, autoplayIndex);
					autoplayIndex++;

					if(autoplayIndex >= 4) autoplayIndex = 0;

				}, 2500);				
			}
	};
})(window.jQuery);