<?php
include "TopSdk.php";
date_default_timezone_set ( 'Asia/Shanghai' );

//$httpdns = new HttpdnsGetRequest ();
// $client = new ClusterTopClient("appkey","appsecret");
$client = new TopClient ( "appkey", "appsecret" );
// 正式环境

$client->appkey = "23230527";
 $client->secretKey = "e609fe51d984063065f9132cc0f6df54";
 $client->gatewayUrl = "http://gw.api.taobao.com/router/rest";

// 沙箱环境
/* $client->appkey = "1023230527";
$client->secretKey = "sandbox1d984063065f9132cc0f6df54";
$client->gatewayUrl = "http://gw.api.tbsandbox.com/router/rest"; */

// $client->gatewayUrl = "https://eco.taobao.com/router/rest";
// 正式环境

//$req = new TbkItemGetRequest;
//  $req = new TbkItemsGetRequest;
// $req->setFields("num_iid");
// $req->setKeyword("海南黄花梨");
$req = new TbkItemsDetailGetRequest;
$req->setNumIids("35518250070");
$req->setFields("num_iid,seller_id,nick,title,price,volume,pic_url,item_url,shop_url");
$resp =$client->execute($req);



// var_dump($client->execute($httpdns));
print_r ( $resp );

?>