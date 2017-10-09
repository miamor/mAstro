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
			url: $(this).attr('action'),
			type: 'post',
			data: $data,
			success: function (data) {
				console.log($data);
				if (data.indexOf("http://") > -1) {
					if (data == window.location.href) mtip('.chart-inputs', 'success', '', 'Data updated successfully!');
					else {
						mtip('.chart-inputs', 'success', '', 'Data created successfully! Redirecting...');
						// $('form.chart-inputs').prepend('<div class="alerts alert-success">Data created successfully! Redirecting...</div>');
						window.location.href = data;
					}
				} else $('form.chart-inputs').prepend('<div class="alerts alert-error">'+data+'</div>')
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
});
