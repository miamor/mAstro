(function($){
	$.fn.extend({
		donetyping: function (callback,timeout) {
//			timeout = timeout || 1e3; // 1 second default timeout
			timeout = timeout || 100
			var timeoutReference,
				doneTyping = function(el) {
					if (!timeoutReference) return;
					timeoutReference = null;
					callback.call(el);
				};
			return this.each (function (i,el) {
				var $el = $(el);
				// Chrome Fix (Use keyup over keypress to detect backspace)
				// thank you @palerdot
				$el.is(':input') && $el.on('keyup keypress',function(e) {
					// This catches the backspace button in chrome, but also prevents
					// the event from triggering too premptively. Without this line,
					// using tab/shift+tab will make the focused element fire the callback.
					if (e.type=='keyup' && e.keyCode!=8) return;
					
					// Check if timeout has been set. If it has, "reset" the clock and
					// start over again.
					if (timeoutReference) clearTimeout(timeoutReference);
					timeoutReference = setTimeout(function() {
						// if we made it here, our timeout has elapsed. Fire the
						// callback
						doneTyping(el);
					}, timeout);
				}).on('blur',function() {
					// If we can, fire the event since we're leaving the field
					doneTyping(el);
				});
			})
		}
	});
})(jQuery);


$(function () {
	$('#town').keydown(function () {
		k = $(this).attr('name').split('town')[1];
		$dr = $('input[name="town'+k+'"]').next('.ville-dropdown');
		loading = '<div class="spinner loading-sending"><div></div><div></div><div></div></div>';
		if (!$dr.length) $('input[name="town'+k+'"]').after('<div class="ville-dropdown">'+loading+'</div>');
		else $dr.html(loading);
	});
	$('#town').on('change', function () {
		$('.birth-place-info').html('');
	}).donetyping(function () {
		val = $(this).val();
		k = $(this).attr('name').split('town')[1];
		$.ajax({
			url: MAIN_URL+'/pages/ville.php',
			type: 'post',
			data: 'city='+val,
			success: function (data) {
				data = $.parseJSON(data);
				var vO = data.city+', '+data.country+' ('+data.lat_deg+data.ns_txt+data.lat_min+', '+data.long_deg+data.ew_txt+data.long_min+', timezone '+data.tzReal+')';
				$dr = $('input[name="town'+k+'"]').next('.ville-dropdown');
/*				if (!$dr.length) $('input[name="town'+k+'"]').after('<div class="ville-dropdown"><div class="ville-one">'+vO+'</div></div>');
				else $dr.html('<div class="ville-one">'+vO+'</div>');
*/				$dr.html('<div class="ville-one">'+vO+'</div>');
				$('.ville-one').click(function () {
					$('.birth-place-info').html('<span class="fa fa-info"></span> '+vO);
					$.each (data, function (i, v) {
						$('input[name="'+i+k+'"]').val(v);
					});
					$dr.remove()
				})
			}
		})
	});
})
