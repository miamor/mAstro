<?
include_once 'include/config.php';
header('Content-type: application/json; charset=utf-8');

$accessToken = $_SESSION['fb_access_token'];
$config->u = $u = $_SESSION['uid'];
$config->token = $accessToken;

//$accessToken = 'EAACEdEose0cBADyVeVmpoizPqmJ97dXtPcCwycFJAkLLnStXOuoSEofojmoqOwUS6edZBfwyP8c4ZCy8bWAvAYYrWTZAXioQeBztM0Q7KYUbdQxoIKRZC5j12TK338HQlwTz3TVvmEIYNkgnUpkR79F6hbnFyDCGZB3hyN3klpwZDZD';

// token created using tools
//EAACEdEose0cBADyVeVmpoizPqmJ97dXtPcCwycFJAkLLnStXOuoSEofojmoqOwUS6edZBfwyP8c4ZCy8bWAvAYYrWTZAXioQeBztM0Q7KYUbdQxoIKRZC5j12TK338HQlwTz3TVvmEIYNkgnUpkR79F6hbnFyDCGZB3hyN3klpwZDZD

//echo "Access token: ".$accessToken."<br/>";

// get page info
// page-id: 140015579664087
//$pageInfo = file_get_contents('https://graph.facebook.com/140015579664087?access_token='.$accessToken);

// get comments 
//$cmt = file_get_contents('https://graph.facebook.com/100005135560209_677025992478580/comments?access_token='.$accessToken);
$cmt = '{
  "data": [
    {
      "created_time": "2016-12-30T02:30:20+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "hello~",
      "id": "677025992478580_688282711352908"
    },
    {
      "created_time": "2016-12-30T02:32:08+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "ng minh tú - 29/7/1997 - 1h10 - hà nội",
      "id": "677025992478580_688283248019521"
    },
    {
      "created_time": "2016-12-30T02:35:53+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "per 1 - 12/03/1994 - 15:20 - nghệ an",
      "id": "677025992478580_688284224686090"
    },
    {
      "created_time": "2016-12-30T02:36:12+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "per2 - 12/03/1994 - 15:20 - nghệ an",
      "id": "677025992478580_688284291352750"
    },
    {
      "created_time": "2016-12-30T02:36:37+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "per 6 ngày sinh 12/03/1994 h sinh 15:20 nơi sinh hà tĩnh",
      "id": "677025992478580_688284458019400"
    },
    {
      "created_time": "2016-12-30T02:37:08+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "per 7 sinh ngày 4/5/1995 lúc 20h10\' ở nam đàn",
      "id": "677025992478580_688284641352715"
    },
    {
      "created_time": "2016-12-30T02:38:51+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "[the sd]
3/12/1998
3:05
ở phú thọ",
      "id": "677025992478580_688285194685993"
    },
    {
      "created_time": "2016-12-30T02:39:52+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "cmt linh tinh~",
      "id": "677025992478580_688285434685969"
    },
    {
      "created_time": "2016-12-30T02:40:07+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "chấm",
      "id": "677025992478580_688285524685960"
    },
    {
      "created_time": "2016-12-30T02:40:17+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "hơn 10 chưa?",
      "id": "677025992478580_688285544685958"
    },
    {
      "created_time": "2016-12-30T02:40:23+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "rồi đấy",
      "id": "677025992478580_688285581352621"
    },
    {
      "created_time": "2016-12-30T02:40:29+0000",
      "from": {
        "name": "Nguyễn Tú",
        "id": "372168142964368"
      },
      "message": "xem có trang chưa",
      "id": "677025992478580_688285608019285"
    }
  ],
  "paging": {
    "cursors": {
      "before": "WTI5dGJXVnVkRjlqZAFhKemIzSTZAOamc0TWpneU56RXhNelV5T1RBNE9qRTBPRE13TmpVd01qQT0ZD",
      "after": "WTI5dGJXVnVkRjlqZAFhKemIzSTZAOamc0TWpnMU5qQTRNREU1TWpnMU9qRTBPRE13TmpVMk1qaz0ZD"
    }
  }
}';
echo $cmt.'~~~~~';
