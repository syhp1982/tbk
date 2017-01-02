<?php
namespace Admin\Controller;
use Think\Controller;
class CommentsController extends BaseController {
    public function index(){
    	$m = M("Comments");
    	$count= $m->count();
    	$Page= new \Think\Page($count,10);
    	$show= $Page->show();// 分页显示输出
    	$list = $m->order('comment_ID desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    	$this->assign("list",$list);
    	$this->assign('page',$show);// 赋值分页输出
    	$this->display();
    }
}