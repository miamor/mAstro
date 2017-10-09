/**
 * Các function mặc định và các biến chung
 * 
 * action_user
 * copy_user_name
 * my_getcookie
 * my_setcookie
 */

var firstTime = true; // Lần truy cập đầu tiên

var $wrap = $("#chatbox-wrap"); // Khối bao quanh tin nhắn
var $messenger = $("#chatbox-messenger-input"); // input nhập liệu
var $form = $("#chatbox-form"); // form gửi tin
var $wform = $("#chatbox-messenger-form");
var uId, uName; // user id, user name của thành viên đang truy cập chatbox(mình)
var autoRefresh; // Cập nhật tin nhắn mỗi 5 giây
var $title = $("title"); // Tiêu đề của trang

var regexpPM = /^(<span style="color: (#[0-9A-Fa-f]{6}|rgb\(\d{2,3}, \d{2,3}, \d{2,3}\));?">(<(strike|i|u|strong)>)*)(\d{13,}_\d+)({.*})(\["[^"]+"(\,"[^"]+")+\])(.*)$/; // Mã kiểm tra định dạng tin nhắn riêng
var lastMess; // Lấy html của tin cuối cùng

/**
 * Lấy Link của người dùng trong danh sách bằng nickname
 * 
 * @param {String} nickname của người cần lấy
 */
var userOnline = function (n) {
	return $("#chatbox-members").find('a[onclick="return copy_user_name(\'' + n + '\');"]');
};

var chatbox_old_update = 0;

// Copy nickname vào khung soạn thảo
function copy_user_name(user_name) {
	$messenger[0].value += user_name;
	$messenger.focus();
	return false;
}

// Lấy cookie
function my_getcookie(name) {
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
}

// Đặt cookie
function my_setcookie(name, value, sticky, path) {
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