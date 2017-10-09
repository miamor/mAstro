/*!
 * jQuery plugin zzChat v0.1
 * Chatbox forumvi
 *
 * Copyright (c) 2014 Zzbaivong (http://devs.forumvi.com)
 *
 * Licensed under the MIT license - http://opensource.org/licenses/MIT
 */

(function ($) {

    "use strict";

    var callback = {},
        refreshFunction,

        Z = $.zzchat = function (options) {

        // Thông số mặc định
        var callback = $.extend({

            beforeLoad: function () {}, // Trước mỗi lần tải dữ liệu
            afterLoad: function () {}, // Sau mỗi lần tải dữ liệu

            disconnect: function () {}, // Khi bị disconnect
            banned: function () {}, // Khi bị banned
            logout: function () {}, // Khi bị logout
            notLoaded: function () {}, // Khi gặp lỗi tải dữ liệu mà không phải bị disconnect

            messageEach: function () {}, // Hoàn thành xử lý từng tin nhắn
            messageAll: function () {}, // Hoàn thành xử lý tất cả tin nhắn

            userEach: function () {}, // Hoàn thành xử lý từng thành viên
            userAll: function () {}, // Hoàn thành xử lý tất cả thành viên

            update: function () {}, // Cập nhật tin nhắn
            autoUpdate: function () {}, // Tự cập nhật tin nhắn
            stopUpdate: function () {}, // Dừng cập nhật tin nhắn

            beforeSend: function () {}, // Trước lúc gửi tin
            doneSend: function () {}, // Gửi tin thành công
            failSend: function () {}, // Gửi tin lỗi
            afterSend: function () {} // Sau khi gửi tin, bao gồm cả gửi lỗi lẫn thành công

        }, options);

        return this;

    };
    Z.data = {

        me: "", // uid của người đang chat (mình)

        user: { // Thông số mỗi user
            // id: { // User id
            //     user_id     : "", // user id
            //     user_name   : "", // nickname
            //     user_color  : "", // Màu nick (nếu có)
            //     chat_status : "", // online/away/offline
            //     user_level  : "", // cấp bậc trong diễn đàn
            //     chat_level  : "", // cấp bậc trong chatbox, chat level 2 sẽ có @
            //     user_source : ""  // htmlString của user
            // }
        },

        chatroom: { // Thông số mỗi phòng chat
            // id: { // Thời điểm tạo phòng và user_id người tạo
            //     room_dateUTC : "", // Thời điểm tạo phòng chat, định dạng UTC
            //     room_date    : "", // Thời điểm tạo phòng chat, định dạng hh:mm:ss dd/mm/yy
            //     starter_id   : "", // Id người tạo phòng
            //     room_name    : "", // Tên phòng
            //     chatters     : "", // Danh sách id người dùng
            //     others       : "", // Danh sách id người dùng không phải mình
            //     mess_length  : "", // Tổng số tin trong phòng chat
            //     message      : [{
            //         room_id      : "", // Id phòng chat
            //         mess_dateUTC : "", // Thời điểm nhắn tin, định dạng UTC, chuyển từ thông tin trong chatbox
            //         mess_date    : "", // Thời điểm nhắn tin, định dạng hh:mm:ss dd/mm/yy trong chatbox
            //         poster_id    : "", // Id người nhắn tin đó
            //         cmd          : "", // Mã lệnh bắt đầu bằng / không có khoảng trắng
            //         cmd_plus     : "", // Thông tin thêm cho lệnh cmd(nếu có)
            //         mess_source  : "", // htmlString của toàn bộ tin nhắn
            //         mess_content : ""  // htmlString phần nội dung
            //     }]
            // }
        },

        all_mess_length: 0, // Tổng số tin trong chatbox
        new_mess: "", // Nội dung của tin nhắn mới nhất
        dateUTC_begin: "", // Thời điểm bắt đầu vào chatbox
        date_begin: "" // Thời điểm bắt đầu vào chatbox, định dạng hh:mm:ss dd/mm/yy

    };

    Z.firstTime = true; // Lần truy cập đầu tiên

    Z.create = {

        block: function (Id, Type, Content) {
            Id = "chatbox-block-" + Id;
            if (Type !== null) {
                Id = "chatbox-" + Type + "-" + Id;
            }
            var $div = $("<div>", {
                id: "chatbox-" + Type + "-" + Id
            });
            if (Content !== null) {
                $div.html(Content);
            }
            return $div;
        },

        input: function (Id, Type, Val) {
            Id = "chatbox-button-" + Id;
            if (Type !== null) {
                Id = "chatbox-" + Type + "-" + Id;
            }
            var $input = $("<input>", {
                id: "chatbox-" + Type + "-" + Id,
                type: Type
            });
            if (Val !== null) {
                $input.val(Val);
            }
            return $input;
        },

        checkbox: function (Id, Content) {
            return $("<div>", {
                id: "chatbox-checkbox-" + Id,
                html: '<input type="checkbox" id="chatbox-checkbox-input-' + Id + '" name="' + Id + '" checked /><label for="chatbox-checkbox-input-' + Id + '">' + Content + '</label>'
            });
        },

        audio: function (Name) {
            return $("<audio>", {
                id: "chatbox-audio-" + Name,
                html: '<source src="' + Name + '.ogg" type="audio/ogg" /><source src="' + Name + '.mp3" type="audio/mpeg" />'
            }).appendTo("body");
        }

    };

    // Đặt và lấy giá trị cookie
    Z.cookie = {

        /**
         * Lấy cookie
         *
         * @param {String} Tên cookie
         */
        get: function (name) {
            cname = name + '=';
            cpos = document.cookie.indexOf(cname);
            if (cpos != -1) {
                cstart = cpos + cname.length;
                cend = document.cookie.indexOf(";", cstart);
                if (cend == -1) {
                    cend = document.cookie.length;
                }
                return unescape(document.cookie.substring(cstart, cend));
            }
            return null;
        },

        /**
         * Đặt cookie
         *
         * @param1 {String}  name   Tên cookie
         * @param2 {String}  value  Giá tri cookie
         * @param3 {Boolean} sticky Thời gian lưu trữ theo session hoặc vĩnh viễn
         * @param4 {URL}     path   Đường dẫn trang lưu trữ
         */
        set: function (name, value, sticky, path) {
            expires = "";
            domain = "";
            if (sticky) {
                expires = "; expires=Wed, 1 Jan 2020 00:00:00 GMT";
            }
            if (!path) {
                path = "/";
            }
            document.cookie = name + "=" + value + "; path=" + path + expires + domain + ';';
        }

    };

    /**
     * Chuyển đổi định dạng thời gian
     *
     * @param  {String}        type "def"(hh:mm:ss dd/mm/yy) hoặc "utc"(chuẩn thời gian UTC)
     * @param  {String/Number} time Giá trị thời gian
     * @return {String}             Giá trị thời gian đã chuyển đổi
     */
    Z.date = function (type, time) {

        var format;
        switch (type) {

            // Chuyển thông số thời gian từ định dạng hh:mm:ss dd/mm/yy sang dạng chuẩn UTC
        case "utc":
            time = time.split(/\s|\/|:/);
            format = Date.UTC("20" + time[5], (time[4] - 1), time[3], (time[0] - 7), time[1], time[2], 0);
            break;

            // Chuyển thông số thời gian từ định dạng UTC sang dạng hh:mm:ss dd/mm/yy
        case "def":
            var a = (new Date(time)).toString().split(/\s/);
            format = a[4] + " " + a[2] + "/" + {
                Jan: "01",
                Feb: "02",
                Mar: "03",
                Apr: "04",
                May: "05",
                Jun: "06",
                Jul: "07",
                Aug: "08",
                Sep: "09",
                Oct: "10",
                Nov: "11",
                Dec: "12"
            }[a[1]] + "/" + a[3].slice(2);
            break;
        }
        return format;

    };

    /**
     * Mã định dạng tin nhắn riêng
     *
     * @key {String} postTime_posterID["roomName", "chatters"]/cmd cmdPlus:Content
     */
    var regexpPM = /^(<span style="color: (#[0-9A-Fa-f]{3,6}|rgb\(\d{2,3}, \d{2,3}, \d{2,3}\));?">(<(strike|i|u|strong)>)*)(\d{13,}_\d+)(\["(.*)"\,"([\d\|]*)"\])(\/(\w+)(\s([\w\d]+))?)?:?(.*)$/; // Mã kiểm tra định dạng tin nhắn riêng

    /**
     * Xử lý dữ liệu tin nhắn để chuyển đến dạng tab riêng mình cần
     *
     * @param {htmlString} Dữ liệu tin nhắn mới
     */
    var newMessage = function (Messages) {

        if (Messages) {

            var arr = $.parseHTML(Messages); // Chuyển htmlString tin nhắn thành HTML

            $.each(arr, function (index, val) { // Duyệt qua từng tin

                var $this = $(this); // Đặt biến cho tin nhắn đang xét

                var $poster = $(".user > a", $this); // Người gửi tin
                var poster_id = 0; // Lấy ra uid của người gửi tin

                var mess_date = $(".date-and-time", $this).text().slice(1, -1); // Lấy thông số thời gian gửi tin
                var mess_dateUTC = Z.date('utc', mess_date); // Thời gian gửi tin dạng UTC

                var starter_id = ""; // Uid người tạo phòng chat
                var room_id = ""; // Id phòng chat
                var room_name = "Kênh chung"; // Tên phòng chat

                var chatters = []; // Array danh sách người trong phòng
                var others = []; // Array danh sách người trong phòng không phải mình

                var cmd = "";
                var cmd_plus = "";

                var mess_source = $this[0].outerHTML; // htmlString của tin nhắn
                var mess_content = ""; // htmlString của phần nội dung tin nhắn

                var messText = $(".msg", $this).html(); // Lấy HTML phần nội dung tin nhắn

                if ($poster.length && $poster.text() !== "") {
                    poster_id = $poster[0].href.match(/\d+/)[0];
                }

                if (regexpPM.test(messText)) { // Nếu đúng định dạng tin riêng

                    /**
                     * Phân tích tin nhắn để lấy ra các thông tin cần thiết
                     * @type {Array}
                     *
                     * 1  begin
                     * 5  room_id
                     * 7  room_name
                     * 8  chatters
                     * 10 cmd
                     * 12 +cmd
                     * 13 end
                     */
                    var arrPMess = messText.match(regexpPM);
                    room_id = arrPMess[5];
                    starter_id = room_id.match(/\d+_(\d+)/)[1];
                    chatters = arrPMess[8].split("|");
                    others = $.grep(chatters, function (n, i) {
                        return (n !== starter_id);
                    });
                    room_name = arrPMess[7];
                    cmd = arrPMess[10];
                    cmd_plus = arrPMess[12];
                    mess_content = arrPMess[1] + arrPMess[13];

                } else { // Nếu không đúng định dạng mã tin riêng

                    /**
                     * Phân tích tin nhắn thường
                     * @type {Array}
                     *
                     * 1  begin
                     * 6  cmd
                     * 8  +cmd
                     * 9  end
                     */
                    var arrMess = messText.match(/^(<span style="color: (#[0-9A-Fa-f]{3,6}|rgb\(\d{2,3}, \d{2,3}, \d{2,3}\));?">(<(strike|i|u|strong)>)*)(\/(\w+)(\s([\w\d]+))?)?:?(.*)$/);
                    room_id = "publish";
                    cmd = arrMess[6];
                    cmd_plus = arrMess[8];
                    mess_content = arrMess[1] + arrMess[9];
                }

                if (Z.data.chatroom[room_id] === undefined) {
                    Z.data.chatroom[room_id] = {};
                }

                var room_dateUTC = Z.data.chatroom[room_id].room_dateUTC;
                if (room_dateUTC === undefined) {
                    room_dateUTC = mess_dateUTC;
                }

                var room_date = Z.data.chatroom[room_id].room_date;
                if (room_date === undefined) {
                    room_date = mess_date;
                }

                if (Z.data.dateUTC_begin === "") {
                    Z.data.dateUTC_begin = mess_dateUTC;
                }

                if (Z.data.date_begin === "") {
                    Z.data.date_begin = mess_date;
                }

                var newMessData = Z.data.chatroom[room_id].message;
                if (newMessData === undefined) {
                    newMessData = [];
                }

                var newMess = {
                    room_id: room_id, // Id phòng chat
                    mess_dateUTC: mess_dateUTC, // Thời điểm nhắn tin, định dạng UTC, chuyển từ thông tin trong chatbox
                    mess_date: mess_date, // Thời điểm nhắn tin, định dạng hh:mm:ss dd/mm/yy trong chatbox
                    poster_id: poster_id, // Id người nhắn tin đó
                    cmd: cmd, // Mã lệnh bắt đầu bằng / không có khoảng trắng
                    cmd_plus: cmd_plus, // Thông tin thêm cho lệnh cmd(nếu có)
                    mess_source: mess_source, // htmlString của toàn bộ tin nhắn
                    mess_content: mess_content // htmlString phần nội dung
                };
                newMessData.push(newMess);

                Z.data.chatroom[room_id] = { // Thời điểm tạo phòng và user_id người tạo
                    room_dateUTC: mess_dateUTC, // Thời điểm nhắn tin, định dạng UTC, chuyển từ thông tin trong chatbox
                    room_date: room_date, // Thời điểm nhắn tin, định dạng hh:mm:ss dd/mm/yy trong chatbox
                    starter_id: starter_id, // Id người tạo phòng
                    room_name: room_name, // Tên phòng
                    chatters: chatters, // Danh sách id người dùng
                    others: others, // Danh sách id người dùng không phải mình
                    mess_length: newMessData.length, // Tổng số tin trong phòng chat
                    message: newMessData // Dữ liệu tin nhắn trong phòng chat
                };

                Z.data.all_mess_length += 1;
                Z.data.new_mess = newMess;

                callback.messageEach.call(Z.data, newMess, index);

            });

            callback.messageAll.call(Z.data);

            var $arrMember = $($.parseHTML(chatbox_memberlist));

            $arrMember.find("a").each(function (index, val) {

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

                var user_id = dataMenu[1];
                var user_name = dataMenu[2].slice(1, -1);
                var my_user_id = dataMenu[3];
                var my_chat_level = dataMenu[4];
                var my_user_level = dataMenu[5];
                var user_chat_level = dataMenu[6];
                var user_level = dataMenu[7];

                var user_color = $("span", $this).css('color');
                var chat_status = $this.closest("ul").prev("h4").attr("class").split(" ")[1];
                var user_source = $this[0].outerHTML;

                if (user_id === my_user_id) { // Nếu user_id trùng với my_user_id
                    Z.data.me = user_id;
                }

                var newUser = {
                    user_id: user_id,
                    user_name: user_name,
                    user_color: user_color,
                    chat_status: chat_status,
                    user_level: user_level,
                    chat_level: user_chat_level,
                    user_source: user_source
                };

                Z.data.user[user_id] = newUser;

                callback.userEach.call(Z.data, newUser, index);

            });

            callback.userAll.call(Z.data);

        }

    };

    /**
     * Xử lý khi tải xong dữ liệu tin nhắn
     *
     * $param {htmlString} Dữ liệu tin nhắn
     */
    var getDone = function (chatsource) {

        if (chatsource.indexOf("<!DOCTYPE html PUBLIC") === 0) { // Lỗi do logout hoặc bị ban
            if (chatsource.indexOf("You have been banned from the ChatBox") !== -1) {
                callback.banned.call(Z.data);
            } else {
                callback.logout.call(Z.data);
            }
            return false;

        } else { // Đã login

            /**
             * Tải dữ liệu chatbox
             *
             * chatbox_messages    Tin nhắn chatbox
             * chatbox_memberlist  Thành viên đang truy cập
             * chatbox_last_update Thời điểm cập nhật cuối
             */
            eval(chatsource); // Chuyển đổi để các biến chạy được

            var newChatboxMessages, thisLastMess;
            if (chatbox_messages) { // Nếu có tin nhắn
                thisLastMess = chatbox_messages.match(/<p class="chatbox_row_(1|2) clearfix">(?:.(?!<p class="chatbox_row_(1|2) clearfix">))*<\/p>$/)[0]; // Lấy tin nhắn cuối trong lần này
                if (Z.lastMess === undefined) { // Nếu trước đó ko có tin cuối => lần truy cập chatbox đầu tiên hoặc chatbox mới clear

                    newChatboxMessages = chatbox_messages;
                    Z.lastMess = thisLastMess; // Cập nhật tin nhắn cuối
                    newMessage(newChatboxMessages); // Xử lý tin nhắn và đưa vào chatbox

                } else if (Z.lastMess !== thisLastMess) { // Không có tin mới

                    newChatboxMessages = chatbox_messages.split(Z.lastMess)[1]; // Cắt bỏ tin nhắn cũ, lấy tin mới
                    Z.lastMess = thisLastMess; // Cập nhật tin nhắn cuối
                    newMessage(newChatboxMessages); // Xử lý tin nhắn và đưa vào chatbox

                }
            } else { // Nếu không có tin nhắn (có thể là do clear chatbox)
                Z.lastMess = undefined; // Xóa giá trị tin nhắn cuối
            }

            Z.firstTime = false;

        }
    };

    /**
     * Tải dữ liệu và cập nhật nội dung chatbox
     *
     * @param {Boolearn} Nếu đặt true sẽ sử dụng chế độ refresh
     */
    Z.update = function (refresh) {

        callback.update.call(Z.data);
        var url = "/chatbox/chatbox_actions.forum?archives=1";
        var f5 = "";
        if (refresh) {
            f5 = "&mode=refresh";
        }
        callback.beforeLoad.call(Z.data);
        $.get(url + f5).done(function (data) {
            getDone(data);
            callback.afterLoad.call(Z.data);
        }).fail(function (data) {
            if (data.responseText.indexOf("document.getElementById('refresh_auto')") === 0) {
                // Xử lý khi bị disconnect
                callback.disconnect.call(Z.data);
            } else {
                // Xử lý cho các lỗi khác không phải do disconnect như mất kết nối internet (có thể xảy ra do refresh trang trong lúc đang tải)
                callback.notLoaded.call(Z.data);
            }
        });

    };

    /**
     * Cập nhật tự động và dừng tự cập nhật
     */
    Z.refresh = {

        start: function () {
            Z.update();
            refreshFunction = setInterval(function () {
                Z.update(true);
            }, 5000);
            callback.autoUpdate.call(Z.data);
        },

        stop: function () {
            clearInterval(refreshFunction);
            callback.stopUpdate.call(Z.data);
        }

    };

    /**
     * Gửi tin nhắn
     * @param  {String} val       Nội dung tin nhắn do người dùng nhập
     * @param  {Number} bold      0/1 Thuộc tính chữ đậm
     * @param  {Number} italic    0/1 Thuộc tính chữ nghiêng
     * @param  {Number} underline 0/1 Thuộc tính chữ gạch chân
     * @param  {Number} strike    0/1 Thuộc tính chữ gạch bỏ
     * @param  {Color}  color     Mã màu HEX(không có #) Thuộc tính màu chữ
     */
    Z.send = function (val, bold, italic, underline, strike, color) {

        Z.lastTyped = val;
        callback.beforeSend.call(Z.data);
        $.post("/chatbox/chatbox_actions.forum?archives=1", {
            mode: "send",
            sent: val,
            sbold: bold,
            sitalic: italic,
            sunderline: underline,
            sstrike: strike,
            scolor: color
        }).done(function () {
            // Cập nhật tin nhắn
            Z.update(true);
            callback.doneSend.call(Z.data);
        }).fail(function () {
            callback.failSend.call(Z.data);
            // Xử lý cho lỗi mất kết nối internet (có thể xảy ra do refresh trang trong lúc đang tải)
        }).always(function () {
            callback.afterSend.call(Z.data);
        });

    }
})(jQuery);
