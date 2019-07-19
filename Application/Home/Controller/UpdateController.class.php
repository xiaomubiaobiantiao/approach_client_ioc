<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Index\IndexService;

class UpdateController extends Controller
{

	public function __construct() {
		//加载权限管理 - 暂时未用
		parent::__construct();
		$this->IndexService = new IndexService();
		//查看当前版本
	}

	//主页面 - 视图
	public function index() {
		
		$result = $this->IndexService->getUpdatePack();
		$this->assign( 'list', $result );
		
		//查看当前版本
		parent::index();
	}

	//更新文件
	public function update() {

		$this->IndexService->updatePackProcess( I( 'get.version_id' ));
		
		die();
		

		$id = I( 'get.version_id' );
		$this->redirect( 'Index/reductionBackup' );
		if ( FALSE === $id ) $this->tips( 0, '发送' );
		//$this->tips( 1, '发送' );
	}

	//恢复备份
	public function reductionBackup() {
		echo 123;
	}

	//跳转提示 - 暂时未写
	public function tips( $pTips, $pStr='' ) {
		FALSE == $pTips
			? $this->error( $pStr.'失败' )
			: $this->success( $pStr.'成功' );
	}

	//上传更新包  - 视图
	public function uploadPackView() {

	}

	//选择更新包 - 视图
	public function choosePackView() {

	}

	//上传更新包 - 功能
	public function uploadPack() {

	}

	//查看当前版本 - 功能
	public function checkVersion() {

	}
	
	//开始更新/开始恢复 - 功能
	public function startUpdate() {

	}

	


}