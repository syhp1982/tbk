<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends BaseController {
	public function index() {
// 		$this->_usermeta();
		$this->_menu_list();
		$this->_options();
		$this->_Tbkitem();
// 		$this->_hot();
// 		$this->_update();
		$this->display();
	}
	public function menu(){
		$id = $_GET ['ID'];
		$this->_Tbkitem_show($id);
		$this->_menu_list();
		$this->_options();
// 		$this->_Tbkitem();
		$this->display('index');
		//print_r($id);
	}

}