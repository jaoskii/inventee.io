function processWatermarks(){
	$('.watermarked').each(function(){
		var src = $(this).prop('src');
		var me = $(this);
		var me_class = me.attr('class');

		watermark([src, domain+'/fimages/watermarker/logo.png'])
		.image(watermark.image.lowerRight(0.5))
		.then(function (img) {
		    img.className = me_class;
		    me.replaceWith(img);
		});
	});
}//end f