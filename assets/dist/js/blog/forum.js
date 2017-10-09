$(document).ready(function () {

	$.getJSON("?do=staPost", function (data) {
		$.each(data, function (key, val) {
			var items = [];
			$.each(val, function (i, v) {
				items.push('<li>\
	<div class="lasttopic-title col-lg-6 no-padding-right">\
		<a title="Last post: '+v['last_post']+'" href="'+v['link']+'">'+v['title']+'</a>\
		<div class="tooltip_data" style="display:none">\
			<p><span style="color:red">Tiêu đề</span>: '+v['title']+'</p>\
			<p><span style="color:blue">Gửi lúc</span>: '+v['created']+'</p>\
		</div>\
	</div>\
	<div class="col-lg-1 center">\
		'+v['views']+'\
	</div>\
	<div class="col-lg-1 center">\
		'+v['replies']+'\
	</div>\
	<div class="col-lg-2 no-padding-right">\
		<a href="'+v['cat']['link']+'">'+v['cat']['title']+'</a>\
	</div>\
	<div class="col-lg-2 no-padding-right" style="text-align:right">\
		<a href="'+v['lastpost']['author']['link']+'">'+v['lastpost']['author']['name']+'</a>\
	</div>\
	<div class="clearfix"></div>\
</li>');
			});
			if (items) {
				$("<ol/>", {
					"class": "olList group_poster s-"+key,
					html: items.join("")
				}).appendTo("#"+key);
				icons('s-'+key);
			}
		})
	})
})
