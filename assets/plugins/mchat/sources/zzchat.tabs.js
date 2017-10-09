/**
 * Chuyển/xóa/thêm tab chat
 */

// Đánh dấu đã xem hết tin nhắn
$messenger.on("focus click keydown", function () {
	var dataID = $messenger.attr("data-id");
	var $countMess = $(".chatbox-change[data-id='" + dataID + "']").find(".chatbox-change-mess");
	var newMess = parseInt($countMess.text(), 10);

	if (newMess) {
		var $content = $(".chatbox-content[data-id='" + dataID + "']");
		var obj = JSON.parse(sessionStorage.getItem("messCounter")) || {};
		obj[dataID] = $(".chatbox_row_1, .chatbox_row_2", $(".chatbox-content[data-id='" + dataID + "']")).length;
		sessionStorage.setItem("messCounter", JSON.stringify(obj)); // Lưu vào sessionStorage

		var noSeen = $("p", $content).length - newMess - 1;
		var $noSeen = $("p:gt(" + noSeen + ")", $content);

		// Hiệu ứng cho tin nhắn mới
		$noSeen.addClass("chatbox-newmess");
		setTimeout(function () {
			$noSeen.removeClass("chatbox-newmess");
		}, 3000);

		$title.text($title.text().replace(/\(\d+\)\s/, "")); // Xóa chỉ số tin trên tiêu đề
		$countMess.empty(); // Xóa số đếm tin mới
	}
});

// Chuyển tab
$("#chatbox-list").on("click", ".chatbox-change", function () {
	var $this = $(this);
	$(".chatbox-change.active").removeClass("active");
	$this.addClass("active");
	var dataID = $this.attr("data-id");
	$(".chatbox-content").hide();
	$('.chatbox-content[data-id="' + dataID + '"]').show();
	var key = "";
	var $titSetting = $("#chatbox-title >.chatbox-setting");
	if (dataID !== "publish") {
		key = dataID + $this.attr("data-name") + $this.attr("data-users");
		$titSetting.show();
	} else {
		$titSetting.hide();
	}
	$form.attr("data-key", key);
	$messenger.attr("data-id", dataID);
	$("#chatbox-title > h2").text($("h3", $this).text());

	$messenger.focus();
	my_setcookie("chatbox_active", dataID, false); // Lưu cookie cho tab vừa click
	$wrap.scrollTop(99999); // Cuộn xuống dòng cuối cùng

});

// Chạy các chức năng từ menu
$("#chatbox-members, #chatbox-title").on("click", ".chatbox-action", function () {
	$messenger.val($(this).attr("data-action"));
	$form.submit();
});

// Ẩn/hiện tab
$("#chatbox-hidetab").click(function () {
	var $this = $(this),
		tabs, main, status;
	$this.toggleClass(function () {
		if ($this.hasClass("show")) { // ẩn tab
			tabs = -271;
			main = -1;
			status = "hide";
		} else { // hiện tab
			tabs = 0;
			main = 270;
			status = "show";
		}
		$("#chatbox-tabs").css("left", tabs);
		$("#chatbox-main").css("left", main);
		my_setcookie("chatbox_tabs", status, false); // Lưu cookie cho tab vừa click
	});
});
if (my_getcookie("chatbox_tabs") === "hide") {
	$("#chatbox-hidetab").click();
}

// Buzz
$("#chatbox-option-buzz").click(function () {
	if ($(this).html() === "BUZZ") {
		$messenger.val("/buzz");
		$form.submit();
	}
});