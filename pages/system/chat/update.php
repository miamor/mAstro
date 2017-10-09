<? header('Content-type: text/plain; charset: utf8');

$chat->content = $content = ($_POST['sent']) ? $_POST['sent'] : null;
//echo $content.'~~~~~~';
if ($content && $content !== '{HIDDEN_TEXT}') $chat->send();

$chat->readAll();
$cAr = $chat->cList;

$chat->getMemberlist();
$mAr = $chat->mList; ?>
var chatbox_messages = '<? foreach ($cAr as $cO) { extract($cO); ?><p class=\"chatbox_row_1 clearfix\"><span class=\"user-msg <? if ($uid == $config->u) echo 'me' ?>\"><span class=\"user\"><a href=\"/<? echo $author['link'] ?>\" onclick=\"return copy_user_name(\'<? echo $author['username'] ?>\');\" target=\"_blank\"><span class=\"user-txt hidden\"><? echo $author['name'] ?></span><img class=\"user-avt\" src=\"<? echo $author['avatar'] ?>\"/></a> </span><span class=\"msg\"><span style=\"color: #eeeeee\"><? echo $content ?></span></span> <span class=\"date-and-time <? if ($uid == $config->u) echo 'me' ?>\" title=\"<? echo $createDate ?>\">[<? echo $created ?>]</span> </span></p><? } ?>';
var chatbox_memberlist = '<h4 class=\"member-title online\">Online</h4><ul class=\"online-users\"><? foreach ($mAr[1] as $mO) { extract($mO); ?><li><a href=\"/u/<? echo $username ?>\" onclick=\"return false\"><? echo $name ?></a> <a class=\"return gensmall\" oncontextmenu=\"return showMenu(<? echo $id ?>,\'<? echo $username ?>\',<? echo $config->u ?>,<? echo $config->me['modlv_chat'] ?>,<? echo $config->me['modlv'] ?>,<? echo $modlv_chat ?>,<? echo $modlv ?>,event,\'\');\" onclick=\"return copy_user_name(\'<? echo $username ?>\');\" target=\"_blank\">@<? echo $username ?></a></li><? } ?></ul>\
\
<h4 class=\"member-title disconnect\">Away</h4><ul class=\"away-users\"><? foreach ($mAr[2] as $mO) { extract($mO); ?><li><a href=\"/u/<? echo $username ?>\" onclick=\"return false\"><? echo $name ?></a> <a class=\"return gensmall\" oncontextmenu=\"return showMenu(<? echo $id ?>,\'<? echo $username ?>\',<? echo $config->u ?>,<? echo $config->me['modlv_chat'] ?>,<? echo $config->me['modlv'] ?>,<? echo $modlv_chat ?>,<? echo $modlv ?>,event,\'\');\" onclick=\"return copy_user_name(\'<? echo $username ?>\');\" target=\"_blank\">@<? echo $username ?></a></li><? } ?></ul>\
\
<h4 class=\"member-title disconnect\">Disconnect</h4><ul class=\"away-users\"><? foreach ($mAr[0] as $mO) { extract($mO); ?><li><a href=\"/u/<? echo $username ?>\" onclick=\"return false\"><? echo $name ?></a> <a class=\"return gensmall\" oncontextmenu=\"return showMenu(<? echo $id ?>,\'<? echo $username ?>\',<? echo $config->u ?>,<? echo $config->me['modlv_chat'] ?>,<? echo $config->me['modlv'] ?>,<? echo $modlv_chat ?>,<? echo $modlv ?>,event,\'\');\" onclick=\"return copy_user_name(\'<? echo $username ?>\');\" target=\"_blank\">@<? echo $username ?></a></li><? } ?></ul>';
