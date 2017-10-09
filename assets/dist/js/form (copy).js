var typingTimer;                //timer identifier
var doneTypingInterval = 5000;  //time in ms, 5 second for example

//user is "finished typing," do something
function doneTyping (k) {
	val = $('input[name="town'+k+'"]').val();
	loading = '<div class="spinner loading-sending"><div></div><div></div><div></div></div>';
	if (!$dr.length) $('input[name="town'+k+'"]').after('<div class="ville-dropdown">'+loading+'</div>');
	else $dr.html(loading);
	$.ajax({
		url: MAIN_URL+'/lib/ville.php',
		type: 'post',
		data: 'city='+val,
		success: function (data) {
			alert(val + '~~~~' + data);
			data = $.parseJSON(data);
//			var availableTags = [data.city+', '+data.country+' ('+data.lat_deg+data.ns+data.lat_min+', '+data.long_deg+data.ew+data.long_min+', timezone '+data.tzReal+')'];
			var vO = val + '~~~~' + data.city+', '+data.country+' ('+data.lat_deg+data.ns_txt+data.lat_min+', '+data.long_deg+data.ew_txt+data.long_min+', timezone '+data.tzReal+')';
			$dr = $('input[name="town'+k+'"]').next('.ville-dropdown');
			$dr.html('<div class="ville-one">'+vO+'</div>');
			$('.ville-one').click(function () {
				$.each (data, function (i, v) {
					$('input[name="'+i+k+'"]').val(v);
				})
			})
/*			$('input[name="town'+k+'"]').autocomplete({
				minChars: 1,
				width: 402,
				source: availableTags,
				autoFill: true,
				select: function (event, ui) {
					var label = ui.item.label;
					var value = ui.item.value;
					$.each (data, function (i, v) {
						$('input[name="'+i+k+'"]').val(v);
					})
				}
			});
*/		}
	})
}

$(function () {
	$('#town').keyup(function() {
		k = $(this).attr('name').split('town')[1];
//		doneTyping(k);
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping(k), doneTypingInterval);
	});
	$('#town').keydown(function() {
		clearTimeout(typingTimer);
	})
})
