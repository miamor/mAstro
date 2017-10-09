var url = window.location.href.split('#')[0];

function mscroll (form) {
	$form = $(form);
	if ($form.parents(".module").length) $parent = $form.closest(".module");
	else $parent = $form.closest(".paragraph");
	tocID = $parent.attr('id');
	topp = document.getElementById(tocID).offsetTop + $parent.height() - $form.height() - 75;
	$form.closest('.chart-report-content').animate({
		scrollTop: topp
	}, 800);
}
function form (form) {
	$form = $(form);
	type = $form.attr('class').split('-')[1];
	id = $form.attr('id').split(type+'-')[1];
	choosen(form);
	sce('#'+type+'-'+id);
	$form.find('input[type="submit"]').addClass('btn-red');
	$form.submit(function () {
		formData = getFormData($form);
		cont = $(this).find('textarea').sceditor('instance').val();
		cont = $(this).find('textarea').sceditor('instance').fromBBCode(cont, true);
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
					$form.prev('div').slideDown(300).html(cont);
					mtip('', 'success', '', '<span class="capitalize">'+type+'ed</span> successfully!');
				} else if (data == 1) mtip('', 'error', '', 'Oops! Something went wrong.');
				else mtip('', 'error', '', data);
			}
		});
		return false
	})
}
function nl2br (str, is_xhtml) {
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
}

function _content ($this) {
/*	$this.contents().filter(function () {
		return this.nodeType !== 1 && $.trim(this.nodeValue).length;
	}).wrap('<p></p>').end().filter('br').remove();
*/	$this.find('blockquote').after('<br/>').wrapInner('<div class="blockquote"/>');
	var content = $this.html()+'<br/>';
	var newContent = '<p>'+content.replace('<br/>', '<br>').split('<br>').join('</p><p>')+'</p>';
	$this.html(newContent);
	$this.find('p').each(function () {
//		pcont = nl2br($(this).html());
//		$(this).html(pcont);
		if (!$(this).html().length || $(this).html() == '&nbsp;' || $(this).html() == '<br>') $(this).remove();
	})
}

function vote ($this) {
	var rid = $this.attr('data-rid');
	likesAr = dislikesAr = [];
	var likes = dislikes = 0;
	types = ['likes', 'dislikes'];
	$this.children('h3').wrap('<div class="h3"></div>');
	if (rid && rid != 0) {
//		console.log(MAIN_URL+'/report/'+rid+'?type=vote&v=window');
		$.ajax({
			url: MAIN_URL+'/report/'+rid+'?type=vote&v=window',
			type: 'get',
			success: function (data) {
				$para = $paraDiv = $('.paragraph[data-rid="'+rid+'"]');
				obj = $.parseJSON(data);
				likesAr = obj.likes;
				dislikesAr = obj.dislikes;
				likes = likesAr.length;
				dislikes = dislikesAr.length;
				votes = likes + dislikes;
				liked = disliked = '';
				uu = ''+u+'';
				if ($.inArray(uu, likesAr) !== -1) liked = 'active';
				if ($.inArray(uu, dislikesAr) !== -1) disliked = 'active';
				likesW = Math.ceil(likes/votes * 100);
				dislikesW = Math.floor(dislikes/votes * 100);
				$para.children('.h3').find('.product-vote').remove();
				$para.children('.h3').prepend('<div class="product-vote right"><div class="product-vote-buttons"><a class="product-like '+liked+'" id="like"><span title="Like" class="product-like-btn fa fa-thumbs-up"></span> <span class="product-like-num">'+likes+'</span></a><a class="product-dislike '+disliked+'" id="dislike"><span title="Dislike" class="product-dislike-btn fa fa-thumbs-down"></span> <span class="product-dislike-num">'+dislikes+'</span></a><div class="clearfix"></div></div><div class="product-vote-bar"><div class="product-like-bar" style="width:'+likesW+'%"></div><div class="product-dislike-bar" style="width:'+dislikesW+'%"></div></div></div>');
				$para.find('.product-vote-buttons > a').click(function () {
					if (u && u != 0) {
					act = $(this).attr('id');
					num = Number($(this).find('.product-'+act+'-num').text());
					if ($(this).is('.active')) {
						num--; $(this).removeClass('active');
					} else {
						num++; $(this).addClass('active');
					}
					if (act == 'like') $other = $(this).next();
					else $other = $(this).prev();
					$other.each(function () {
						if ($(this).is('.active')) {
							nm = Number($(this).find('span[class*="-num"]').text()) - 1;
							$(this).removeClass('active').find('span[class*="-num"]').text(nm);
						}
					});
					$(this).find('.product-'+act+'-num').text(num);
					$para = $('.paragraph[data-rid="'+rid+'"]');
					likes = Number($para.find('.product-like-num').text());
					dislikes = Number($para.find('.product-dislike-num').text());
					votes = likes + dislikes;
					likesW = dislikesW = 0;
					if (votes != 0) {
						likesW = Math.ceil(likes/votes * 100);
						dislikesW = Math.floor(dislikes/votes * 100);
					}
					$para.find('.product-like-bar').animate({width: likesW+'%'}, 300);
					$para.find('.product-dislike-bar').animate({width: dislikesW+'%'}, 300);
					$.ajax({ 
						url: MAIN_URL+'/report/'+rid+'?do='+act+'&v=window', 
						type: 'post',
						success: function (data) {
						}
					})
					} else mtip('', 'warning', '', 'You must login to vote this report');
				})
			}
		})
	}
}

function changeSource () {
	$('.the-board').load(url+'?do=setshow&show=source', function () {
		popup();
	})
}

function selectReport (old_rid, code) {
		$para = $('.paragraph[data-id="'+code+'"]');
			popup();
			$('.one-data').click(function () {
				rid = $(this).attr('data-rid');
				id = $(this).attr('data-id');
				sThumb = $(this).find('.source-thumb').attr('src');
				sHref = $(this).find('.source-title a').attr('href');
				sTit = $(this).find('.source-title a').text();
				time = $(this).find('.time').html();
				cont = $(this).find('.shorten').html();
				vNum = Number($(this).find('.sta-likes-btn').text()) - Number($(this).find('.sta-dislikes-btn').text());
//				old_rid = $para.attr('data-rid');
				if (old_rid != rid) {
					$para.attr('data-rid', rid);
					$paraCont = $para.children('.chart-paragraph-content');
					$paraCont.html(cont);
					$para.find('.chart-paragraph-source .s-info').attr('href', sHref).children('.s-info-title').text(sTit).parent().children('.s-info-thumb').attr('src', sThumb);
					$para.find('.chart-paragraph-source .time').html(time);
					$para.find('.report-source-thumb').attr({
						'src': sThumb,
						'title': sTit
					});
					if (vNum > 0) {
						if (vNum == 1) votes = vNum+' person';
						else vNum = vNum+' people';
						$para.find('.chart-paragraph-sta .post-fav-list').html(votes+' liked this');
					}
					_content($paraCont);
					vote($para)
				}
				remove_popup()
			})
}

var scrollB = false;
$(document).ready(function () {
	rate('section#ratings #wreview');
	$('.chart-stt-dropdown a').click(function () {
		stt = $(this).attr('id');
		cl = $(this).children('span').attr('class');
		$(this).closest('.chart-stt-dropdown').find('li').removeClass('active');
		$(this).closest('li').addClass('active');
		$('.chart-current-stt > div').attr('class', cl);
		$.ajax({
			url: url+'?do=setstt&stt='+stt,
			type: 'post',
			success: function (data) {
				if (data == 0) mtip('', 'success', '', '<span class="capitalize">Updated privacy</span> successfully!');
				else if (data == 1) mtip('', 'error', '', 'Oops! Something went wrong.');
				else mtip('', 'error', '', data);
			}
		});
	});

	$('.source-selected').click(function () {
		changeSource();
	})
	$('.chart-report-bottom select').on('change', function () {
		val = $(this).find('option:selected').attr('class');
//		val = $(this).val();
		old = $(this).attr('data-v');
		if (val != old) {
//			$(this).attr('data-v', val);
			if (val == 'source') {
				changeSource();
				$(this).find('option').attr('selected', false);
				$(this).find('option.'+old).attr('selected', true)
			} else {
			$.ajax({
				url: url+'?do=setshow&show='+val,
				type: 'post',
				success: function (data) {
					if (data == 0) {
						mtip('', 'success', '', 'Switch display option successfully!');
						location.reload()
					} else if (data == 1) mtip('', 'error', '', 'Oops! Something went wrong.');
					else mtip('', 'error', '', data)
				}
			})
			}
		}
	});

	$('.chart-report section').each(function() {
		title = $(this).find('.chart-report-head').text();
		n = $(this).attr('id');
		if (!$(this).is(':hidden')) ac = ' active';
		else ac = '';
		$(this).closest('.tab-pane').find('.chart-nav').append('<li class="chart-nav-one '+ac+'" name="'+n+'" title="'+title+'"><span class="as as-'+n+'"></span></li>');
	});
	$('.chart-nav').each(function () {
		$(this).children('li:first-child').addClass('active').show();
		$(this).next('section').addClass('active').show();
		$(this).children('li').click(function () {
			n = $(this).attr('name');
			$(this).closest('.chart-nav').find('li').removeClass('active');
			$(this).addClass('active');
			$(this).closest('.tab-pane').find('section').hide();
			$(this).closest('.tab-pane').find('section#'+n).show().css('overflow', 'auto')
		});
	});

	$('section:not("#ratings") .chart-report-content').each(function (e) {
		var newText = $(this).html().replace(/(<br\s*\/?>){3,}/gi, '<br>');
		$(this).html(newText);
		$(this).attr('id', 't'+e);
		var tabID = $(this).closest('.tab-pane').attr('id');
		var sections = '';
		if ($(this).find('h1,h2,h3,h4').length) $(this).prev('.chart-report-head').prepend('<div class="toc" id="'+tabID+'toc'+e+'"></div>');
		$('#'+tabID+'toc'+e).toc({
			'selectors': 'h1,h2,h3,h4', //elements to use as headings
			'container': $('.chart-report-content#t'+e), //element to find all selectors in
			'smoothScrolling': true, //enable or disable smooth scrolling on click
			'prefix': tabID+'toc'+e, //prefix for anchor tags and class names
			'onHighlight': function (el) {}, //called when a new section is highlighted 
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

	$('.chart-report-content .paragraph:not(".ratings")').each(function() {
		dID = $(this).attr('id');
		$(this).attr('data-id', dID).removeAttr('id');
		vote($(this));
	});
	$('.chart-report-des').each(function() {
		if (!$(this).children('.chart-report-des-content').length) $(this).removeClass('chart-report-des').addClass('chart-report-des-content').next('.chart-paragraph-tool').andSelf().wrapAll('<div class="chart-report-des"/>');
	});
	$('.chart-paragraph-content, .chart-report-des, .chart-paragraph-content').each(function() {
		_content($(this));
		$(this).find('div:not([class])').contents().unwrap().wrap('<p/>')
	});

	$('.module, .paragraph, .overview-section').each(function () {
		if (!$(this).parent('.module').length || $(this).is('.overview-section')) {
			$span = $(this).find('span[id*="toc"]');
			tid = $span.attr('id').split('toc')[1];
			tocID = 't' + tid;
			$(this).attr('id', tocID);
		}
	});
	$('.chart-report-content').on('scroll', function () {
		scroll = $(this).scrollTop();
		var tpp, $para;
		$(this).find('.paragraph').each(function () {
			$para = $paraDiv = $(this);
			if ($para.parents('.module').length) $paraDiv = $para.closest('.module');
			$paraDivN = $paraDiv.next();
			tocID = $paraDiv.attr('id');
			tpp = document.getElementById(tocID).offsetTop - 10;
			btm = tpp + $paraDiv.height() - 90;
			wi = $paraDiv.width() - 18;
			if (scroll >= btm || scroll < tpp + 70) {
				$paraDiv.find('.h3').removeClass('fixed');
				$paraDiv.css('margin-top', 0);
			}
			if (scroll < btm && scroll >= tpp) {
				if ($paraDiv.parent('.module.parallax').length) tID = $paraDiv.parent('.module.parallax').attr('id').split('t')[1];
				else tID = $paraDiv.attr('id').split('t')[1];
//				console.log(tID);
				$para.closest('section').find('.toc li').removeClass('toc-active');
				$('a[href="#freetoc'+tID+'"]').parent('li').addClass('toc-active');
				$paraDiv.find('.h3').addClass('fixed').width(wi);
				$paraDiv.css('margin-top', 60);
			}
		});
	});
	$('.toc a').click(function () {
		id = $(this).attr('href').split('#')[1];
		tid = id.split('toc')[1];
		tocID = 't' + tid;
		$parent = $span.closest('#'+tocID);
		topp = document.getElementById(tocID).offsetTop - 5;
		$(this).closest('section').find('.chart-report-content').animate({
			scrollTop: topp
		}, 500, function () {
			$(this).closest('section').find('.toc li').removeClass('toc-active');
			$('a[href="#freetoc'+tid+'"]').parent('li').addClass('toc-active');
		});
		return false
	});
	$('.chart-canvas-div img, .chart-report-content img').css('cursor', 'pointer').click(function () {
		if ($(this).width() > 20) {
			src = $(this).attr('src');
			$('.the-board').html("<div align='center'><img src='"+src+"'/></div>");
			popup('light')
		}
	});

	$('.chart-report-content .paragraph').not('.chart-report-des').children('div.chart-paragraph-content').each(function() {
//		$this = $(this);
		btns = trans = '';
		if (u && u != 0) {
			if ($(this).text().length > 0) {
				btns += '<a class="report-btn report-report" data-placement="bottom" title="Report this content"><span class="fa fa-flag"></span></a>';
				btns += '<a class="report-btn report-switch" data-placement="bottom" title="Use other report"><span class="fa fa-refresh"></span></a>';
				if (u == au) btns += '<a class="report-btn report-edit" data-placement="bottom" title="Edit"><span class="fa fa-pencil"></span></a> ';
			}
			transN = $(this).closest('.paragraph').attr('data-trans-num');
			btns += '<a class="report-btn report-contribute" data-placement="bottom" title="Contribute"><span class="fa fa-plus"></span></a>';
			if (transN > 0) trans = '<div class="gensmall">'+transN+' translates available</div>';
			if ($(this).text().length > 0) btns += '<span class="report-btn"><a class="report-translate fa fa-language" data-placement="bottom" title="Translate"></a>'+trans+'</span>';
			$(this).parent().children('.h3').addClass('with-btns').children('h3').append('<div class="report-btns">'+btns+'</div>');
		} else $(this).parent().children('.h3').addClass('with-btns');
		$source = $(this).parent().find('.chart-paragraph-source');
		sImg = $source.find('.s-info-thumb').attr('src');
		sUrl = $source.find('.s-info').attr('href');
		sTit = $source.find('.s-info-title').text();
		if (sImg) $(this).parent().children('.h3').children('h3').append('<img class="left report-source-thumb" style="margin-top:-3px" src="'+sImg+'" title="'+sTit+'"/>');
	})

	$('.chart-report-content .paragraph .report-switch').click(function() {
		$para = $(this).closest('.paragraph');
		$div = $para.children('div.chart-paragraph-content');
		old_rid = $para.attr('data-rid');
		$('.the-board').load(MAIN_URL+'/report/'+old_rid+'?v=window&type=related&iid='+old_rid, function () {
			selectReport(old_rid, $para.attr('data-id'));
		})
	});
if (u && u != 0) {
	$('.chart-report-content .paragraph .report-report').click(function() {
		$para = $(this).closest('.paragraph');
		$div = $para.children('div.chart-paragraph-content');
		id = $(this).closest('.paragraph').attr('data-rid');
		$('.the-board').load(MAIN_URL+'/report/'+id+'?v=window&type=report', function () {
			popup()
		})
	});
	$('.chart-report-content .paragraph .report-edit').click(function() {
		$para = $(this).closest('.paragraph');
		$div = $para.children('div.chart-paragraph-content');
		id = $(this).closest('.paragraph').attr('data-id');
		if ($div.closest('.paragraph').find('form.report-edit-form').length) $div.hide().closest('.paragraph').find('form.report-edit-form').show();
		else {
			var cont = $div.html();
			var rid = $para.attr('data-rid');
			$div.hide().after('<form class="report-edit-form" id="edit-'+id+'"><input type="hidden" name="rid-'+id+'" value="'+rid+'"/><textarea class="report-edit-textarea-'+id+'" name="content-'+id+'"></textarea><div class="add-form-submit right"><a type="reset" class="report-edit-form-cancel btn btn-default" name="Cancel">Cancel</a><input type="submit" class="btn" name="Submit"/></div><div class="clearfix"></div></form>');
			form('.report-edit-form#edit-'+id);
//			cont = $('.report-edit-textarea-'+id).sceditor('instance').toBBCode(cont);
			$('.report-edit-textarea-'+id).sceditor('instance').val(cont);
		}
		mscroll('.report-edit-form#edit-'+id);
		$div.closest('.paragraph').find('form.report-edit-form').find('.report-edit-form-cancel').click(function () {
			$(this).closest('form.report-edit-form').hide();
			$div.show()
		})
	})
	$('.chart-report-content .paragraph .report-contribute').click(function() {
		$div = $(this).closest('.paragraph').children('div.chart-paragraph-content');
		id = $(this).closest('.paragraph').attr('data-id');
		if ($div.closest('.paragraph').find('form.report-contribute-form').length) $div.closest('.paragraph').find('form.report-contribute-form').show();
		else {
			$div.after('<form class="report-contribute-form" id="contribute-'+id+'"><h4>Add a report</h4><div class="form-group"><div class="col-lg-3 no-padding control-label">Source</div><div class="col-lg-7"><select name="source-'+id+'" class="chosen-select form-control"><option value="0" selected>(by Me)</option><option value="-1">(Somewhere)</option>'+sources+'</select></div><div class="col-lg-2 control-label no-padding"><a href="'+MAIN_URL+'/source">Add a source</a></div><div class="clearfix"></div></div><textarea class="report-contribute-textarea-'+id+'" name="content-'+id+'"></textarea><div class="add-form-submit right"><a type="reset" class="report-contribute-form-cancel btn btn-default" name="Cancel">Cancel</a><input type="submit" class="btn" name="Submit"/></div><div class="clearfix"></div></form>');
			form('.report-contribute-form#contribute-'+id);
		}
		mscroll('.report-contribute-form#contribute-'+id);
		$div.closest('.paragraph').find('form.report-contribute-form').find('.report-contribute-form-cancel').click(function () {
			$(this).closest('form').hide()
		})
	})
	$('.chart-report-content .paragraph .report-translate').click(function() {
		$div = $(this).closest('.paragraph').children('div.chart-paragraph-content');
		id = $(this).closest('.paragraph').attr('data-id');
		if ($div.closest('.paragraph').find('form.report-translate-form').length) $div.closest('.paragraph').find('form.report-translate-form').show();
		else {
			$div.after('<form class="report-translate-form" id="translate-'+id+'"><h4>Add a report translation</h4><div class="form-group"><div class="col-lg-3 no-padding control-label">Translate to</div><div class="col-lg-9"><select multiple name="lang-'+id+'" class="chosen-select form-control translator-select">'+lng+'</select></div><div class="clearfix"></div></div><div class="form-group"><div class="col-lg-3 no-padding control-label">Translator</div><div class="col-lg-7"><select multiple name="translator-'+id+'" class="chosen-select form-control translator-select">'+me+'<option value="-1">(Somewhere)</option><optgroup label="Sources">'+sources+'</optgroup><optgroup label="Translators">'+translators+'</optgroup><optgroup label="Others">'+others+'</optgroup></select></div><div class="col-lg-2 control-label no-padding"><a href="'+MAIN_URL+'/source">Add a source</a></div><div class="clearfix"></div></div><textarea class="report-translate-textarea-'+id+'" name="content-'+id+'"></textarea><div class="add-form-submit right"><a type="reset" class="report-translate-form-cancel btn btn-default" name="Cancel">Cancel</a><input type="submit" class="btn" name="Submit"/></div><div class="clearfix"></div></form>');
			form('.report-translate-form#translate-'+id);
		}
		mscroll('.report-translate-form#translate-'+id);
		$div.closest('.paragraph').find('form.report-translate-form').find('.report-translate-form-cancel').click(function () {
			$(this).closest('form').hide()
		})
	})
}
});
