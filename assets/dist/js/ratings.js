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
		url = cURL + "?i=" + i;
		a = $(this).find(".rate-val").val();
		$('[type="submit"]').attr("disabled", true);
//        alert(url + "&rate=" + a);
		if (i) {
			$.ajax({
				url: url + "&rate=" + a,
				type: "POST",
				data: $(".rating-form").serialize(),
				datatype: "json",
				success: function() {
					$(element).find('[type="submit"]').attr("disabled", false);
					$(element).find(".ratings-list").load(url + " .ratings-list > div")
				},
				error: function(e) {
					mtip("", "error", e.status, "Please try again or contact the administrators for help.")
				}
			})
		} else mtip("", "error", "", "Action failed.", "Check your url again.");
		return false
	})
}
$(function(){rate()})
