<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	//展示登录页面
	public function login(){
    	$this->display();
    }
    // 登录验证
    public function dologin() {
    	$name = $_POST ['username'];
    	$pass = md5($_POST['password']);
    	$verify = $_POST ['verify'];
    	$user_obj = M('user');
    	$user = $user_obj->where ( "user_login='%s' AND user_pass='%s'",$name,$pass )->find ();
    	if ($user) {
    			session ( "wodai", $user );
    			$user ['last_login_ip'] = get_client_ip ();
    			$user ['last_login_time'] = date ( "Y-m-dH:i:s" );
    			$user_obj->save ( $user );
    			$this->redirect ( 'Index/Index' );
    			$this->success ( "登录验证成功！", U ( "Index/index" ) );
    	} else {
    		$this->error ( "登陆失败！" );
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
    public  function logout(){
    	session(null);
    	$this->success('欢迎再来',U('Admin/Login/login'),3);
    }
}