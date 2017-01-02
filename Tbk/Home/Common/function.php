<?php
// 淘宝SDK初始化
function _tbsdk() {
	Vendor ( 'taobao.TopSdk' );
	Vendor ( 'taobao.top.TopClient' );
	date_default_timezone_set ( 'Asia/Shanghai' );
	// $httpdns=newHttpdnsGetRequest();
	// $client=newClusterTopClient("appkey","appsecret");
	$client = new \TopClient ( "appkey", "appsecret" );
	// 正式环境
	$client->appkey = "23230527";
	$client->secretKey = "e609fe51d984063065f9132cc0f6df54";
	$client->gatewayUrl = "http://gw.api.taobao.com/router/rest";
	// 沙箱环境
	/*
	 * $client->appkey="1023230527";
	 * $client->secretKey="sandbox1d984063065f9132cc0f6df54";
	 * $client->gatewayUrl="http://gw.api.tbsandbox.com/router/rest";
	 */
	// $client->gatewayUrl="https://eco.taobao.com/router/rest";
	return $client;
}
// 淘宝客商品详情查询（简版）
// fieldsString必须需返回的字段列表num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url
// platformNumber可选1链接形式：1：PC，2：无线，默认：１
// num_iidsString必须商品ID串，用,分割，从taobao.tbk.item.get接口获取num_iid字段，最大40个
function TbkItemInfoGet() {
	$this->_tbsdk ();
	$keyword = $this->_keyword ();
	print_r ( $keyword );
	$req = new \TbkItemsDetailGetRequest ();
	$req->setNumIids ( "35518250070" );
	$req->setFields ( "num_iid,seller_id,nick,title,price,volume,pic_url,item_url,shop_url" );
	$resp = $client->execute ( $req );
}
function _curl() {
	$curl = curl_init ();
	curl_setopt ( $curl, CURLOPT_URL, "http://www.fuck.com/login" );
	curl_setopt ( $curl, CURLOPT_HEADER, 1 );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $curl, CURLOPT_POST, 1 );
	curl_setopt ( $curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5 ); // 使用了SOCKS5代理
	curl_setopt ( $curl, CURLOPT_PROXY, "fuck.3322.org:1080" );
	$data = array (
			'user' => "geek",
			'password' => 'fuck' 
	);
	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
	// curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1);如果是HTTP代理
	// curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie.txt');cookie你懂的
	$request = curl_exec ( $curl );
	// var_dump($request);
	curl_close ( $curl );
}
//百度微信接口
function _wxno() {
	$ch = curl_init ();
	$keyword = urlencode ( 黄花梨 );
	//echo ($keyword);
	$url = 'http://apis.baidu.com/antelope/wechat/wxno?keyword=' . $keyword . '&pageNo=1';
	$header = array (
			'apikey: 1605b528a82e51e6fc8052ee5dd78d85'
	);
	// 添加apikey到header
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	// 执行HTTP请求
	curl_setopt ( $ch, CURLOPT_URL, $url );
	$res = curl_exec ( $ch );
	$res=json_decode($res);
	//print_r($res);
	return  ($res);
}
//PHP stdClass Object转array
function object_array($array) {
	if(is_object($array)) {
		$array = (array)$array;
	} if(is_array($array)) {
		foreach($array as $key=>$value) {
			$array[$key] = object_array($value);
		}
	}
	return $array;
}
function _test($url) {
	echo ("11===========");
}