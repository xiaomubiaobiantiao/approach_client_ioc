<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Update\UpdateService;
use Home\Service\Restore\RestoreService;

class UpdateController extends Controller
{

	public function __construct() {
		//加载权限管理 - 暂时未用
		parent::__construct();
		$this->UpdateService = new UpdateService();
		$this->RestoreService = new RestoreService();
	}

	//主页面 - 视图
	public function index() {

		//加载更新文件
		$typeId = I( 'type_id' );
		//如果未传入类别值 默认为分类列表的第一个类别
		empty( $typeId )
			? $datalist = $this->UpdateService->getDefaultType()
			: $datalist = $this->UpdateService->dataCollection( $typeId );

		//获取当前项目版本
		$datalist[3] = $this->UpdateService->getVersion();
		$this->assign( 'datalist', $datalist );

		//加载备份文件 - 还原
		$backupList = $this->RestoreService->getBackUpZipList();
		if ( false == empty( $backupList ))
			$this->assign( 'backuplist', $backupList );

		//加载视图
		$this->display( 'Update/index' );
	}


	//更新文件
	public function update() {

		echo $_SERVER["HTTP_REFERER"];
		//die();
		//http://localhost:81/index.php/Home/Update/index.html
		// 操作完成3秒后跳转到 /Article/index
		//$this->success( '操作完成', 'redirectNew', 1 );
		//重定向到New模块的Category操作
		//$this->redirect('New/category', array('cate_id' => 2), 5, '页面跳转中...');
		//只指定地址,而不指向某个模块操作的方法
		//redirect('Home/Progress/index', 1, '页面跳转中...');
		$this->redirect('Progress/index');
		//header("Location: http://bbs. lampbrother.net");

		die();

		$vid = I( 'version_id' );

		//版本ID为空时结束程序 - 此处可以放入单独的错误页面
		if ( empty( $vid )) die( '输入id名称' );

		$this->UpdateService->updatePackProcess( $vid );
		
		die();
		

		$id = I( 'get.version_id' );
		$this->redirect( 'Update/reductionBackup' );
		
	}

	//恢复备份 - 还原
	public function restore() {
		$backUpFile = I( 'backupath' );
		if ( is_file( $backUpFile )) {
			$this->RestoreService->restoreBackUpProcess( $backUpFile );
			//$this->redirect( 'Update/reductionBackup' );
		}
		//$this->redirect( 'Update/reductionBackup' );
	}

	


}