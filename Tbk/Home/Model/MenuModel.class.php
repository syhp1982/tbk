<?php


namespace Home\Model;

use Think\Model;

class MenuModel extends Model {

	/**
	 * 得到子级数组
	 * @param int
	 * @return array
	 */
	public function get_child($myid) {
		$a = $newarr = array();
		if (is_array($this->arr)) {
			foreach ($this->arr as $id => $a) {
				if ($a['parentid'] == $myid) {
					$newarr[$id] = $a;
				}
			}
		}
		return $newarr ? $newarr : false;
	}

}

?>