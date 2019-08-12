<?php
/**
 * 更新/恢复/操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Update\UpdateService;
use Home\Service\Restore\RestoreService;

use Home\Common\Utility\DataBaseUtility as DataBase;

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

		//$this->display( 'Common/out' );
		//die();

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
		$backupFile = $this->RestoreService->getBackUpZipList();
		if ( false == empty( $backupFile ))
			$this->assign( 'backupFile', $backupFile );

		//加载视图
		$this->display( 'Update/index' );
	}

	//更新文件
	public function update() {

		$data = new DataBase();
		$con = $data->db_con();

		$aaa = "select * from syscolumns where id=object_id('qgsh_report') and name='shsjwpmca'";
		// $sql = 'select * from contractTest';
		//添加字段
		//$sql = 'alter table ContractTest add test varchar(20) not null default 0';
		$sql = 'alter table qgsh_report add shsjwpmca varchar(50)';

		$result = odbc_exec( $con, $aaa );
		// $count = odbc_num_rows( $result );
		// echo $count; 
		//没有返回 0  有返回 -1
		//dump( $result );
		
		$ccc = odbc_fetch_array( $result );
		dump( $ccc );

		if ( false == $ccc ) {
			echo '字段不存在';
			$result = odbc_exec( $con, $sql );
			echo 123;
		} else {
			echo '字段存在';

		}

		false == $result ? die( '更新失败' ) : die( '更新成功' );

		dump( $result );

		// $aaa = odbc_fetch_array( $result );
		// $count = odbc_num_rows( $result );
		// while( $row = odbc_fetch_array( $result )){
		// 	dump( $row );
		// }

		// while (odbc_fetch_row($result)) {
		// 	dump( $result );
		// }
		die();

		$vid = I( 'version_id' );

		//版本ID为空时结束程序 - 此处可以放入单独的错误页面
		if ( empty( $vid )) die( '输入id名称' );

		//开始更新
		
		$this->UpdateService->updatePackProcess( $vid );
		$this->redirect('Common/message');
		die();

		$id = I( 'get.version_id' );
		$this->redirect( 'Update/reductionBackup' );
		
	}

	//恢复备份 - 还原
	public function restore() {
		$backUpFile = I( 'backupath' );
		if ( is_file( $backUpFile )) {
			$this->RestoreService->restoreBackUpProcess( $backUpFile );
			$this->redirect('Common/message');
		}
		//$this->redirect( 'Update/reductionBackup' );
	}

	


}