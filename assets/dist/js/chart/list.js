function check(input) {
	if ($(input).is(':checked')) $(input).closest('.form-group').find('select.hour, input.min, select.min').attr('disabled', true);
	else $(input).closest('.form-group').find('select.hour, input.min, select.min').attr('disabled', false);
}
$(function () {
	$('.generate-data').each(function () {
		if (!$(this).is('.hide')) $(this).closest('.chart-inputs').find('.apply-data').addClass('disabled').find('#apply_data').attr('disabled', true).trigger("chosen:updated");
	});
	$('.chart-inputs').submit(function () {
		$data = $(this).serialize();
		$.ajax({
			url: window.location.href+'?do=calculate',
			type: 'post',
			data: $data,
			success: function (data) {
				console.log($data);
				if (data.indexOf("http://") > -1) window.location.href = data;
				else $('form.chart-inputs').prepend('<div class="alerts alert-error">'+data+'</div>')
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
/*	$('[type="number"]').on('change', function () {
		v = $(this).val();
		if (v < 10) $(this).val('0'+v);
	});
*/	$('.generate-new-button').click(function () {
		$form = $(this).closest('.chart-inputs');
		$form.find('.generate-data').slideDown(300);
		$form.find('#apply_data').attr('disabled', true).trigger("chosen:updated");
	})
	$('.apply-data').not('.disabled').click(function () {
		$form = $(this).closest('.chart-inputs');
		$form.find('.generate-data').slideUp(300);
		$form.find('#apply_data').attr('disabled', false).trigger("chosen:updated");
	})
});
