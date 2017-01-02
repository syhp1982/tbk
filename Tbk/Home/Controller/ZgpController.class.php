<?php

namespace Home\Controller;

use Think\Controller;

class ZgpController extends Controller {
	protected $menu_obj;
	protected $user_obj;
	protected $posts_obj;
	protected $keyword_obj;
	protected $tbkitem_obj;
	protected $options_obj;
	function _initialize() {
		$this->menu_obj = new \Home\Model\MenuModel ();
		$this->user_obj = new \Home\Model\UserModel ();
		$this->posts_obj = new \Home\Model\PostsModel ();
		$this->keyword_obj = new \Home\Model\KeywordModel ();
		$this->tbkitem_obj = new \Home\Model\TbkitemModel ();
		$this->options_obj = new \Home\Model\OptionsModel ();
		$this->wx_obj = new \Home\Model\WxModel ();
	}
	// 登录页面
	function login() {
		$user = session ( 'user' );
		if ($this->check_access ( $user ['role_id'] )) {
			$this->redirect ( 'Home/zgp/index' );
		}
		$this->display ();
	}
	// 登录验证
	function dologin() {
		$name = $_POST ['username'];
		$pass = $_POST ['password'];
		$verify = $_POST ['verify'];
		$user = $this->user_obj->where ( "user_login='$name'" )->find ();
		if ($user != null) {
			if ($user ['user_pass'] == md5 ( $pass )) {
				session ( "user", $user );
				$user ['last_login_ip'] = get_client_ip ();
				$user ['last_login_time'] = date ( "Y-m-dH:i:s" );
				$this->user_obj->save ( $user );
				$this->redirect ( 'Zgp/index' );
				$this->success ( "登录验证成功！", U ( "Zgp/index" ) );
			}
		} else {
			print_r ( $user ['user_pass'] . '===' . md5 ( $pass ) );
			$this->error ( "密码错误！" );
		}
	}
	// 验证码
	function verify() {
		$Verify = new \Think\Verify ();
		$Verify->fontSize = 18;
		$Verify->length = 4;
		$Verify->useNoise = false;
		$Verify->codeSet = '0123456789';
		$Verify->imageW = 130;
		$Verify->imageH = 50;
		$Verify->entry ();
	}
	private function check_access($roleid) {
		/* 如果用户角色是1，则无需判断 */
		if ($roleid == 1) {
			return true;
		}
	}
	/**
	 * 自动判断把gbk或gb2312编码的字符串转为utf8
	 * 能自动判断输入字符串的编码类，如果本身是utf-8就不用转换，否则就转换为utf-8的字符串
	 * 支持的字符编码类型是：utf-8,gbk,gb2312
	 * @$str:string字符串
	 */
	function _gbk2utf8($str) {
		$charset = mb_detect_encoding ( $str, array (
				'UTF-8',
				'GBK',
				'GB2312' 
		) );
		$charset = strtolower ( $charset );
		if ('cp936' == $charset) {
			$charset = 'GBK';
		}
		if ("utf-8" != $charset) {
			$str = iconv ( $charset, "UTF-8//IGNORE", $str );
		}
		return $str;
	}
	function _menu_list() {
		$cwhere = "status=1 and cid=2";
		$menu = $this->menu_obj->where ( $cwhere )->select ();
		$this->assign ( "menu", $menu );
	}
	function index() {
		$this->dologin ();
		$this->_menu_list ();
		$this->display ();
	}
	function option_keywords() {
		$keyword = '海南黄花梨,黄花梨手串,海南黄花梨手串,海南黄花梨手串20mm,顶级海南黄花梨手串,黄花梨家具,小叶紫檀手链,小叶紫檀手串,海南黄花梨佛珠';
		$key = explode ( ',', $keyword );
		$save ['option_id'] = 2;
		$save ['option_name'] = 'keywords';
		$save ['option_value'] = $keyword;
		$save ['autoload'] = 'yes';
		$this->options_obj->save ( $save );
	}
	function post_list() {
		$cwhere = "post_status='publish' and post_type='post'";
		$posts = $this->posts_obj->where ( $cwhere )->select ();
		$this->assign ( "posts", $posts );
		$this->display ();
	}
	function _post_save($save, $k) {
		$this->tbkitem_obj->create ( $save );
		$cwhere = "ID=" . $save ['ID'];
		$this->posts_obj->where ( $cwhere )->create ( $save );
		$result = $this->posts_obj->where ( $cwhere )->count ();
		if ($result != 0) {
			$save ['post_modified'] = date ( "Y-m-d G:H:s", strtotime ( rand ( 1, 10 ) . "hours" ) );
			print_r ( $save ['post_modified'] );
			echo ('<br>');
			$this->posts_obj->save ( $save );
		} else {
			$save ['post_date'] = date ( "Y-m-d G:H:s", strtotime ( rand ( 1, 100 ) . "hours" ) );
			print_r ( $save ['post_modified'] );
			echo ('<br>');
			$this->posts_obj->add ( $save );
		}
	}
	function _keyword() {
		$keyword = $this->keyword_obj->order ( 'rand()' )->limit ( 1 )->select ();
		return $keyword;
	}
	/**
	 * qString特殊可选查询词
	 * catString特殊可选后台类目ID，用,分割，最大10个，该ID可以通过taobao.itemcats.get接口获取到
	 * itemlocString可选所在地
	 * sortString可选排序_des（降序），排序_asc（升序），销量（total_sales），淘客佣金比率（tk_rate），累计推广量（tk_total_sales），总支出佣金（tk_total_commi）
	 * is_tmallBoolean可选是否商城商品，设置为true表示该商品是属于淘宝商城商品，设置为false或不设置表示不判断这个属性
	 * is_overseasBoolean可选是否海外商品，设置为true表示该商品是属于海外商品，设置为false或不设置表示不判断这个属性
	 * start_priceNumber可选折扣价范围下限，单位：元
	 * end_priceNumber可选折扣价范围上限，单位：元
	 * start_tk_rateNumber可选淘客佣金比率上限，如：1234表示12.34%
	 * end_tk_rateNumber可选淘客佣金比率上限，如：1234表示12.34%
	 * platformNumber可选链接形式：1：PC，2：无线，默认：１
	 * page_noNumber可选0第几页，默认：１
	 * page_sizeNumber可选0页大小，默认20，1~100*
	 */
	function save_keyword() {
		$a = 0;
		$b = 0;
		$keyword = '淘宝黄花梨手串,小叶紫檀,乌木,血龙木,鸡翅木家具,黄花梨家具,红木家具,沉香木雕葫芦,黄花梨108颗,佛珠手链檀香,越南黄花梨,黄花梨手串108颗,黄花梨佛珠,黄花梨珠子,黄花梨手镯,星月菩提正月,越南黄花梨笔筒,越南黄花梨珠,黄花梨手串正宗,黄花梨手串,黄花梨,黄花梨手串18mm,黄花梨油梨手串';
		$key = explode ( ',', $keyword );
		// print_r($key);
		foreach ( $key as $k => $v ) {
			$save ['keyword'] = $key [$k];
			$save ['Itemloc'] = '';
			$save ['sort'] = 'tk_total_commi';
			$save ['IsTmall'] = 'true';
			$save ['IsOverseas'] = 'false';
			$save ['StartPrice'] = rand ( 100, 200 );
			$save ['EndPrice'] = '';
			$save ['platform'] = '1';
			$save ['PageNo'] = rand ( 1, 9 );
			$save ['PageSize'] = '100';
			$this->keyword_obj->create ( $save );
			$cwhere = "keyword='" . $save ['keyword'] . "'";
			$result = $this->keyword_obj->where ( $cwhere )->find ();
			if (! empty ( $result )) {
				$save ['id'] = $result ['id'];
				print_r ( $save );
				echo ("<br>===========");
				$this->keyword_obj->save ( $save );
				$a = ++ $a;
			} else {
				$this->keyword_obj->add ( $save );
				$b = ++ $b;
			}
		}
		echo ('更新关键词' . $a . '条，新增关键词' . $b . '条<br>');
	}
	function g_menu() {
		$menu = '';
		$key = explode ( ',', $menu );
	}
	function _numiid() {
		$numiid = $this->tbkitem_obj->order ( 'rand()' )->limit ( 20 )->select ();
		return $numiid;
	}
	function s_sitemap() {
		$Model = M ();
		$cwhere = 'post_date<now()';
		$list = $Model->field ( 'id,post_title, post_date' )->table ( '1668s_posts' )->order ( 'id desc' )->where ( $cwhere )->limit ( 10000 )->select ();
		$sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n";
		foreach ( $list as $k => $v ) {
			$sitemap .= "<url>\r\n" . "<loc>http://www.1668s.com" . U ( 'Title/index', array (
					'ID' => $v ['id'] 
			) ) . "</loc>\r\n" . "<priority>0.6</priority>\r\n<lastmod>" . mb_substr ( $v ['post_date'], 0, 10, "utf-8" ) . "</lastmod>\r\n<changefreq>always</changefreq>\r\n</url>\r\n";
		}
		$sitemap .= '</urlset>';
		echo ('更新sitemap<br>');
		// print_r($sitemap);
		file_put_contents ( __ROOT__ . '/sitemap.xml', $sitemap );
		echo ('更新sitemap_baidu<br>');
		file_put_contents ( __ROOT__ . '/sitemap_baidu.xml', $sitemap );
		
		// sae sitemap
		// $stor = new \SaeStorage();
		// file_put_contents('saestor://public/sitemap.xml',$sitemap);
		// file_put_contents('saestor://public/sitemap_baidu.xml',$sitemap);
	}
	// 百度推送数据方法
	function baidu_curl() {
		$f = new SaeFetchurl ();
		$urls = $f->fetch ( "http://cailman-wordpress.stor.sinaapp.com/sitemap_baidu.xml" );
		$api = 'http://data.zz.baidu.com/urls?site=www.1668s.com&token=U4LIEtCSF50nknpy&type=original';
		$ch = curl_init ();
		$options = array (
				CURLOPT_URL => $api,
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS => implode ( "\n", $urls ),
				CURLOPT_HTTPHEADER => array (
						'Content-Type: text/plain' 
				) 
		);
		curl_setopt_array ( $ch, $options );
		$result = curl_exec ( $ch );
		echo $result;
	}
	function _tbkitem($data) {
		$save = array ();
		echo ("<br>插入数据开始======<br>");
		foreach ( $data as $k => $v ) {
			if ($v ['num_iid'] != null) {
				$save ['num_iid'] = $this->_gbk2utf8 ( $v ['num_iid'] );
			}
			if ($v ['item_url'] != null) {
				$save ['item_url'] = $v ['item_url'];
			}
			if ($v ['title'] != null) {
				$save ['title'] = $v ['title'];
			}
			if ($v ['reserve_price'] != null) {
				$save ['reserve_price'] = $v ['reserve_price'];
			}
			if ($v ['provcity'] != null) {
				$save ['provcity'] = $v ['provcity'];
			}
			if ($v ['pict_url'] != null) {
				$save ['pict_url'] = $v ['pict_url'];
			}
			if ($v ['small_images'] != null) {
				$save ['small_images'] = $v ['small_images'] ['string'];
			}
			if ($v ['user_type'] != null) {
				$save ['user_type'] = $v ['user_type'];
			}
			if ($v ['zk_final_price'] != null) {
				$save ['zk_final_price'] = $v ['zk_final_price'];
			}
			if ($v ['click_url'] != null) {
				$save ['click_url'] = $v ['click_url'];
			}
			$this->savetbkitem ( $save );
		}
		echo ("<br>插入数据结束======<br>");
	}
	function _tbkitemdetail($data) {
		if ($data ['num_iid'] != null) {
			$save ['num_iid'] = $this->_gbk2utf8 ( $data ['num_iid'] );
		}
		if ($data ['item_url'] != null) {
			$save ['item_url'] = $data ['item_url'];
		}
		if ($data ['title'] != null) {
			$save ['title'] = $data ['title'];
		}
		if ($data ['discount_price'] != null) {
			$save ['discount_price'] = $data ['discount_price'];
		}
		if ($data ['nick'] != null) {
			$save ['nick'] = $data ['nick'];
		}
		if ($data ['pict_url'] != null) {
			$save ['pict_url'] = $data ['pict_url'];
		}
		if ($data ['seller_id'] != null) {
			$save ['seller_id'] = $data ['seller_id'];
		}
		if ($data ['shop_url'] != null) {
			$save ['shop_url'] = $data ['shop_url'];
		}
		if ($data ['volume'] != null) {
			$save ['volume'] = $data ['volume'];
		}
		if ($data ['click_url'] != null) {
			$save ['click_url'] = $data ['click_url'];
		}
		$this->savetbkitem ( $save );
	}
	function savetbkitem($save) {
		if ($save) {
			$this->tbkitem_obj->create ( $save );
			$cwhere = "num_iid=" . $save ['num_iid'];
			$result = $this->tbkitem_obj->where ( $cwhere )->count ();
			if ($result != 0) {
				echo ('更新开始=<br>');
				print_r ( $save ['num_iid'] );
				print_r ( $save ['title'] );
				$this->tbkitem_obj->save ( $save );
				echo ('更新结束=<br>');
			} else {
				echo ('插入开始=<br>');
				print_r ( $save ['num_iid'] );
				print_r ( $save ['title'] );
				$this->tbkitem_obj->add ( $save );
				echo ('插入结束=<br>');
			}
		}
	}
	/**
	 * 淘宝客商品查询
	 * fieldsString必须需返回的字段列表
	 * qString特殊可选查询词
	 * catString特殊可选后台类目ID，用,分割，最大10个，该ID可以通过taobao.itemcats.get接口获取到
	 * itemlocString可选所在地
	 * sortString可选排序_des（降序），排序_asc（升序），销量（total_sales），淘客佣金比率（tk_rate），累计推广量（tk_total_sales），总支出佣金（tk_total_commi）
	 * is_tmallBoolean可选是否商城商品，设置为true表示该商品是属于淘宝商城商品，设置为false或不设置表示不判断这个属性
	 * is_overseasBoolean可选是否海外商品，设置为true表示该商品是属于海外商品，设置为false或不设置表示不判断这个属性
	 * start_priceNumber可选折扣价范围下限，单位：元
	 * end_priceNumber可选折扣价范围上限，单位：元
	 * start_tk_rateNumber可选淘客佣金比率上限，如：1234表示12.34%
	 * end_tk_rateNumber可选淘客佣金比率上限，如：1234表示12.34%
	 * platformNumber可选链接形式：1：PC，2：无线，默认：１
	 * page_noNumber可选0第几页，默认：１
	 * page_sizeNumber可选0页大小，默认20，1~100*
	 */
	public function TbkItemGet($keyword) {
		$client = _tbsdk ();
		$req = new \TbkItemGetRequest ();
		$req->setFields ( "num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url" );
		if ($keyword ['keyword'] != null) {
			$req->setQ ( $keyword ['keyword'] );
		}
		// $req->setCat("16,18");
		if ($keyword ['Itemloc'] != null) {
			$req->setItemloc ( $keyword ['Itemloc'] );
		}
		if ($keyword ['sort'] != null) {
			$req->setSort ( $keyword ['sort'] );
		}
		if ($keyword ['pict_url'] != null) {
			$req->setSort ( $keyword ['pict_url'] );
		}
		if ($keyword ['small_images'] != null) {
			$req->setSort ( $keyword ['small_images'] );
		}
		if ($keyword ['istmall'] != null) {
			$req->setIsTmall ( $keyword ['istmall'] );
		}
		if ($keyword ['isoverseas'] != null) {
			$req->setIsOverseas ( $keyword ['isoverseas'] );
		}
		if ($keyword ['startprice'] != null) {
			$req->setStartPrice ( $keyword ['startprice'] );
		}
		if ($keyword ['endprice'] != null) {
			$req->setEndPrice ( $keyword ['endprice'] );
		}
		if ($keyword ['starttkRate'] != null) {
			$req->setStartTkRate ( $keyword ['starttkRate'] );
		}
		if ($keyword ['endtkrate'] != null) {
			$req->setEndTkRate ( $keyword ['endtkrate'] );
		}
		if ($keyword ['platform'] != null) {
			$req->setPlatform ( $keyword ['platform'] );
		}
		if ($keyword ['pageno'] != null) {
			$req->setPageNo ( $keyword ['pageno'] );
		}
		if ($keyword ['pagesize'] != null) {
			$req->setPageSize ( $keyword ['pagesize'] );
		}
		if ($keyword ['seller_id'] != null) {
			$req->setPageSize ( $keyword ['seller_id'] );
		}
		if ($keyword ['shop_url'] != null) {
			$req->setPageSize ( $keyword ['shop_url'] );
		}
		if ($keyword ['discount_price'] != null) {
			$req->setPageSize ( $keyword ['discount_price'] );
		}
		if ($keyword ['volume'] != null) {
			$req->setPageSize ( $keyword ['volume'] );
		}
		if ($keyword ['nick'] != null) {
			$req->setPageSize ( $keyword ['nick'] );
		}
		$resp = $client->execute ( $req );
		// $xmldoc=newDOMDocument();
		$resp = json_decode ( json_encode ( $resp ), true );
		return $resp;
	}
	function _TbkItemsDetail($numiid) {
		$client = $this->_tbsdk ();
		$req = new \TbkItemsDetailGetRequest ();
		$req->setFields ( "num_iid,seller_id,nick,title,price,volume,pic_url,item_url,shop_url" );
		$req->setNumIids ( $numiid );
		$resp = $client->execute ( $req );
		$resp = json_decode ( json_encode ( $resp ), true );
		// print_r($resp);
		return $resp;
	}
	public function TbkItemRequest() {
		echo ('关键词查询开始<br>');
		$keyword = $this->_keyword ();
		echo ('关键词查询结束<br>查询商品开始<br>');
		foreach ( $keyword as $k => $ItemGet ) {
			$resp = $this->TbkItemGet ( $keyword [$k] );
			$this->_tbkitem ( $resp ['results'] ['n_tbk_item'] );
		}
		echo ('查询商品结束<br>');
	}
	public function Tbkdetail() {
		$num_iid = $this->_numiid ();
		echo ('详细信息查询开始<br>');
		foreach ( $num_iid as $k => $TbkItems ) {
			if ($num_iid [$k] ['num_iid'] != null) {
				$resp = $this->_TbkItemsDetail ( $num_iid [$k] ['num_iid'] );
				$this->_tbkitemdetail ( $resp ['tbk_items'] ['tbk_item'] );
				$b = ++ $b;
			}
		}
		echo ('详细信息查询结束<br>');
		echo ('更新详细信息' . $b . '条<br>');
	}
	function post_tbk() {
		$num_iid = $this->_numiid ();
		foreach ( $num_iid as $k => $v ) {
			$save ['ID'] = $v ['num_iid'];
			$save ['post_author'] = '1';
			$save ['post_title'] = $v ['title'];
			$save ['post_info'] = $v ['title'];
			$save ['post_status'] = 'publish';
			$save ['post_content'] = '天猫店' . $v ['nick'] . '宝贝：' . $v ['title'] . '原价' . $v ['reserve_price'] . '现价仅' . $v ['zk_final_price'];
			$save ['post_parent'] = '0';
			$save ['post_type'] = 'post';
			// $save['guid']='http://127.0.0.1/sae/2/intex.php/Home/Title/?id='.$v['num_iid'];
			$save ['comment_count'] = rand ( 1000, 9999 );
			$this->_post_save ( $save, $k );
			// print_r($save);
			// echo('<br>==========<br>');
		}
	}
	function tbxx() {
		// $text=file_get_contents("http://item.taobao.com/item.htm?id=40073595141");
		// preg_match('/<img[^>]*id="J_ImgBooth"[^r]*rc=\"([^"]*)\"[^>]*>/', $text, $img);
		// print_r($img);
		$ch = curl_init (); // 初始化，创建句柄
		curl_setopt ( $ch, CURLOPT_URL, "http://rate.taobao.com/feedRateList.htm?callback=jsonp_reviews_list&userNumId=787326992&auctionNumId=14650572571&currentPageNum=1" ); // 设置细节参数
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		$str = curl_exec ( $ch ); // 获取内容
		$str = mb_convert_encoding ( $str, 'UTF-8', 'GBK' ); // 转换编码
		$str = str_replace ( 'jsonp_reviews_list(', '', $str ); // 去掉多余的字符串
		$str = str_replace ( ')', '', $str );
		$data = json_decode ( $str, TRUE ); // 得到数据了，第二个参数是转化为数组
		print_r ( $data ); // 输出页面查看;
	}
	function zxno() {
		$save = array ();
		// $m = D('Home/Wx');
		$ch = curl_init ();
		// 搜狐微信
		// $url = "http://weixin.sogou.com/weixin?type=2&query=%E9%BB%84%E8%8A%B1%E6%A2%A8&ie=utf8";
		// $pattern = '/<a target="_blank" href="(.*?)"(.*?)>(.*?)<\/a>/i';
		// 微头条
		$url = "http://so.wtoutiao.com/cse/search?q=%E9%BB%84%E8%8A%B1%E6%A2%A8&p=2&s=4457292908549467373&nsid=1";
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$data = curl_exec ( $ch );
		$Headers = curl_getinfo ( $ch );
		// print_r ( $data );
		curl_close ( $ch );
		// $pattern = '/<a(.*?)href="(.*?)"(.*?)>(.*?)<\/a>/i';
		$pattern = '/cpos="title" href\="([^\"]*?)\"/i';
		$data = preg_match_all ( $pattern, $data, $out, PREG_SET_ORDER );
		foreach ( $out as $k => $v ) {
			echo ($k . '========<br>');
			// print_r ( $v);
			$save ['article_url'] = $v [1];
			$m = D('Home/Wx');
			$m->_wxsave ( $save );
			echo ('<br>========<br>');
		}
	}
	function wxDetail() {
		$m = D('Home/Wx');
		$cwhere = "id=61" ;
		$url = $m-> _wxselect( $cwhere );
		foreach ( $url as $k => $v ) {
			$save = array ();
			$ch = curl_init ();
			echo ($k . '========<br>');
			$article_url = $v['article_url'];
			echo (	$article_url. '========<br>');
			curl_setopt ( $ch, CURLOPT_URL, $article_url );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
			$data = curl_exec ( $ch );
			$Headers = curl_getinfo ( $ch );
			// print_r ( $data );
			curl_close ( $ch );
			$pattern = '/<title>(.*?)<\/title>/i';
			//$article_view='/<div class="article_view"(.*)>[\s|\S]*?<\/div>/i';
			$article_view='/<div class="article_header" style="text-align: center;margin-bottom: 20px;">[\s|\S]*?<\/div><div/i';
			$data1 = preg_match_all ( $pattern, $data, $out1, PREG_SET_ORDER );
			$data2 = preg_match_all ( $article_view, $data, $out2, PREG_SET_ORDER );
			//print_r($out2);
			$save ['id']= $v['id'];
			$save ['article_title'] = $out1  [0] [1];
			echo ('<br>========<br>');
			$save ['article_content'] = $out2 [0] [0];
			$m = D('Home/Wx');
			$m->_wxsave ( $save );
			//print_r($save);
			echo ('<br>========<br>');
		}
	}

	function test() {
		$wxno = _wxno ();
		$b = 0;
		$wxno = object_array ( $wxno );
		print_r ( $wxno ['list'] );
		foreach ( $wxno ['list'] as $k => $v ) {
			echo ($b . '============<br>' . $k);
			$b = ++ $b;
		}
	}
}