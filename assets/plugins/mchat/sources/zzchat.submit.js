/**
 * Gửi tin nhắn
 * 
 * @param {String} Nội dung tin nhắn
 */
var sendMessage = function (val) {
    oldMessage = $messenger.val();
    $.post(cURL, {
        mode: "send",
        sent: val,
        sbold: $("#chatbox-input-bold").val(),
        sitalic: $("#chatbox-input-italic").val(),
        sunderline: $("#chatbox-input-underline").val(),
        sstrike: $("#chatbox-input-strike").val(),
        scolor: $("#chatbox-input-color").val()
    }).done(function () {
 
        // Cập nhật tin nhắn
        $.get(cURL).done(function (data) {
            getDone(data);
            $messenger.focus();
        });
    }).fail(function () {
        alert("Lỗi! Tin nhắn chưa được gửi.");
        $messenger.val(oldMessage);
        // Xử lý cho lỗi mất kết nối internet (có thể xảy ra do refresh trang trong lúc đang tải)
    });
};
 
$form.submit(function (event) { // Gửi tin nhắn
    event.preventDefault(); // Chặn sự kiện submit
 
    var messVal = $messenger.val();
    if ($.trim(messVal) !== "") {
 
        var regexpCmd = /^\/(chat|gift|toggle|kick|away|ban|unban|mod|unmod|cls|clear|me)(\s(.+))?$/;
 
        if (regexpCmd.test(messVal)) { // Nếu là các lệnh cmd
            var cmd = messVal.match(regexpCmd);
 
            var action = cmd[1],
                nickname = cmd[3],
                nicknameencode = encodeURIComponent(nickname),
                uNameencode = encodeURIComponent(uName);
 
            if (/^(chat|gift|toggle)$/.test(action)) { // Những lệnh không gửi đi
                if (action === "chat") {
                    var nickdecode = decodeURIComponent(nickname);
 
                    // Đặt biến cho tab chat riêng
                    var $newTab = $('.chatbox-change[data-users="[\\"' + uNameencode + '\\",\\"' + nicknameencode + '\\"]"]');
                    if (!$newTab.length) {
                        $newTab = $('.chatbox-change[data-users="[\\"' + nicknameencode + '\\",\\"' + uNameencode + '\\"]"]');
                    }
 
                    var $user = userOnline(nickname);
 
                    if ($newTab.length) { // Nếu đã có tab chat riêng
                        $newTab.show().click();
                    } else {
                        if ($user.length) { // Nếu có nickname trong danh sách
                            $user.parent().hide(); // Ẩn nickname trong danh sách
 
                            if (!$newTab.length) { // Nếu chưa có tab chat
                                var dataId = new Date().getTime() + "_" + uId; // Tạo data-id
 
                                // Đặt icon online và away dựa vào class ở tiêu đề
                                var clas,
                                    $status = $user.parent().parent().prev("h4");
                                if ($status.hasClass("online")) {
                                    clas = " online";
                                } else if ($status.hasClass("online")) {
                                    clas = " away";
                                } else {
                                    clas = "";
                                }
                                $newTab = $("<div>", {
                                    "class": "chatbox-change" + clas,
                                    "data-id": dataId,
                                    "data-name": "{}",
                                    "data-users": '["' + uNameencode + '","' + nicknameencode + '"]',
                                    html: '<h3 style="color:' + $('span', $user).css('color') + '">' + nickname + '</h3><span class="chatbox-change-mess"></span>'
                                }).appendTo("#chatbox-list"); // Tạo tab chat riêng mới 
                                $newTab.click();
                                $("<div>", {
                                    "class": "chatbox-content",
                                    "data-id": dataId,
                                    "style": "display: none;"
                                }).appendTo($wrap); // Tạo mục chat riêng mới
                            }
 
                        } else { // Nếu không có nickname trong danh sách
                            if ($newTab.length) { // Nếu có tab chat riêng
                                $newTab.removeClass("online away").click(); // Xóa trang thái online, away về trạng thái offline
                            } else {
                                if (nickname === uName) {
                                    alert("Phát hiện nghi vấn Tự kỷ ^^~");
                                } else {
                                    alert("Thành viên " + nickname + " hiện không truy cập!");
                                }
                            }
                        }
                    }
                } else if (action === "toggle") {
                    $("#chatbox-hidetab").click();
                }
            } else { // Những lệnh sẽ được gửi đi
                sendMessage(messVal);
            }
        } else { // Nếu là tin nhắn thường
            var messWithKey = $form.attr("data-key") + messVal; // tin nhắn có key (tin riêng)
            var messId = $messenger.attr("data-id");
            if (messVal == "/buzz") { // BUZZ
 
                var $buzz = $("#chatbox-option-buzz");
                if ($buzz.html() === "BUZZ") { // BUZZ chưa disable
                    var timeBuzz = 59, // 30s
                        timeBuzzCount;
 
                    sendMessage(messWithKey);
 
                    $buzz.addClass("disable"); // Thêm class để hiện số đếm lùi
                    $buzz.html(60);
                    timeBuzzCount = setInterval(function () {
                        var zero = timeBuzz--;
                        $buzz.html(zero);
                        if (zero <= 0) { // Cho phép BUZZ
                            clearInterval(timeBuzzCount);
                            $buzz.removeClass("disable");
                            timeBuzz = 59;
                            timeBuzzCount = undefined;
                            $buzz.html("BUZZ");
                        }
                    }, 1000);
                }
            } else if (messVal == "/out" && messId !== "publish") {
                sendMessage(messWithKey);
            } else {
                sendMessage(messWithKey);
            }
        }
 
        $messenger.val("");
    }
});
