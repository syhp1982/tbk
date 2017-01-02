<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
    	$mysql= M()->query("select VERSION() as version");
    	$mysql=$mysql[0]['version'];
    	$mysql=empty($mysql)?L('UNKNOWN'):$mysql;
    	 
    	//server infomaions
    	$info = array(
    			L('操作系统') => PHP_OS,
    			L('运行环境') => $_SERVER["SERVER_SOFTWARE"],
    			L('PHP运行方式') => php_sapi_name(),
    			L('MYSQL版本') =>$mysql,
    	);
    	$this->assign('server_info', $info);
    	$this->display();
    }
}