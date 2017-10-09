var regexpPM = /^(<span style="color: (#[0-9A-Fa-f]{6}|rgb\(\d{2,3}, \d{2,3}, \d{2,3}\));?">(<(strike|i|u|strong)>)*)(\d{13,}_\d+)({.*})(\["[^"]+"(\,"[^"]+")+\])(.*)$/; // Mã kiểm tra định dạng tin nhắn riêng
 
/**
 * Xử lý dữ liệu tin nhắn để chuyển đến dạng tab riêng mình cần
 *
 * @param {htmlString} Dữ liệu tin nhắn mới
 */
var newMessage = function (Messages) {
    if (Messages) {
 
        var arr = $.parseHTML(Messages); // Chuyển htmlString tin nhắn thành HTML
 
        $.each(arr, function (i, val) { // Duyệt qua từng tin
 
            var $this = $(this); // Đặt biến cho tin nhắn đang xét
 
            var $msg = $(".msg", $this);
 
            var messText = $msg.html(); // Lấy HTML phần nội dung tin nhắn          
 
            if (regexpPM.test(messText)) { // Nếu đúng định dạng tin riêng
 
                /**
                 * Tạo array chứa các thành phần của tin nhắn riêng
                 *
                 * 0  htmlString
                 * 1  Tag định dạng văn bản
                 * 2  Mã màu
                 * 3  Tag (không quan trọng)
                 * 4  Tag (không quan trọng)
                 * 5  data-id
                 * 6  conversation name
                 * 7  arrayString nickname các thành viên
                 * 8  Nickname thành viên cuối (không quan trọng)
                 * 9  nội dung và tag đóng
                 */
                var arrMess = messText.match(regexpPM);
 
                var arrUsers = JSON.parse(arrMess[7]); // Array nickname các thành viên
 
                var indexUser = $.inArray(encodeURIComponent(uName), arrUsers); // Lấy vị trí index nickname của thành viên đang truy cập trong arrayString
 
                if (indexUser !== -1) { // Nếu có nickname của thành viên đang truy cập trong danh sách
 
                    var dataId = arrMess[5]; // data-id lấy từ tin nhắn
 
                    var $private = $('.chatbox-content[data-id="' + dataId + '"]'); // Đặt biến cho mục chat riêng ứng với data-id lấy được
                    var $tabPrivate = $('.chatbox-change[data-id="' + dataId + '"]'); // Đặt biến cho tab của mục tương ứng
 
                    if (!$tabPrivate.length) { // Nếu chưa có mục chat riêng thì tạo mới
                        $private = $("<div>", {
                            "class": "chatbox-content",
                            "data-id": dataId,
                            style: "display: none;"
                        }).appendTo("#chatbox-wrap"); // Thêm vào khu vực chatbox
 
                        var chat_name = arrMess[6].slice(1, -1); // Đặt biến cho tên tab là phần ký tự trong dấu {}
                        var $tabname;
                        if (chat_name === '') {
                            chat_name = $.grep(arrUsers, function (n, i) {
                                return (n !== encodeURIComponent(uName));
                            });
 
                            if (chat_name.length === 1) {
                                chat_name = decodeURIComponent(chat_name[0]);
                                $tabname = userOnline(chat_name);
                                $tabname.parent().hide();
                            } else {
                                chat_name = decodeURIComponent(chat_name.join(", ")); // Đặt tên tab là các nickname đang chat với mình
                            }
                        }
 
                        $tabPrivate = $("<div>", {
                            "class": "chatbox-change",
                            "data-id": dataId,
                            "data-name": arrMess[6],
                            "data-users": arrMess[7],
                            html: '<h3 style="color:' + $("span", $tabname).css('color') + '">' + chat_name + '</h3><span class="chatbox-change-mess"></span>'
                        }).appendTo("#chatbox-list"); // Thêm vào khu vực tab
 
                    } else if ($tabPrivate.is(":hidden") && $msg.text().indexOf("]/out") === -1) {
                        $tabPrivate.show();
                        userOnline($tabPrivate.find("h3").text()).parent().hide();
                    }

                    $msg.html(zzEmoFb.checkEmo(arrMess[1] + arrMess[9])); // Xóa phần đánh dấu tin nhắn
                     
                    $this.appendTo($private); // Thêm tin nhắn vào mục chat riêng theo data-id
 
                }
 
            } else { // Nếu không đúng định dạng mã tin riêng
                $msg.html(zzEmoFb.checkEmo($msg.html()));
                $this.appendTo('.chatbox-content[data-id="publish"]'); // Thêm tin nhắn thường vào mục chat chung
            }
 
            var msgId = $this.closest(".chatbox-content").attr("data-id");
            var $msgTab = $(".chatbox-change[data-id='" + msgId + "']");
            messText = $msg.text();
            if (messText === "/buzz") { // Nếu có ký hiệu buzz
                $msg.html('<img src="http://i.imgur.com/9GvQ6Gd.gif" width="62" height="16" />'); // Thay bằng ảnh buzz
                if (!firstTime && $("#chatbox-main").css("left") !== "-1px") { // Không chạy hiệu ứng buzz trong lần truy cập đầu tiên
                    $msgTab.click();
                    $("#chatbox-forumvi").addClass("chatbox-buzz");
                    $("#chatbox-buzz-audio")[0].play();
                    setTimeout(function () {
                        $("#chatbox-forumvi").removeClass("chatbox-buzz");
                        $messenger.focus();
                    }, 1000);
                }
            } else if (messText.indexOf("/out") === 0 && msgId !== "publish") {
                if ($this.find(".user > a").text() === uName) {
                    $msgTab.add(".chatbox-content[data-id='" + msgId + "']").hide();
                    var otherUser = decodeURIComponent($.grep($msgTab.data("users"), function (n, i) {
                        return (n !== encodeURIComponent(uName));
                    })[0]);
                    userOnline(otherUser).parent().show();
                    if (my_getcookie('chatbox_active') === msgId) {
                        $(".chatbox-change[data-id='publish']").click();
                        my_setcookie('chatbox_active', msgId);
                    }
                    $this.replaceWith('<p class="chatbox-userout me clearfix">Bạn đã rời khỏi phòng.</p>');
                } else {
                    $this.replaceWith('<p class="chatbox-userout clearfix"><strong>' + $this.find('.user > a').text() + '</strong> đã rời khỏi phòng.</p>');
                }
            }
 
            var messTime = $(".date-and-time", $this), // Lấy định dạng thời gian
                messTimeText = messTime.text();
            var arrTime = messTimeText.match(/\[(\S+)\s(\S+)\]/);
 
            messTime.text("[" + arrTime[1] + "]"); // Dùng thông số giờ:phút:giây cho tin nhắn
 
            if (!$this.closest(".chatbox-content").find(".chatbox-date:contains('" + arrTime[2] + "')").length) { // Nếu trong mục chưa có thông số ngày/tháng/năm
                $this.before('<p class="chatbox-date clearfix">' + arrTime[2] + '</p>'); // Thêm vào thông số ngày/tháng/năm
            }
 
        });
 
        setTimeout(function () {
            var $tabCookie = $('.chatbox-change[data-id="' + my_getcookie('chatbox_active') + '"]');
            if ($tabCookie.length && $tabCookie.is(":visible")) {
                $('.chatbox-change[data-id="' + my_getcookie('chatbox_active') + '"]').click(); // Active tab khi có cookie
            }
        }, 200);
         
        var messCounterObj = JSON.parse(sessionStorage.getItem("messCounter"));
        var allNewMess = 0; // Đếm số tin nhắn mới
 
        $(".chatbox-content").each(function () {
            var $this = $(this),
                dataID = $this.attr("data-id");
            var messLength = $(".chatbox_row_1, .chatbox_row_2", $this).length; // Số tin nhắn
            var $count = $(".chatbox-change[data-id='" + dataID + "']").find(".chatbox-change-mess"); // tab tương ứng
            var mLength = messLength; // đặt biến trung gian
 
            var oldMessLength = 0;
            if (messCounterObj && messCounterObj[dataID]) {
                oldMessLength = parseInt(messCounterObj[dataID], 10);
            }
 
            mLength = messLength - oldMessLength; // trừ lấy số tin mới
 
            if (mLength <= 0) { // Nếu không có tin mới
                mLength = ""; // Xóa bộ đếm
            } else {
                allNewMess += mLength; // Lấy tổng số tin mới
                mLength = "<strong>" + mLength + "</strong>";
            }
 
            $count.html(mLength);
 
        });
 
        if (allNewMess > 0) { // Nếu có tin nhắn mới
            var tit = $title.text();
            var regexpTit = /^\(\d+(\)\s.*$)/;
            if (regexpTit.test(tit)) { // Đã có số đếm
                tit = "(" + allNewMess + tit.match(regexpTit)[1];
            } else { // Chưa có số đếm
                tit = "(" + allNewMess + ") " + tit;
            }
            $title.text(tit);
        }
 
        setTimeout(function () {
            $wrap.scrollTop(99999); // Cuộn xuống dòng cuối cùng
        }, 300);
    }
}
 
var lastMess; // Lấy html của tin cuối cùng
 
/**
 * Xử lý các tin nhắn sau khi tải về
 * 
 * @param {htmlString} Dữ liệu tin nhắn
 */
var filterMess = function (chatbox_messages) { 

    var newChatboxMessages, thisLastMess;
    if (chatbox_messages) { // Nếu có tin nhắn
        thisLastMess = chatbox_messages.match(/<p class="chatbox_row_(1|2) clearfix">(?:.(?!<p class="chatbox_row_(1|2) clearfix">))*<\/p>$/)[0]; // Lấy tin nhắn cuối trong lần này
        if (lastMess === undefined) { // Nếu trước đó ko có tin cuối => lần truy cập chatbox đầu tiên hoặc chatbox mới clear
            newChatboxMessages = chatbox_messages;
            lastMess = thisLastMess; // Cập nhật tin nhắn cuối
            newMessage(newChatboxMessages); // Xử lý tin nhắn và đưa vào chatbox
        } else if (lastMess !== thisLastMess) { // Không có tin mới
            newChatboxMessages = chatbox_messages.split(lastMess)[1]; // Cắt bỏ tin nhắn cũ, lấy tin mới
            lastMess = thisLastMess; // Cập nhật tin nhắn cuối
            newMessage(newChatboxMessages); // Xử lý tin nhắn và đưa vào chatbox
        }
    } else { // Nếu không có tin nhắn (có thể là do clear chatbox)
        lastMess = undefined; // Xóa giá trị tin nhắn cuối
        var obj = {};
        $(".chatbox-content").each(function(){
            var $this = $(this);
            obj[$this.attr("data-id")] = $this.children("p").length;
        });
        sessionStorage.setItem("messCounter", JSON.stringify(obj)); // Lưu vào sessionStorage
    }
 
    $("#chatbox-forumvi:hidden").fadeIn(200); // Hiển thị chatbox
    firstTime = false;
};