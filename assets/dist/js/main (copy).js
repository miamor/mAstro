function displayBoard (data) {
	titlez = data.split(/<!--|-->/)[1];
	displayz = data.split(/<!--{|}-->/)[1];
	$('body').addClass('fixed');
	$('#content-board').after('<div class="the-board-fixed"></div>').fadeIn(250).html('<div class="loading-screen"><div class="spinner"> <div></div><div></div><div></div> </div></div>');
	setTimeout(function () {
		$('#content-board').html(data).slideDown(100, function () {
			$(this).prepend('<a class="board-close" href="javascript:history.go(-1)"></a>');
/*			$(this).find('.board-close').click(function () {
				$(this).closest('#content-board').hide
			});
*/			refreshScripts()
		})
	}, 200)
}

function flatApp () {
//	$('.alerts, .alert').addClass('alert-square alert-bold-border');
	$('.tooltip').remove();
//	$('input[type="submit"], button, .button').not('[class*="btn "]').addClass('btn btn-info btn-perspective-hover');
	$('input[type="submit"], button, .button').not('[class*="btn "]').addClass('btn');
	$('input[type="reset"]').addClass('btn btn-default');
/*	$('[data-toggle="confirmation"]').confirmation();
	$('[data-toggle="confirmation-singleton"]').confirmation({singleton:true});
	$('[data-toggle="confirmation-popout"]').confirmation({popout: true});
*/	$(':checkbox').not('[data-toggle="switch"], .onoffswitch-checkbox').checkbox();
	$(':radio').radio();
	choosen();
	$('.tooltips').tooltip({
		selector: '*:not(".sceditor-dropdown img, #ui-datepicker-div a, #fancybox-buttons li a, #fancybox-buttons li, .fancybox-overlay li, .fancybox-overlay span, .fancybox-overlay div, .fancybox-overlay a")',
		container: "body"
	});
	if ($('.btn-file').length > 0) {
		$(document).on('change', '.btn-file :file', function () {
				"use strict";
				var input = $(this),
				numFiles = input.get(0).files ? input.get(0).files.length : 1,
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				input.trigger('fileselect', [numFiles, label]);
		});
		$('.btn-file :file').on('fileselect', function (event, numFiles, label) {
			var input = $(this).parents('.input-group').find(':text'),
				log = numFiles > 1 ? numFiles + ' files selected' : label;
			if (input.length) input.val(log);
			else if (log) alert(log)
		})
	}
}

function choosen() {
	"use strict";
	var configChosen = {
		'.chosen-select'           : {},
		'.chosen-select-deselect'  : {allow_single_deselect:true},
		'.chosen-select-no-single' : {disable_search_threshold:10},
		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		'.chosen-select-width'     : {width:"100px"}
	}
	for (var selector in configChosen) {
		$(selector).chosen(configChosen[selector]);
	}
}

function findLink (text) {
	var exp = /.*((https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/i;
	text = text.replace(exp, "<a href=\"$1\">$1</a>");
	link = text.split(/<a href="|">/)[1];
	if (link) return link
	return null
}

function convertLink (text) {
	var exp = /.*((https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/i;
	text = text.replace(exp, "<a href=\"$1\">$1</a>");
	link = text.split(/<a href="|">/)[1];
	return text
}


$(function () {
});
