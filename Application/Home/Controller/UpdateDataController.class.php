<?php
/**
 * 更新/恢复/操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Data\DataService as DataService;
use Home\Common\Utility\ChildrenUtility as children;

class UpdateDataController extends Controller
{

	public $dataService = '';

	public function __construct() {
		parent::__construct();
		$this->children = new children();
		$this->dataService = $this->children->make( 'DataService', array( $this->children ) );
	}

	// 更新数据库首页
	public function index() {
		
		$this->detectionDatabaseConnect();
		// echo 123;
		die();

		// $databaselist = $this->dataService->updateDataProcess();
		// dump( $databaselist );
		// $this->assign( 'databaselist', $databaselist );
		// $this->display( 'UpdateData/index' );

	}

	// 接收数据库类型参数并检测对应数据库连接
	public function detectionDatabaseConnect() {

		$databaseType = I( 'database' );
		$data = array( 'Sqlserver', 'Mysql' );
		$this->dataService->connectDatabase( $data );

	}

	// 检测数据库库名是否存在
	public function detectionDatabaseName() {

	}

	// 测试
	public function test( DataService $DataService ) {
		$DataService->test();
	}


}