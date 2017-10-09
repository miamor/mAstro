function rate (element) {
	if (!element) element = 'body';
	$(element).find(".rating-icons").not(".rated, .myrate").children(".rating-star-icon").hover(function() {
		a = $(this).attr("id").split("v")[1];
		for (i = 1; i <= a; i++) {
			$(element).find(".rating-star-icon.v" + i).css({
				"background-position": "0 -32px"
			})
		}
	}).mouseout(function() {
		$(element).find(".rating-star-icon").css({
			"background-position": "0 0"
		})
	}).click(function() {
		a = $(this).attr("id").split("v")[1];
		$(element).find(".rate-val").val(a);
		wi = a / 5 * 100;
		$(element).find(".rate-count").css("width", wi + "%")
	});
	$(element).submit(function() {
		i = $(this).find(".star-info").attr("data-c");
		url = window.location.href;
		a = $(this).find(".rate-val").val();
//		$('[type="submit"]').attr("disabled", true);
//        alert(url + "&rate=" + a);
		$form = $(this);
		$form.children('*:visible').hide().addClass('visible hide-to-load');
		$form.append('<div class="spinner loading-sending"><div></div><div></div><div></div></div>');
		formData = getFormData($form);
		$.ajax({
			url: url + "?do=rate&rate=" + a,
			type: "POST",
			data: formData,
			datatype: "json",
			success: function (data) {
				alertsContent = data.split(/\[content\]|\[\/content]/)[1];
				alertsType = data.split(/\[type\]|\[\/type\]/)[1];
				alertsDataID = data.split(/\[dataID\]|\[\/dataID\]/)[1];
				$form.addClass('just-sent').children('.spinner.loading-sending').remove();
				$form.children('*.visible.hide-to-load').show().removeClass('visible hide-to-load');
				if (alertsContent) mtip('', alertsType, '', alertsContent);
				$('body').append(alertsContent);
				if (alertsType == 'success') {
					$form.parent().children(".ratings-list").load(url + "?v=window section#ratings .ratings-list > div");
					$form.slideUp(300).remove();
				}
			},
			error: function(e) {
				mtip("", "error", e.status, "Please try again or contact the administrators for help.")
			}
		});
		return false
	})
}
