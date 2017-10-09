function selectCat () {
	$('.parent-cat > .input-skin input').change(function () {
		if ($(this).is(':checked')) 
			$(this).closest('.parent-cat').find('ul.cats > .input-skin .checkbox_skin').css('background-position', '0 100%').find('input').prop('checked', true);
	})
	$('.parent-cat > ul.cats > .input-skin input').change(function () {
		if (!$(this).is(':checked')) {
			$(this).closest('.parent-cat').children('.input-skin').find('.checkbox_skin').css('background-position', '0 0').find('input').prop('checked', false);
		}
	})
}

$(function () {
	$("#slider-range").slider({
		range: true,
		min: 50000,
		max: 5000000,
		values: [ 700000, 4000000 ],
		slide: function (event, ui) {
			min = Math.floor(ui.values[0]/10000) * 10000;
			max = Math.floor(ui.values[1]/10000) * 10000;
			$('.min-price').text(min).digits();
			$('.max-price').text(max).digits()
		}
	});
	$("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
	
	$('.one-filter h4').before('<div class="btn-cat"><i class="fa fa-minus"></i><i class="fa fa-plus hide"></i></div>');
	$('.one-filter.hide > .btn-cat > i').toggle();
	
	selectCat()
})
