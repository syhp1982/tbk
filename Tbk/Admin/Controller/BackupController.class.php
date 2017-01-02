<?php

namespace Admin\Controller;

use Think\Controller;

class BackupController extends BaseController {
	public $backup_path = ''; // 备份文件夹相对路径
	public $backup_name = ''; // 当前备份文件夹名
	public $offset = '500'; // 每次取数据条数
	public $dump_sql = '';
	public function _initialize() {
		parent::_initialize ();
		$this->backup_path = './data/backup/';
	}
	public function index() {
		$page_title = "数据恢复";
		$page_title2 = "数据备份";
		$this->assign ( 'backups', $this->_get_backups () );
		$this->assign ( "page_title", $page_title );
		$this->assign ( "page_title2", $page_title2 );
		// $this->assign('backup_name', $this->_make_backup_name());
		$this->assign ( 'tables', M ()->db ()->getTables () ); // 显示所有数据表
		$this->display ();
	}
	/**
	 * 删除备份
	 */
	public function delBackup(){
		$backup_name = $_GET['backup_name'];
		if(empty($backup_name)){
			$this->error("没有文件");
		}else{
			$result = unlink($this->backup_path.$backup_name);
			$this->success("已删除");
			//$this->myRelust($result);
		}
	}
	/**
	 * 数据恢复
	 */
	public function restore() {
		$name = $_GET['backup_name'];
		$filename=$this->backup_path.$name;
		//执行SQL
		$str=file_get_contents($filename);
		$arr=explode('-- <wodai> --', $str);
		array_pop($arr);
		//print_r($arr);
		$Model = M ();
		foreach ($arr as $k=>$v) {
			$sql= $v;
			$rs = $Model->execute ($sql);
		}
		if ($rs == false) {
			$this->error("操作失败！");
		} else {
			$this->success("操作成功！");
		}
	}
	/**
	 * 数据备份
	 */
	public function dobackup() {
		if (IS_POST) {
			$sizelimit = $_POST ['sizelimit'];
			$backup_name = $_POST ['backup_name'] ;
			$backup_tables = $_POST ['backup_tables'];
			header ( "Content-type: text/html; charset=utf-8" );
			$sql1 = $this->sqlcreate ( $backup_tables );
			$sql2 = $this->sqlinsert ( $backup_tables );
			$data = $sql1.$sql2;
			if(file_exists($this->backup_path . $backup_name . "-".date ( "Y-m-d", time () ). ".sql")){
				$this->error("同名备份已存在！");
			}else{
				$result = file_put_contents ( $this->backup_path . $backup_name . "-".date ( "Y-m-d", time () ). ".sql", $data );
			}
			if ($result == false) {
				$this->error("操作失败！");
			} else {
				$this->success("操作成功！");
			}
		}
	}
	public function download() {
		$backup_name = $_GET ['backup_name'] ;
		$sql_file =  $this->backup_path . $backup_name;
		if (file_exists($sql_file))
		{
			header('Content-type: application/unknown');
			header('Content-Disposition: attachment; filename="'  . $backup_name . '"');
			header("Content-Length: " . filesize($sql_file) . "; ");
			readfile($sql_file);
		} else
		{
			$this->error('文件不存在！');
		}
		
	}
	/**
	 * 表结构SQL .
	 */
	public function sqlcreate($tb) {
		$sql = '';
		$Model = M ();
		foreach ( $tb as $k => $v ) {
			$sql .= "DROP TABLE IF EXISTS `$k`;\n";
			$rs = $Model->query ( "SHOW CREATE TABLE  " . $k );
			$temp = $rs [0] ['create table'];
			
			$sql.= "-- 表的结构：{$k} --\r\n";
			$sql.= "{$temp}";
			$sql.= ";\r\n-- <wodai> --\r\n";
		}
		//$sql=$sql1.$sql2;
		return $sql;
	}
	/**
	 * 表结构数据 .
	 */
	public function sqlinsert($tb) {
		$sql = '';
		$Model = M ();
		foreach ( $tb as $k => $v ) {
			$rs = $Model->query ( "SELECT * FROM " . $k );
			if (! $rs) { // 无数据返回
				continue;
			}
			$fields = array_keys ( $rs [0] );
			foreach ( $rs as $k1 => $v1 ) {
				$sql .= "INSERT INTO `$k` \r\n (`" . implode ( "`, `", $fields ) . "`)\r\n VALUES(";
				foreach ( $v1 as $k2 => $v2 ) {
					if ($v2 === null) {
						$sql .= "NULL,";
					} else {
						$sql .= "'$v2',";
					}
				}
				$sql=mb_substr($sql, 0, -1);
				$sql .= ");\r\n-- <wodai> --\r\n";
			}
			//$sql=mb_substr($sql, 0, -3);
			//$sql.=";<br>-- <wodai> --\r\n\r\n";
			
		}
		return $sql;
	}
	
	/**
	 * 获得备份列表
	 */
	private function _get_backups() {
		$backups = array (); // 所有的备份
		if (is_dir ( $this->backup_path )) {
			if ($handle = opendir ( $this->backup_path )) {
				while ( ($file = readdir ( $handle )) !== false ) {
					//print_r($file {0});
				
					if ($file {0} != '.' ) {
						$backup ['name'] = $file;
						$backup ['date'] = filemtime ( $this->backup_path . $file ) - date ( 'Z' );
						$backup ['date_str'] = date ( 'Y-m-d H:i:s', $backup ['date'] );
						// $backup['vols'] = $this->_get_vols($file);
						$end_vol = end ( $backup ['vols'] );
						//$backup['total_size'] =round($this->_get_dir_size($this->backup_path . $file)/1024,2);
						$backup['total_size'] =round(filesize($this->backup_path.$file)/1024,2);
						$backups [] = $backup;
					}
				}
			}
		}
		//print_r($backups);
		echo "=====<br />";
		ksort ( $backups );
		return $backups;
	}
	/**
	 * 获得备份大小
	 */
	function _get_dir_size($dir)
	{
		$handle = opendir($dir);
		$sizeResult=0;
		while (false !== ($FolderOrFile = readdir($handle)))
		{
			if ($FolderOrFile != "." && $FolderOrFile != "..")
				{
					$sizeResult += filesize("$dir/$FolderOrFile");
				}
			}
		
		closedir($handle);
		return $sizeResult;
	}
}