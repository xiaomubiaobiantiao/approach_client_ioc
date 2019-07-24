<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Update\UpdateService;

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
		empty( $typeId )
			? $datalist = $this->UpdateService->getDefaultType()
			: $datalist = $this->UpdateService->dataCollection( $typeId );

		$datalist[3] = $this->UpdateService->getVersion();
		$this->assign( 'datalist', $datalist );
		$this->display( 'Update/index' );
	}

	//更新文件
	public function update() {

		$vid = I( 'version_id' );

		//版本ID为空时结束程序 - 此处可以放入单独的错误页面
		if ( empty( $vid )) die( '输入id名称' );

		$this->UpdateService->updatePackProcess( $vid );
		
		die();
		

		$id = I( 'get.version_id' );
		$this->redirect( 'Update/reductionBackup' );
		
	}

	//恢复备份
	public function reductionBackup() {
		echo 123;
	}

	


}