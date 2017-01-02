<?php
/*
 * 閲囬泦寮�褰╃エ鍙岃壊鐞冩暟鎹紝浠ュ強鍒嗘瀽褰╃エ鍙岃壊鐞冩暟鎹�
*/
header("Content-type: text/html; charset=utf-8");
class getSseqiu {
	var $purl= 'http://www.gdfc.org.cn/datas/history/twocolorball/history_*.html';
	var $files = 'caipiao.txt';
	var $_list ;
	function main($start,$end){
		$this->_list = $this->getFile();
		for( $i=$start; $i<=$end; $i++ ){
			$url = str_ireplace('*',$i,$this->purl);
			$this->getContent($url);
		}
		return true;
	}
	function getContent($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		if(!$data){
			return '';
		}
		# 鍒囧壊鏁翠釜椤甸潰
		$content = explode('<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#d3d3d3">',$data);
		$content = explode('</table>',$content[1]);

		# 鍖归厤鏁版嵁
		preg_match_all("/<tr>(.*?)<\/tr>/is", $content[0] ,$out);

		unset($out[1][0]);
		$con_all = $out[1];
		$qishu = null;
		ob_start();
		foreach($con_all as $key => $val){
			preg_match("/<td align=\"center\" bgcolor=\"(#FFFFFF|#faf8e9)\">(.*?)<\/td>/", $val,$matches_1);
			$title = $matches_1[2];
			preg_match("/<td align=\"center\" bgcolor=\"(#FFFFFF|#faf8e9)\" class=\"td-luckyno\" luckyNo=\"(.*?)\"><\/td>/", $val,$matches_2);
			$value = $matches_2[2];
			$str = trim($title.':'.$value);
			if(!in_array($str,$this->_list)){
				echo "\n".$str;
			}
		}
		$ob_content = ob_get_contents();
		ob_end_clean();
		$this->saveFile($ob_content);
		 
	}
	#淇濆瓨鏂囦欢
	function saveFile($data){
		if(!is_file($this->files)){
			$fp = fopen($this->files,'w+');
		}else{
			$fp = fopen($this->files,'a+');
		}
		fwrite($fp, $data);
		fclose($fp);
	}
	#鍙栨枃浠� 涓烘暟缁�
	function getFile(){
		$arr = array();
		if(!is_file($this->files)){
			return $arr;
		}
		$fp = fopen($this->files,'r');
		while (!feof($fp)) {
			$arr[] = trim(fgets($fp));
		}
		fclose($fp);
		return $arr;
	}
	function detachNum(){
		$file_list = $this->getFile();
		array_shift($file_list);
		$reu = array();
		foreach($file_list as $key => $val){
			$temp = $this->getLayout($val);
			$reu[$temp[0]] = $temp;
		}
		return $reu;
	}
	function getLayout($data){
		$reu = array();
		$reu = explode(':',$data);
		$reu[2] = substr($reu[1], -2, 2);
		$reu[1] = substr($reu[1],0,strlen($reu[1])-2);
		return $reu;
	}
	# 鏁版嵁澶勭悊
	function dataDispose($data,$qishu){
		if(!is_array($data)) return false;
		$coun = count($data);
		$foolr = floor($coun/2);
		$foolr_qishu = $foolr+1;
		$red = array();
		$blue = array();
		$num = 1;
		foreach($data as $key => $val){
			if($val[0] == $qishu){
				$num = $foolr;
				$weight_num = $foolr_qishu;
			}elseif($val[0]<$qishu){
				$weight_num = $num ++;
			}elseif($val[0]>$qishu){
				$weight_num = $num --;
			}
			# 绾�
			$son_arr = $this->stringNumber($val[1]);
			foreach($son_arr as $k2 => $v2){
				$red[intval($v2)]['hits'] = $red[intval($v2)]['hits']+1;
				$red[intval($v2)]['weight'] = $red[intval($v2)]['weight']+$weight_num;
			}
			# 钃�
			$blue[intval($val[2])]['hits'] = $blue[intval($val[2])]['hits']+1;
			$blue[intval($val[2])]['weight'] = $blue[intval($val[2])]['weight']+$weight_num;
		}
		 
		for( $i=0; $i<=33 ;$i++ ){
			if($red[$i]){
				$red[$i]['mean'] = round($red[$i]['hits']/$red[$i]['weight'],2) ;
			}
			 
		}
		for( $i=0; $i<=16 ;$i++ ){
			 
			if($blue[$i]){
				$blue[$i]['mean'] = round($blue[$i]['hits']/$blue[$i]['weight'],2);
			}
		}
		return array( 'red'=>$red, 'blue'=>$blue);
	}
	function stringNumber($string){
		$list = array();
		$list[] = substr($string, 0, 2);
		$list[] = substr($string, 2, 2);
		$list[] = substr($string, 4, 2);
		$list[] = substr($string, 6, 2);
		$list[] = substr($string, 8, 2);
		$list[] = substr($string, 10, 2);

		return $list;
	}
	//  function dbMysql(){
	//      $conn = mysql_connect('localhost','root','root') or die('杩炴帴Mysql閿欒锛�'.mysql_error());
	//      mysql_select_db('caipiao',$conn) or die('杩炴帴鏁版嵁搴撻敊璇細'.mysql_error());
	//      mysql_query('set names gbk');
	//  }
}
// 閲囬泦鏁版嵁
//$start = 1;
//$end = 1;
//$Ss = new getSseqiu();
//$Ss->main($start, $end);
?>