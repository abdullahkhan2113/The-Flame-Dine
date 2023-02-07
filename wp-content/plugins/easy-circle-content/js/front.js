jQuery(document).ready(function(){

		/*var width = <?= $width ?>;
		var height = <?= $height ?>;
		var real_width = (width-<?= $size_icons ?>)/2-Math.round(<?= $size_icons ?>/5)*2;
		var real_height = (height-<?= $size_icons ?>)/2-Math.round(<?= $size_icons ?>/5)*2;*/

	jQuery('.circles_content').each(function() {
		var font_size = parseInt(jQuery(this).find('.circle:first-child').css('font-size'));
		var real_width = (jQuery(this).width()-font_size)/2-Math.round(font_size/5)*2;
		var real_height = (jQuery(this).height()-font_size)/2-Math.round(font_size/5)*2;
		var nb_circles = jQuery(this).find('.circle').length;
		var angle = 2*Math.PI/nb_circles;
		jQuery(this).find('.circle').each(function( i, val ) {
			var current_angle = angle*i-Math.PI/2;
			var x = Math.cos(current_angle);
			var y = Math.sin(current_angle);
			jQuery(this).animate({ left: '+='+(real_width+x*real_width), top: '+='+(real_height+y*real_height), opacity: "+=1" }, 500);
		});
	});

	jQuery('.circles_content .circle').hover(function(){
		jQuery(this).parent().find('.title span').html(jQuery(this).attr('rel'));
	}, function(){
		jQuery(this).parent().find('.title span').html('');
	});

	/*jQuery('.circles_content .circle').click(function(){
		return false;
	});*/

});