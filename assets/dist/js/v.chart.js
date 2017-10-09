function form (form) {
	$form = $(form);
	type = $form.attr('class').split('-')[1];
	id = $form.attr('id').split(type+'-')[1];
	sce(type+'-'+id);
	$form.submit(function () {
		formData = getFormData($form);
		url = window.location.href;
		$form.children('*:visible').hide().addClass('visible hide-to-load');
		$form.append('<div class="spinner loading-sending"><div></div><div></div><div></div></div>');
		$.ajax({
			url: url+'?do='+type+'&id='+id,
			type: 'post',
			data: formData,
			success: function (data) {
				$form.addClass('just-sent').children('.spinner.loading-sending').remove();
				$form.children('*.visible.hide-to-load').show().removeClass('visible hide-to-load');
				if (data == 0) {
					$form.removeClass('just-sent').slideUp(300);
					mtip('', 'success', '', '<span class="capitalize">'+type+'ed</span> successfully!');
				} else if (data == 1) mtip('', 'error', '', 'Oops! Something went wrong.');
				else mtip('', 'error', '', data);
			}
		});
		return false
	})
}

$(function () {
	rate('section#ratings #wreview');
	$('.chart-canvas-div img').click(function () {
	});
	$('.chart-report section').each(function() {
		title = $(this).find('.chart-report-head').text();
		n = $(this).attr('id');
		if (!$(this).is(':hidden')) ac = ' active';
		else ac = '';
		$('.chart-nav').append('<li class="chart-nav-one '+ac+'" name="'+n+'" title="'+title+'"><span class="as as-'+n+'"></span></li>');
	});
	$('.chart-nav li').click(function () {
		n = $(this).attr('name');
		$('.chart-nav li').removeClass('active');
		$(this).addClass('active');
		$('.chart-report section').hide();
		$('.chart-report section#'+n).show().css('overflow', 'auto')
	});
	$('.chart-report-content .paragraph:not(".ratings") > div').each(function() {
		$(this).contents().filter(function() {
			return this.nodeType == 3;  
		}).wrap('<p></p>');
		$(this).find('br').remove();
	});
	$('.chart-report-content .paragraph > div').not('.chart-report-des').find('div:not([class])').contents().unwrap().wrap('<p/>');
	$('.chart-report-content > .chart-report-des br').remove();
	$('.chart-report-content > .chart-report-des').contents().wrap('<p/>');

	$.getScript(JS + '/toc.min.js', function () {
	$('section:not("#ratings") .chart-report-content').each(function (e) {
		var newText = $(this).html().replace(/(<br\s*\/?>){3,}/gi, '<br>');
		$(this).html(newText);
		$(this).attr('id', 't'+e);
		var sections = '';
/*		$(this).children('.paragraph').not('.chart-report-des').each(function () {
			active = '';
			id = $(this).attr('id');
			title = $(this).children('h3').text();
			sections += '<li class="'+id+' '+active+'"><a href="#'+id+'">'+title+'</a></li>';
		});
		$(this).scroll(function () {
			a = isScrolledIntoView($('.paragraph#'+id), $(this));
			if (a == true) active = 'active';
			else active = '';
		});
		$(this).prev('.chart-report-head').prepend('<ol class="toc" id="toc'+e+'">'+sections+'</ol>');
		$(this).children('.paragraph').not('.chart-report-des').each(function () {
			$(this).appear(function() {
				alert('Hello world');
			});
		});
*/		if ($(this).find('h1,h2,h3,h4').length) $(this).prev('.chart-report-head').prepend('<div class="toc" id="toc'+e+'"></div>');
		$('#toc'+e).toc({
			'selectors': 'h1,h2,h3,h4', //elements to use as headings
			'container': $('.chart-report-content#t'+e), //element to find all selectors in
			'smoothScrolling': true, //enable or disable smooth scrolling on click
			'prefix': 'toc'+e, //prefix for anchor tags and class names
			'onHighlight': function(el) {}, //called when a new section is highlighted 
			'highlightOnScroll': true, //add class to heading that is currently in focus
			'highlightOffset': 100, //offset to trigger the next headline
			'anchorName': function(i, heading, prefix) { //custom function for anchor name
				return prefix+i;
			},
			'headerText': function(i, heading, $heading) { //custom function building the header-item text
				return $heading.text();
			},
			'itemClass': function(i, heading, $heading, prefix) { // custom function for item class
				return $heading[0].tagName.toLowerCase();
			}
		});
	});
	$('.chart-report-content .paragraph').not('.chart-report-des').children('div').not('.chart-report-des').each(function() {
		$this = $(this);
		btns = trans = '';
		transN = $(this).closest('.paragraph').attr('data-trans-num');
		if (u == au) btns += '<a class="report-btn report-edit" title="Edit"><span class="fa fa-pencil"></span></a> ';
		btns += '<a class="report-btn report-contribute" title="Contribute"><span class="fa fa-plus"></span></a>';
		if (transN > 0) trans = '<div class="gensmall">'+transN+' translates available</div>';
		if ($(this).text().length > 0) btns += '<span class="report-btn"><a class="report-translate fa fa-language" title="Translate"></a>'+trans+'</span>';
		$(this).parent().children('h3').append(btns);
	})
	$('.chart-report-content .paragraph .report-edit').click(function() {
		$div = $(this).closest('.paragraph').children('div').not('.chart-report-des');
		id = $(this).closest('.paragraph').attr('id');
		if ($div.closest('.paragraph').find('form.report-edit-form').length) $div.hide().next('form').show();
		else {
			$div.hide().after('<form class="report-edit-form" id="edit-'+id+'"><textarea class="report-edit-textarea-'+id+'" name="content-'+id+'">'+$div.text()+'</textarea><div class="add-form-submit right"><a type="reset" class="report-edit-form-cancel btn btn-default" name="Cancel">Cancel</a><input type="submit" class="btn" name="Submit"/></div><div class="clearfix"></div></form>');
			form('.report-edit-form#edit-'+id);
		}
		$div.closest('.paragraph').find('form.report-edit-form').find('.report-edit-form-cancel').click(function () {
			$(this).closest('form.report-edit-form').hide();
			$div.show()
		});
	})
	$('.chart-report-content .paragraph .report-contribute').click(function() {
		$div = $(this).closest('.paragraph').children('div').not('.chart-report-des');
		id = $(this).closest('.paragraph').attr('id');
		if ($div.closest('.paragraph').find('form.report-contribute-form').length) $div.next('form').show();
		else {
			$div.after('<form class="report-contribute-form" id="contribute-'+id+'"><h4>Add a report</h4><div class="form-group"><div class="col-lg-3 no-padding control-label">Source</div><div class="col-lg-7"><select name="source-'+id+'" class="form-control"><option value="0" selected>(by Me)</option><option value="-1">(Somewhere)</option>'+sources+'</select></div><div class="col-lg-2 control-label no-padding"><a href="'+MAIN_URL+'/source">Add a source</a></div><div class="clearfix"></div></div><textarea class="report-contribute-textarea-'+id+'" name="content-'+id+'"></textarea><div class="add-form-submit right"><a type="reset" class="report-contribute-form-cancel btn btn-default" name="Cancel">Cancel</a><input type="submit" class="btn" name="Submit"/></div><div class="clearfix"></div></form>');
			choosen('.report-contribute-form');
			form('.report-contribute-form#contribute-'+id);
		}
		$div.closest('.paragraph').find('form.report-contribute-form').find('.report-contribute-form-cancel').click(function () {
			$(this).closest('form').hide()
		});
	})
	$('.chart-report-content .paragraph .report-translate').click(function() {
		$div = $(this).closest('.paragraph').children('div').not('.chart-report-des');
		id = $(this).closest('.paragraph').attr('id');
		if ($div.closest('.paragraph').find('form.report-translate-form').length) $div.next('form').show();
		else {
			$div.after('<form class="report-translate-form" id="translate-'+id+'"><h4>Add a report translation</h4><div class="form-group"><div class="col-lg-3 no-padding control-label">Translate to</div><div class="col-lg-9"><select multiple name="lang-'+id+'" class="chosen-select form-control translator-select">'+lng+'</select></div><div class="clearfix"></div></div><div class="form-group"><div class="col-lg-3 no-padding control-label">Translator</div><div class="col-lg-7"><select multiple name="translator-'+id+'" class="chosen-select form-control translator-select">'+me+'<option value="-1">(Somewhere)</option><optgroup label="Sources">'+sources+'</optgroup><optgroup label="Translators">'+translators+'</optgroup><optgroup label="Others">'+others+'</optgroup></select></div><div class="col-lg-2 control-label no-padding"><a href="'+MAIN_URL+'/source">Add a source</a></div><div class="clearfix"></div></div><textarea class="report-translate-textarea-'+id+'" name="content-'+id+'"></textarea><div class="add-form-submit right"><a type="reset" class="report-translate-form-cancel btn btn-default" name="Cancel">Cancel</a><input type="submit" class="btn" name="Submit"/></div><div class="clearfix"></div></form>');
			choosen('.report-translate-form');
			form('.report-translate-form#translate-'+id);
		}
		$div.closest('.paragraph').find('form.report-translate-form').find('.report-translate-form-cancel').click(function () {
			$(this).closest('form').hide()
		});
	});
	});
});
