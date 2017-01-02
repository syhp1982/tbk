<?php


namespace Home\Model;

use Think\Model;

class KeywordModel extends Model {
	public 	function _keyword() {
		$keyword = $this->keyword_obj->order('rand()')->limit(1)->select ();
		return $keyword;
	}

}

?>