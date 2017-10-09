/*! 
 * zzEmoFb ver 0.1 by zzbaivong
 * http://devs.forumvi.com/
 */

var zzEmoFb = {
	all: "",
	emoFB: {},

	imgEmo: function (b, a) {
		return '<img class="smiley_FB" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="' + b.replace(/\"/, "&quot;") + '" style="background-position:' + a + '" />'
	},

	checkEmo: function (b) {
		return b = b.replace(zzEmoFb.all, function (a) {
			return zzEmoFb.imgEmo(a, zzEmoFb.emoFB[a])
		})
	},

	list: function (b, a) {
		$.each(zzEmoFb.emoFB, function (c, d) {
			b.test(c) && $(a).append(zzEmoFb.imgEmo(c, d))
		})
	},

	addSmiley: function (ele) {
		var normal = /\bO:\)\B|\bo\.O\b|\bO\.o\b|\b8\|\B|\b8\)\B|\b3:\)\B|\B(\(y\)\B|\B:3\b|\B:\'\(\B|\B:\(\B|\B:O\b|\B:D\b|\B&gt;:\(\B|\B&lt;3\b|\B\^_\^\B|\B:\*\B|\B:v\b|\B&lt;\(\"\)\B|\B:poop:\B|\B:putnam:\B|\B\(\^\^\^\)\B|\B:\)\B|\B-_-\B|\B:P\b|\B:\/\B|\B&gt;:O\b|\B;\)\B|\B:\|\]\B)/,
			more = /\B:fb([0-9]|[1-9][0-9]|1[0-9][0-9]|20[0-9]):\B/;
			zzEmoFb.all = RegExp((normal + more).replace("//", "|").replace(/^\/|\/$/g, ""), "g");

		for (var b = 0, a, c = 0; 239 > c; c++) {
			switch (c) {
			case 210:
				a = "o.O";
				break;
			case 211:
				a = "O.o";
				break;
			case 212:
				a = ":'(";
				break;
			case 213:
				a = "3:)";
				break;
			case 214:
				a = ":(";
				break;
			case 215:
				a = ":O";
				break;
			case 216:
				a = "8)";
				break;
			case 217:
				a = ":D";
				break;
			case 218:
				a = "&gt;:(";
				break;
			case 219:
				a = "&lt;3";
				break;
			case 220:
				a = "^_^";
				break;
			case 221:
				a = ":*";
				break;
			case 222:
				a = ":v";
				break;
			case 223:
				a = '&lt;(")';
				break;
			case 224:
				a = ":poop:";
				break;
			case 225:
				a = ":putnam:";
				break;
			case 226:
				a = "(^^^)";
				break;
			case 227:
				a = ":)";
				break;
			case 228:
				a = "-_-";
				break;
			case 229:
				a = "8|";
				break;
			case 230:
				a = ":P";
				break;
			case 231:
				a = ":/";
				break;
			case 232:
				a = "&gt;:O";
				break;
			case 233:
				a = ";)";
				break;
			case 234:
				a = "(y)";
				break;
			case 235:
				a = ":3";
				break;
			case 236:
				a = ":|]";
				break;
			case 237:
				a = "O:)";
				break;
			default:
				a = ":fb" + c + ":"
			}
			b -= 17;
			zzEmoFb.emoFB[a] = "0 " + b + "px"
		};

		var $smiley = $("<div>", {
			"id": "smiley_FB_frame"
		}).appendTo(ele);

		zzEmoFb.list(normal, "#smiley_FB_frame");

		$smiley.append('<p class="more">--- Xem th\u00eam ---</p>');

		var $more = $(".more", $smiley);

		$more.click(function () {
			$("p.less", $smiley).length ? $more.nextAll().show() : (zzEmoFb.list(more, "#smiley_FB_frame"), $smiley.append('<p class="less">--- Thu g\u1ecdn ---</p>'));
			$(this).hide();
		});

		$smiley.on("click", ".less", function () {
			$(this).hide();
			$more.show().nextAll().hide()
		});

		$smiley.on("click", "img", function (e) {
			$messenger[0].value += " " + this.alt;
			if (!e.ctrlKey) {
				$(ele).removeClass("active");
				$form.submit();
			}
		});

		$(ele).click(function () {
			$(this).toggleClass("active");
		});
		
		$smiley.click(function(e){
			e.stopPropagation();
		});
		
		$(document).click(function (e) {
			if (!$(e.target).closest(ele).length) {
				$(ele).removeClass("active");
			}
		});
	}
};

zzEmoFb.addSmiley("#chatbox-option-smiley");