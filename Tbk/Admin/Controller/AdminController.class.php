<?phpnamespace Admin\Controller;use Think\Controller;class AdminController extends BaseController {		public  function index() {		$this->display();	}	//站点信息	public  function options() {		$options_obj=M("options");    	$cwhere="autoload='yes'";    	$options=$options_obj->where($cwhere)->select();    	//$this->assign ( "usermeta", $usermeta );    	foreach ( $options as $k => $v ) {    		$options_info[$v['option_name']]=$v['option_value'];    	}		//print_r($options_info);		$this->assign ( "options_info", $options_info );		$this->display();		}	public function doedit(){		$options_obj = M("options");		$options = $options_obj->create();		$options=$_POST;		if(empty($_FILES['logo']['name'])){            unset($options['logo']);		}else{			$upload = new \Think\Upload();// 实例化上传类			$upload->maxSize   =     3145728 ;// 设置附件上传大小			$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型			$upload->rootPath  =      './Public/images/admin/'; // 设置附件上传目录    // 上传文件			$info   =   $upload->uploadOne($_FILES['logo']);			if(!$info) {// 上传错误提示错误信息				$this->error($upload->getError());			}else{// 上传成功				$options['logo']=$info['savepath'].$info['savename'];			}		}		foreach ( $options as $k => $v ) {			//$a=1;			//$data['option_id']= $a;			$data['option_name']= $k;			$data['option_value']=$v;			$cwhere="option_name='".$k."'";			$result = $options_obj->where($cwhere)->save($data);			print_r($data);			//$a = ++ $a;		}		 $this->success('操作成功');			}}