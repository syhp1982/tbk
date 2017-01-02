<?php


namespace Home\Model;

use Think\Model;

class WxModel extends Model {
	public 		function _wxselect($cwhere) {
		$wx = M('wx');
		$result=$wx->where ( $cwhere )->select ();
		return $result;
	}
	public 	function _wxsave($save) {
		$wx = M('wx');
		if ($save) {
			$wx->create ( $save );
			if($save ['id']){
			$cwhere = "id=" . $save ['id'];
			$result = $wx->where ( $cwhere )->count ();
			print_r($result);}
			if ($result != 0) {
				echo ('更新开始=<br>');
				print_r ( $save ['id'] );
				print_r ( $save ['article_title'] );
				$wx->save ( $save );
				echo ('更新结束=<br>');
			} else {
				echo ('插入开始=<br>');
				print_r ( $save ['id'] );
				print_r ( $save ['article_title'] );
				$wx->add ( $save );
				echo ('插入结束=<br>');
			}
		}
	}
}

?>