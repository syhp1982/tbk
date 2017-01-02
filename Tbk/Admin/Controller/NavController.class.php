<?php

namespace Admin\Controller;

use Think\Controller;

class NavController extends BaseController {
	public function index() {
		// $this->_menu_list();
		$nav_obj = M ( "menu" );
		$cwhere1='cid=1';
		$nav1 = $nav_obj->where ( $cwhere1 )->select ();
		$cwhere2='cid=0';
		$nav2 = $nav_obj->where ( $cwhere2 )->select ();
		$this->assign ( "nav1", $nav1 );
		$this->assign ( "nav2", $nav2 );
		$this->display ();
	}
	public function nav_edit() {
		$page_title = "修改菜单";
		$id = $_GET ['ID'];
		$nav_obj = M ( "menu" );
		$cwhere = "ID=" . $id;
		$nav = $nav_obj->where ( $cwhere )->find ();
		$cwhere2 = "parentid=0";
		$nav2 = $nav_obj->where ( $cwhere2 )->select ();
		$this->assign ( "page_title", $page_title );
		$this->assign ( "nav", $nav );
		$this->assign ( "nav2", $nav2 );
		$this->display ( 'edit' );
	}
	public function nav_add() {
		$nav_obj = M ( "menu" );
		$page_title = "添加菜单";
		$cwhere2 = "parentid=0";
		$nav2 = $nav_obj->where ( $cwhere2 )->select ();
		$this->assign ( "page_title", $page_title );
		$this->assign ( "nav2", $nav2 );
		$this->display ( 'edit' );
	}
	public function doedit() {
		$id = $_GET ['ID'];
		$nav_obj = M ( "menu" );
		if ($id) {
			$cwhere = "ID=" . $id;
			$result = $nav_obj->where ( $cwhere )->save ( $nav_obj->create () );
		} else {
			$data ['cid'] = $_POST ['cid'];
			$data ['parentid'] = $_POST ['parentid'];
			$data ['label'] = $_POST ['label'];
			$data ['app'] = $_POST ['app'];
			$data ['model'] =$_POST ['model'];
			$data ['action'] =$_POST ['action'];
			$data ['cid'] = $_POST ['cid'];
			$data ['icon'] = $_POST ['icon'];
			$data ['listorder'] ='0';
			$data ['status'] = $_POST ['status'];
			$result = $nav_obj->add ( $nav_obj->create ( $data ) );
		}
		if ($result > 0) {
			$this->success ( "修改成功！",U ( "Nav/index") );
		} else {
			$this->error ( "修改失败！" );
		}
	}
	public function nav_del() {
		$id = $_GET ['ID'];
		$nav_obj = M ( "menu" );
		$result = $nav_obj->delete($id);
		if($result>0){
            $this->success("删除成功！",U ( "Nav/index"));
        }else{
            $this->error("删除失败！");
        }
	}
}