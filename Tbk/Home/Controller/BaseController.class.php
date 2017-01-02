<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {	public function _menu_list(){
		$menu_obj=M("menu");
		$cwhere="1=1 and parentid=0 and  cid =0 and status=1";
		$sidebar=$menu_obj->where($cwhere)->select();
// 		$cwhere2="1=1 and parentid!=0 and  cid =0 and status=1";
// 		$menu2=$menu_obj->where($cwhere2)->select();
		//print_r($menu2);
// 		foreach ($menu1 as $k => $v ){
// 			$sidebar2="";
// 			$sidebar.="<a class=\"blog-nav-item\" href=\"../".$v['app']."/".$v['model']."/".$v['action']."/ID/".$v['id']."\"><span> ".$v['label']."</span>";
// // 			foreach ($menu2 as $k1 => $v1 ){
// // 				if($v['id']==$v1['parentid']){
// // 					$url="/sae/2/index.php/".$v1['app']."/".$v1['model']."/".$v1['action'].".html";
// // 					$sidebar2.="<li><a href=\"".$url."\"><span>".$v1['label']."</span></a></li>";		
// // 				}
// // 			}
// 			if($sidebar2){
// 				$sidebar.="<span class=\"glyphicon glyphicon-chevron-right\"></span></a><ul>".$sidebar2."</ul></li>";
// 			}else {
// 				$sidebar.="</a>";
// 			}
// 		}
		$this->assign ( "sidebar",$sidebar );
		
	}
	public function _usermeta(){
		$usermeta_obj=M("usermeta");
		if($_SESSION['wodai']){
		$user_id=$_SESSION['wodai']['id'];
		$cwhere="user_id=".$user_id;
		$usermeta=$usermeta_obj->where($cwhere)->select();
		foreach ( $usermeta as $k => $v ) {
			$userinfo[$v['meta_key']]=$v['meta_value'];
		}
		$this->assign ( "userinfo", $userinfo );
		}
	}

// 	public function _posts_list(){
// 		$posts_obj = M("posts");
// 		$cwhere="1=1 and post_status='publish' and post_type='post' and post_date<now()";
// 		$count=$posts_obj->where($cwhere)->count();
// 		$Page= new \Think\Page($count,5);
// 		$show= $Page->show();
// 		$posts=$posts_obj->where($cwhere)->order('post_modified desc,post_date desc')->limit($Page->firstRow.','.$Page->listRows)->select();
// 		$this->assign('page',$show);// 赋值分页输出
// 		//print_r($Page);
// 		$this->assign ( "posts", $posts );
// 	}
	public function _Tbkitem(){
		$posts_obj = M("tbkitem");
		$menu_obj=M("menu");
// 		$cwhere="1=1 and post_status='publish' and post_type='post' and post_date<now()";

		$count=$posts_obj->count();
		$Page= new \Think\Page($count,12);
		// 实例化分页类 传入总记录数和每页显示的条数
		//$Page->setConfig('theme', '<li><a>%totalRow% %header%</a></li> %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end% ');
		$show= $Page->show();
		$posts=$posts_obj->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('page',$show);// 赋值分页输出
		//print_r($Page);
		$this->assign ( "posts", $posts );
		//print_r($posts);
	}
	public function  _menu_label($ID){
		$menu_obj=M("menu");
		$cwhere1="id=".$ID;
		$label=$menu_obj->field('label')->where($cwhere1)->find();
		$label=implode(",", $label);
		return $label;
	}
	public function _Tbkitem_show($ID){
		$label=$this->_menu_label($ID);
		//print_r($label);
		$posts_obj = M("tbkitem");
		$cwhere="title like '%".$label."%'";
		$count=$posts_obj->where($cwhere)->count();
		$Page= new \Think\Page($count,12);
		// 实例化分页类 传入总记录数和每页显示的条数
		//$Page->setConfig('theme', '<li><a>%totalRow% %header%</a></li> %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end% ');
		$show= $Page->show();
		$posts=$posts_obj->where($cwhere)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('page',$show);// 赋值分页输出
		//print_r($Page);
		$this->assign ( "posts", $posts );
		//print_r($posts);
	}
	public function _Tbkitem_num_iid($num_iid){
		$posts_obj = M("tbkitem");
		$cwhere="num_iid like '%".$num_iid."%'";
		$posts=$posts_obj->where($cwhere)->select();
		$this->assign('page',$show);// 赋值分页输出
		//print_r($Page);
		$this->assign ( "posts", $posts );
		//print_r($posts);
	}
	public function _options(){
		$options_obj = M("options");
		$cwhere="autoload='yes'";
		$options=$options_obj->where($cwhere)->select();
		$this->assign ( "options", $options );
	}
	public function _hot(){
		$hot_obj = M("posts");
		$cwhere="1=1 and post_status='publish' and post_type='post' and post_date<now()";
		$hot=$hot_obj->where($cwhere)->order('comment_count desc')->limit(5)->select();
		$this->assign ( "hot", $hot );
	}
	public function _rand(){
		$rand_obj = M("posts");
		$cwhere="1=1 and post_status='publish' and post_type='post' and post_date<now()";
		$rand=$rand_obj->where($cwhere)->order('rand()')->limit(5)->select();
		$this->assign ( "rand", $rand );
	}
	public function _update(){
		$update_obj = M("posts");
		$cwhere="1=1 and post_status='publish' and post_type='post'";
		$update=$update_obj->where($cwhere)->order('post_date desc')->limit(5)->select();
		$this->assign ( "update", $update );
	}
}