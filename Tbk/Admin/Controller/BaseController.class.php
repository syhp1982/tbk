<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
	//初始化	public function _initialize(){		if($_SESSION['wodai'] == ""){			$this->error('非法操作',U('Admin/Login/login'),3);		}
		$this->_usermeta();
		$this->_menu_list();	}	public function _menu_list(){
		$menu_obj=M("menu");
		$cwhere="1=1 and parentid=0 and  cid =1 and status=1";
		$menu1=$menu_obj->where($cwhere)->select();
		$cwhere1="1=1 and parentid!=0 and  cid =1 and status=1";
		$menu2=$menu_obj->where($cwhere1)->select();
		//print_r($menu2);
		foreach ($menu1 as $k1 => $v1 ){
			$sidebar2="";
			$url="/Tbk/index.php/".$v1['app']."/".$v1['model']."/".$v1['action'].".html";
			$sidebar.="<li><a href=\"".$url."\" target=\"myMainName\"> <i class=\"".$v1['icon']."\"></i> <span>".$v1['label']."</span>";
			foreach ($menu2 as $k2 => $v2){
				if($v1['id']==$v2['parentid']){
					//$sidebar.="<li><a href=\"#\"> <i class=\"".$v1['icon']."\"></i> <span>".$v1['label']."</span>";
					$url="/Tbk/index.php/".$v2['app']."/".$v2['model']."/".$v2['action'].".html";
					$sidebar2.="<li><a href=\"".$url."\" target=\"myMainName\"><span>".$v2['label']."</span></a></li>";		
				}
			}
			if($sidebar2){
				$sidebar.="<span class=\"glyphicon glyphicon-chevron-right\"></span></a><ul>".$sidebar2."</ul></li>";
			}else {
				$sidebar.="</a></li>";
			}
		}
		$this->assign ( "sidebar",$sidebar );
		
	}
	public function _usermeta(){
		$usermeta_obj=M("usermeta");
		$user_id=$_SESSION['wodai']['id'];
		$cwhere="user_id=".$user_id;
		$usermeta=$usermeta_obj->where($cwhere)->select();
		foreach ( $usermeta as $k => $v ) {
			$userinfo[$v['meta_key']]=$v['meta_value'];
		}
		$this->assign ( "userinfo", $userinfo );
	}
}