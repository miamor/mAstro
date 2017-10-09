function login (response, token, avt, friends) {
	formData = 'type=facebook&id='+response.id+'&name='+response.name+'&fName='+response.first_name+'&lName='+response.last_name+'&avatar='+avt+'&friends='+friends+'&token='+token;
	$.ajax({
		url: MAIN_URL+'/login?do=login',
		type: 'post',
		data: formData,
		success: function (data) {
			alertsContent = data.split(/\[content\]|\[\/content]/)[1];
			alertsType = data.split(/\[type\]|\[\/type\]/)[1];
			alertsDataID = data.split(/\[dataID\]|\[\/dataID\]/)[1];
			if (alertsContent) mtip('', alertsType, '', alertsContent);
			if (alertsType == 'success') window.history.back()
		},
		error: function (data) {
			mtip('.bootstrap-validator-form', 'error', '', 'Oops! Seems like something went wrong. Please contact the administrators for help.')
		}
	});
}

$(function () {
	$('.signup input[name="password"]').passStrengthify();
	$('.login').submit(function () {
		$form = $(this);
		$form.children('*:visible').hide().addClass('visible hide-to-load');
		$form.append('<div class="spinner loading-sending"><div></div><div></div><div></div></div>');
		$.ajax({
			url: $form.attr('action'),
			type: 'post',
			data: $form.serialize(),
			success: function (data) {
				alertsContent = data.split(/\[content\]|\[\/content]/)[1];
				alertsType = data.split(/\[type\]|\[\/type\]/)[1];
				alertsDataID = data.split(/\[dataID\]|\[\/dataID\]/)[1];
				$form.addClass('just-sent').children('.spinner.loading-sending').remove();
				$form.children('*.visible.hide-to-load').show().removeClass('visible hide-to-load');
				if (alertsContent) mtip('', alertsType, '', alertsContent);
				$form.find('[type^="submit"]').attr('disabled', false);
				if (alertsType == 'success') location.reload();
			},
			error: function (data) {
				$form.addClass('just-sent').children('.spinner.loading-sending').remove();
				$form.children('*.visible.hide-to-load').show().removeClass('visible hide-to-load');
				mtip('.bootstrap-validator-form', 'error', '', 'Oops! Seems like something went wrong. Please contact the administrators for help.')
			}
		});
		return false
	})
})
