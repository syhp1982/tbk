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
/*转编码*/
function escape($str) {
	preg_match_all("/[-].|[\x01-]+/",$str,$r);
	$ar = $r[0];
	foreach($ar as $k=>$v) {
		if(ord($v[0]) < 128)
			$ar[$k] = rawurlencode($v);
			else
				$ar[$k] = "%u".bin2hex(iconv("GB2312","UCS-2",$v));
	}
	return join("",$ar);
}

function _curl($url) {
	$curl = curl_init ();
	header('Content-type: text/html;charset=utf-8');
	curl_setopt ( $curl, CURLOPT_URL, "www.qq.com");
	curl_setopt($curl,CURLOPT_HEADER,true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
	$data = curl_exec ( $curl );
	 preg_match_all("/<title>(.*)<\/title>/s",$data,$d,PREG_PATTERN_ORDER);
	 $str = mb_convert_encoding($d, "UTF-8", "UTF-8,GBK,GB2312,BIG5'");
	var_dump ($d);
	curl_close ( $curl );
	
}
//php脚本开始
/*POST请求远程内容函数*/
function ppost($url,$data,$ref){ // 模拟提交数据函数
	$curl = curl_init(); // 启动一个CURL会话
	curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
	curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
	curl_setopt($curl, CURLOPT_REFERER, $ref);
	curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
	curl_setopt($curl, CURLOPT_COOKIEFILE,$GLOBALS ['cookie_file']); // 读取上面所储存的Cookie信息
	curl_setopt($curl, CURLOPT_COOKIEJAR, $GLOBALS['cookie_file']); // 存放Cookie信息的文件名称

	curl_setopt($curl, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));
	curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');//这个是解释gzip内容.................
	curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
	curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
	$tmpInfo = curl_exec($curl); // 执行操作
	if (curl_errno($curl)) {
		echo 'Errno'.curl_error($curl);
	}
	curl_close($curl); // 关键CURL会话
	return $tmpInfo; // 返回数据
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
/**
 * 替代scan_dir的方法
 * @param string $pattern 检索模式 搜索模式 *.txt,*.doc; (同glog方法)
 * @param int $flags
 */
function sp_scan_dir($pattern,$flags=null){
	$files = array_map('basename',glob($pattern, $flags));
	return $files;
}
/**
 * 判断是否为SAE
 */
function sp_is_sae(){
	if(defined('APP_MODE') && APP_MODE=='sae'){
		return true;
	}else{
		return false;
	}
}

/**
 * 清空系统缓存，兼容sae
 */
function clear_cache(){
	import ( "ORG.Util.Dir" );
	$dirs = array ();
	// runtime/
	$rootdirs = sp_scan_dir( RUNTIME_PATH."*" );
	//$noneed_clear=array(".","..","Data");
	$noneed_clear=array(".","..");
	$rootdirs=array_diff($rootdirs, $noneed_clear);
	foreach ( $rootdirs as $dir ) {
			
		if ($dir != "." && $dir != "..") {
			$dir = RUNTIME_PATH . $dir;
			if (is_dir ( $dir )) {
				//array_push ( $dirs, $dir );
				$tmprootdirs = sp_scan_dir ( $dir."/*" );
				foreach ( $tmprootdirs as $tdir ) {
					if ($tdir != "." && $tdir != "..") {
						$tdir = $dir . '/' . $tdir;
						if (is_dir ( $tdir )) {
							array_push ( $dirs, $tdir );
						}else{
							@unlink($tdir);
						}
					}
				}
			}else{
				@unlink($dir);
			}
		}
	}
	$dirtool=new \Dir("");
	foreach ( $dirs as $dir ) {
		$dirtool->delDir ( $dir );
	}

	if(sp_is_sae()){
		$global_mc=@memcache_init();
		if($global_mc){
			$global_mc->flush();
		}
			
		$no_need_delete=array("THINKCMF_DYNAMIC_CONFIG");
		$kv = new SaeKV();
		// 初始化KVClient对象
		$ret = $kv->init();
		// 循环获取所有key-values
		$ret = $kv->pkrget('', 100);
		while (true) {
			foreach($ret as $key =>$value){
				if(!in_array($key, $no_need_delete)){
					$kv->delete($key);
				}
			}
			end($ret);
			$start_key = key($ret);
			$i = count($ret);
			if ($i < 100) break;
			$ret = $kv->pkrget('', 100, $start_key);
		}
			
	}

}

 function myRelust($result){
	if($result == false){
		$this->error("操作失败！");
	}else{
		$this->success("操作成功！");
	}
}

function _test($url) {
	echo ("11===========");
}