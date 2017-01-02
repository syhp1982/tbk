<?php

namespace Admin\Controller;

use Think\Controller;

class FriendlinkController extends BaseController {
	public function index() {
		$page_title = "友情链接";
		$friendlink_obj = M ( "links" );
		$count = $friendlink_obj->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show= $Page->show();// 分页显示输出
		$friendlink = $friendlink_obj->order('link_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign ( "friendlink", $friendlink );
		$this->assign('page',$show);// 赋值分页输出
		$this->display ();
	}
	public function friendlink_edit() {
		$page_title = "修改友链";
		$id = $_GET ['ID'];
		$friendlink_obj = M ( "links" );
		$cwhere = "link_id='" . $id."'";
		$friendlink = $friendlink_obj->where ( $cwhere )->find ();
		$this->assign ( "page_title", $page_title );
		$this->assign ( "friendlink", $friendlink );
		$this->display ( 'edit' );
	}
	public function friendlink_add() {
		$friendlink_obj = M ( "links" );
		$page_title = "添加友链";
		$friendlink = $friendlink_obj->select ();
		$this->assign ( "page_title", $page_title );
		$this->assign ( "friendlink", $friendlink);
		$this->display ( 'edit' );
	}
	public function doedit() {
		$link_id = $_GET ['ID'];
		$friendlink_obj = M ( "links" );
		if ($link_id) {
			$cwhere = "link_id=" . $link_id;
			$result = $friendlink_obj->where ( $cwhere )->save ( $friendlink_obj->create () );
		} else {
			$data ['link_id'] = $_POST ['link_id'];
			$data ['link_url'] = $_POST ['link_url'];
			$data ['link_name'] = $_POST ['link_name'];
			$data ['link_target'] = $_POST ['link_target'];
			$data ['link_description'] =$_POST ['link_description'];
			$data ['link_email'] =$_POST ['link_email'];
			$data ['link_updated'] =date("Y-m-d H:i:s");
			$data ['link_qq'] = $_POST ['link_qq'];
			$data ['link_status'] = $_POST ['link_status'];
			$result = $friendlink_obj->add ( $friendlink_obj->create ( $data ) );
		}
		if ($result > 0) {
			$this->success ( "修改成功！",U ( "Friendlink/index") );
		} else {
			$this->error ( "修改失败！" );
		}
	}
}