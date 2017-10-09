$(function () {
	$('.stt-button').not('#status').find('a').click(function () {
		$('.the-board').load('./community/?v=up&type='+$(this).parent('.stt-button').attr('id'), function () {
			popup()
		})
	});
	$('.one-post').not('.stt-form').each(function () {
		arr = ['blog'];
		$(this).find('.post-thumb-view-photo').click(function () {
			type = $(this).closest('.one-post').attr('class').split('type-')[1];
			img = $(this).closest('.one-post').find('.post-thumb-img-inner img:first').attr('src');
			if ($.inArray(type, arr) !== -1) {
				href = $(this).attr('data-href');
				$('.the-board').load(href + '?v=window', function () {
					popup('', img, href)
				})
			} else {
				$('.the-board').html('<div class="popup-section section-light padding">Xem trước không khả dụng.</div>');
				popup('', img)
			}
		})
	})
})
