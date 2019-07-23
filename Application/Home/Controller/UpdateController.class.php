<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Index\UpdateService;

class UpdateController extends Controller
{

	public function __construct() {
		//加载权限管理 - 暂时未用
		parent::__construct();
		$this->UpdateService = new UpdateService();
		//查看当前版本
	}

	//主页面 - 视图
	public function index() {

		$typeId = I( 'type_id' );

		//如果未传入类别值 默认为分类列表的第一个类别
		if ( empty( $typeId ))
			$typeId = $this->UpdateService->getDefaultType();

		$datalist = $this->UpdateService->dataCollection( $typeId );
		$this->assign( 'datalist', $datalist );
		//查看当前版本
		parent::index();

	}

	//更新文件
	public function update() {

		$this->UpdateService->updatePackProcess( I( 'get.version_id' ));
		
		die();
		

		$id = I( 'get.version_id' );
		$this->redirect( 'Update/reductionBackup' );
		if ( FALSE === $id ) $this->tips( 0, '发送' );
		//$this->tips( 1, '发送' );
	}

	//恢复备份
	public function reductionBackup() {
		echo 123;
	}

	


}