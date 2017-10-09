var url = window.location.href.split('#')[0];
function filter (type, idDiv) {
	params = '';
	params += '&sort='+$('.data-filter-options > div select#sort').val();
	params += '&order='+$('.data-filter-options > div select#order').val();
	rid = $('.data-filter-options').attr('data-rid');
	$('.data-list').html('<div class="spinner loading-sending"><div></div><div></div><div></div></div>');
	//console.log(url+'?do=setshow&show=source'+params);
	$.get(url+'?do=setshow&show=source'+params, function (data) {
		$('.the-board').html(data);
		onChange()
	})
}

function onChange () {
	$('.data-filter-options > div select').on('change', function () {
		filter($(this).attr('id'), $(this).closest('.popup-section').attr('id'));
	});
}

$(function () {
	onChange();
	$('.friend-one').click(function () {
		sid = $(this).attr('id');
		$.ajax({
			url: url+'?do=setshow&show=source&source='+sid,
			type: 'post',
			success: function (data) {
				if (data == 0) {
					mtip('', 'success', '', 'Switch display option successfully!');
					remove_popup();
					location.reload()
				} else if (data == 1) mtip('', 'error', '', 'Oops! Something went wrong.');
				else mtip('', 'error', '', data)
			}
		})
	})
});
