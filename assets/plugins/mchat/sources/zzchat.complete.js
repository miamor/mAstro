/**
 * Xử lý khi tải xong dữ liệu
 * Cập nhật dữ liệu
 */

/**
 * Tạo nhanh thẻ li trong menu action
 *
 * @param1 {Object} Thẻ ul mà nó gắn vào
 * @param2 {String} Mã lệnh cmd
 * @param3 {String} nickname dùng trong mã lệnh
 * @param4 {String} Nội dung thẻ li
 */
var quickAction = function(ele, cmd, user_name, txt) {
    if (user_name) {
        user_name = " " + user_name;
    } else {
        user_name = "";
    }
    $("<li>", {
        "class": "chatbox-action",
        "data-action": "/" + cmd + user_name,
        text: txt
    }).appendTo(ele);
};

var menuActionOne = true; // Chỉ chạy 1 lần

/**
 * Xử lý khi tải xong dữ liệu tin nhắn
 *
 * $param {htmlString} Dữ liệu tin nhắn
 */
var getDone = function(chatsource) {

    if (chatsource.indexOf("<!DOCTYPE html PUBLIC") === 0) { // Lỗi do logout hoặc bị ban
        if (chatsource.indexOf("You have been banned from the ChatBox") !== -1) {
            alert("Bạn đã bị cấm truy cập chatbox!");
            location.replace("/");
        } else {
            alert("Mất kết nối đến máy chủ. Vui lòng đăng nhập lại!");
            location.replace("/login?redirect=" + location.pathname);
        }
        clearInterval(refreshFunction);
        return false;
    } else { // Đã login

        /**
         * Tải dữ liệu chatbox
         *
         * chatbox_messages     Tin nhắn chatbox
         * chatbox_memberlist   Thành viên đang truy cập
         * chatbox_last_update  Thời điểm cập nhật cuối
         */
        eval(chatsource); // Chuyển đổi để các biến chạy được

        $("#chatbox-members").html(chatbox_memberlist); // Thêm dach sách thành viên

        $("a", "#chatbox-members").each(function() { // Duyệt từng thành viên trong danh sách

            var $this = $(this);

            /**
             * Tạo một array các thành phần trong oncontextmenu
             *
             * 0  "return showMenu" (không quan trọng)
             * 1  user_id
             * 2  user_name
             * 3  my_user_id
             * 4  my_chat_level
             * 5  my_user_level
             * 6  user_chat_level
             * 7  user_level
             * 8  event (không quan trọng)
             * 9  sid (không quan trọng)
             * 10 ";" (không quan trọng)
             */
            var dataMenu = $this.attr("oncontextmenu").split(/\(|,|\)/);
            $this.removeAttr("oncontextmenu"); // Xóa contextmenu để tạo menu mới

            var user_id = dataMenu[1],
                user_name = dataMenu[2].slice(1, -1),
                my_user_id = dataMenu[3],
                my_chat_level = dataMenu[4],
                my_user_level = dataMenu[5],
                user_chat_level = dataMenu[6],
                user_level = dataMenu[7],
                event = dataMenu[8],
                sid = dataMenu[9];

            $(".chatbox-change > h3").each(function() {
                var $h3 = $(this);
                if ($h3.text() == user_name && $h3.parent().is(":visible")) {
                    $this.parent().hide(); // Ẩn nick trong danh sách
                    return false;
                }
            });

            if (user_id === my_user_id) { // Nếu user_id trùng với my_user_id
                uId = my_user_id; // Lấy ra id của mình
                uName = user_name; // Lấy ra nickname của mình

                $("#chatbox-me > h2").removeClass("online away").addClass(userOnline(uName).closest("ul").prev("h4").attr("class").split(" ")[1]).html('<a href="/u' + user_id + '" target="_blank" style="color:' + $('span', $this).css('color') + '">' + uName + '</a>');
                $this.parent().remove();

                if (menuActionOne) {
                    quickAction("#chatbox-title ul", "out", false, "Rời khỏi phòng");
                    menuActionOne = false;
                }
            } else {

                var $setting = $("<div>").addClass("chatbox-setting");
                $setting.insertAfter($this);
                var $list = $("<ul>").addClass("chatbox-dropdown");
                $list.appendTo($setting);

                quickAction($list, "chat", user_name, "Trò chuyện riêng");
                // quickAction($list, "gift", user_name, "Tặng video, nhạc");

                if (my_chat_level == 2) { // Mình có quyền quản lý              
                    if (user_chat_level != 2) { // Nick này cấp bậc thấp hơn mình

                        quickAction($list, "kick", user_name, "Đuổi khỏi chatbox");
                        quickAction($list, "ban", user_name, "Cấm truy cập chat");
                    }
                    if (my_user_level == 1 && user_chat_level == 2 && user_level != 1) { // Nick này có quyền quản lý nhưng cấp thấp hơn mình
                        quickAction($list, "unmod", user_name, "Xóa quyền quản lý");
                    } else if (my_user_level == 1 && user_chat_level != 2) { // Nick này chưa có quền quản lý và cấp thấp hơn mình
                        quickAction($list, "mod", user_name, "Thăng cấp quản lý");
                    }
                }

            }

        });

        // Đặt icon online và away dựa vào class ở tiêu đề
        $(".chatbox-change > h3").each(function() { // Duyệt qua từng tab riêng         
            var $this = $(this),
                $status = userOnline($this.text()).closest("ul").prev("h4"),
                clas;
            if ($status.hasClass("online")) {
                clas = "online";
            } else if ($status.hasClass("away")) {
                clas = "away";
            }
            $this.parent().removeClass("online away").addClass(clas);
        });

        filterMess(chatbox_messages); // Lọc và xử lý các tin nhắn trong chatbox_messages
    }
};

var disconnect = function() {
    clearInterval(refreshFunction); // Dừng tự cập nhật    
    $("#chatbox-action-logout").addClass("isOut");
    $(".chatbox-action-checkbox").prop("checked", false).hide();
    $messenger.val("/away");
    $form.submit();
    $wform.css("bottom", "-90px");
    setTimeout(function() {
        $wform.hide();
    }, 500);
    $wrap.css({
        bottom: 0,
        opacity: 0.3
    });
    $("#chatbox-tabs").css("opacity", 0.3);
};

/**
 * Tải dữ liệu và cập nhật nội dung chatbox
 *
 * @param {URL} Đường dẫn tải dữ liệu
 */
var update = function(url) {

    $.get(url).done(function(data) {
        getDone(data);
    }).fail(function(data) {
        if (data.responseText.indexOf("document.getElementById('refresh_auto')") === 0 && $("#chatbox-input-autologin").prop("checked")) { // Nếu disconnect
            $.post(cURL, { // Gửi tin nhắn rỗng để connect
                mode: "send",
                sent: ""
            }).done(function() {
                $.get(url).done(function(data) { // Tải dữ liệu chatbox
                    getDone(data);
                });
            });
        } else {
            // Xử lý cho các lỗi khác không phải do disconnect như mất kết nối internet (có thể xảy ra do refresh trang trong lúc đang tải)
            disconnect();
        }
    });

};

var autoUpdate = function() { // Tự cập nhật mỗi 5s
    refreshFunction = setInterval(function() {
        update(cURL);
    }, 5000);
};

update(cURL);
autoUpdate();

// Bật tắt tự động cập nhật
$("#chatbox-input-autorefesh").change(function() {
    if ($(this).prop("checked")) { // Đã check
        autoUpdate();
    } else {
        clearInterval(refreshFunction);
    }
});

$("#chatbox-action-logout").click(function() {
    var $this = $(this);
    if ($this.hasClass("isOut")) {
        $(".chatbox-action-checkbox").prop("checked", true).show();
        $this.removeClass("isOut");
        $wform.show();
        setTimeout(function() {
            $wform.css("bottom", 0);
        }, 10);
        $wrap.css({
            bottom: 90,
            opacity: 1
        });
        $("#chatbox-tabs").css("opacity", 1);
        setTimeout(function() {
            $wrap.scrollTop(99999);
        }, 500);
        autoUpdate();
    } else {
        disconnect();
    }
});
