<?php

namespace Home\Controller;

use Think\Controller;

class TitleController extends BaseController {
	private	 function _posts_id($title_id){
		$posts_obj = M("posts");
		$comments_obj = M("comments");
		$title_id=I ( "get.ID" );
		$cwhere1="1=1 and num_iid='".$title_id."'";
		$cwhere2="1=1 and comment_post_ID='".$title_id."'";
		//$cwhere2="1=1 and comment_post_ID='".$title_id."'";
		$posts=$posts_obj->where($cwhere1)->select();
		$comments=$comments_obj->where($cwhere2)->order('comment_date desc')->select();
		$usr=$_SESSION['user'];
		///print_r($usr);
		//print_r($comments);
		$this->assign ( "posts", $posts );
		$this->assign ( "comments", $comments );
	}
	
	Public function index() {
		$num_iid=I ( "get.ID" );
		$this->_options();
		$this->_Tbkitem_num_iid($num_iid);
		$this->_menu_list();
		$this->display();
	}
	Public function do_comment() {
		$comments_obj = M("comments");
		$data ['comment_ID'] = $_POST ['comment_ID'];
		$data ['comment_post_ID'] = $_POST ['comment_post_ID'];
		$data ['comment_post_title'] = $_POST ['comment_post_title'];
		$data ['comment_author'] = $_POST ['comment_author'];
		$data ['comment_author_email'] = $_POST ['comment_author_email'];
		$data ['comment_author_url'] = $_POST ['comment_author_url'];
		$data ['comment_author_IP'] = get_client_ip();
		$data ['comment_content'] = $_POST ['comment_content'];
		$data ['comment_parent'] = $_POST ['comment_parent'];
		if($data ['comment_parent']){
			$data ['comment_parent']=0;
		}
		if($data ['user_id']){
			$data ['user_id']="anonymous";
		}
		$data ['comment_date'] = date("Y-m-d H:i:s");
		if ($data ['comment_ID']) {
			$cwhere = "comment_ID=" . $data ['comment_ID'];
			$result = $comments_obj->where ( $cwhere )->save ( $comments_obj->create ($data ) );
		} else {
			$result = $comments_obj->add ( $comments_obj->create ( $data ) );
		}
		if ($result > 0) {
			$this->success ( "修改成功！" );
		} else {
			$this->error ( "修改失败！" );
		}
	}

}