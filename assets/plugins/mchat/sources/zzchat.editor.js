/**
 * Các công cụ soạn thảo tin nhắn
 *
 * Chữ in đậm, in nghiêng, gạch dưới, gạch bỏ
 * Chọn màu
 * Kiểm duyệt BBcode
 */
var chooseColor = function(colo) { // Đổi màu chữ
    $("#chatbox-option-color").css("background", colo);
    $("#chatbox-input-color").val(colo.slice(1));
    $("#chatbox-messenger").css("color", colo);
};
$("#chatbox-option-color").click(function() {
    var randomColor = (function(m, s, c) {
        return (c ? arguments.callee(m, s, c - 1) : '#') + s[m.floor(m.random() * s.length)]
    })(Math, '0123456789ABCDEF', 5);
    chooseColor(randomColor);
    my_setcookie("optionColor", randomColor, false);
});
var cookieColor = my_getcookie("optionColor");
if (cookieColor) {
    chooseColor(cookieColor);
}

$("#chatbox-option-bold, #chatbox-option-italic, #chatbox-option-underline, #chatbox-option-strike").click(function() {
    var $this = $(this);

    $this.toggleClass(function() {
        var val = "1";
        if ($this.hasClass("active")) {
            val = "0";
        }
        $("#" + this.id.replace("option", "input")).val(val);
        return "active";
    });
    var arrCookie = [],
        style = "";
    $("#chatbox-form > input:not(#chatbox-input-color)").each(function(i, val) {
        var thisVal = this.value;
        arrCookie.push(thisVal);
        if (thisVal !== "0") {
            switch (i) {
                case 0:
                    style += "font-weight: bold;";
                    break;
                case 1:
                    style += "font-style: italic;";
                    break;
                case 2:
                    style += "text-decoration: underline;";
                    break;
                case 3:
                    style += "text-decoration: line-through;";
                    break;
            }
        }
    });
    $messenger.attr("style", style);
    my_setcookie("optionCookie", arrCookie.join("|"), true);
});

var getArrCookie = my_getcookie("optionCookie");
if (getArrCookie) {
    $.each(getArrCookie.split("|"), function(i, val) {
        if (val === "1") {
            $("#chatbox-option > div").eq(i).click();
        }
    });
}

$messenger.on("input", function() {
    var val = this.value;
    this.value = val.replace(/\[\/(b|i|u|strike|left|center|right|justify|size|color|font|list|quote|code|spoiler|hide|table|tr|td|flash|youtube|dailymotion|sub|sup|scroll|updown|flipv|fliph|fade|blur|wow|rand)\]|\[(\*|hr)\]/gi, "***");
});
