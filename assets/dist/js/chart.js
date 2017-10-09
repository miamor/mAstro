function check(input) {
	if ($(input).is(':checked')) $(input).closest('div').find('select.hour, input.min').attr('disabled', true);
	else $(input).closest('div').find('select.hour, input.min').attr('disabled', false);
}
$(function () {
	if (!$('.generate-data').is('.hide')) $(this).closest('.chart-inputs').find('.apply-data').addClass('disabled').find('#apply_data').attr('disabled', true).trigger("chosen:updated");
	$('.chart-inputs').submit(function () {
		$.ajax({
			url: window.location.href+'?do=caculate',
			type: 'post',
			data: $(this).serialize(),
			success: function (data) {
				if (data.indexOf("http://") > -1) window.location.href = data;
				else $('.chart-inputs').prepend('<div class="alerts alert-error">'+data+'</div>')
			}
		});
		return false
	});
	$('.unknown-hr input').each(function () {
		check(this);
		$(this).on('toggle', function () {
			check(this)
		})
	});
	$('.generate-new-button').click(function () {
		$form = $(this).closest('.chart-inputs');
		$form.find('.generate-data').slideDown(300);
		$form.find('#apply_data').attr('disabled', true).trigger("chosen:updated");
	})
	$('.apply-data').not('.disabled').click(function () {
		$form = $(this).closest('.chart-inputs');
		$form.find('.generate-data').slideUp(300);
		$form.find('#apply_data').attr('disabled', false).trigger("chosen:updated");
	})
})
