<?phpnamespace Admin\Controller;use Think\Controller;class MailController extends BaseController {		public  function index() {		//$this->_menu_list();			$this->display();	}	public  function stmp() {		//$this->_menu_list();		$this->display();	}	public function saveEmail(){		$m = M("options");		$result = $m->where("id = 1")->save($_POST);		if($result){			$this->success("操作成功");		}else{			$this->error("操作失败");		}	}}