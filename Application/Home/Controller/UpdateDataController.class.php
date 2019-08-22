<?php
/**
 * 更新/恢复/操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
// use Home\Service\Data\DataService as DataService;
use Home\Utility\Container;

class UpdateDataController extends Controller
{

	public $dataService = '';

	public function __construct() {
		parent::__construct();
		$container = new Container();
		$this->container = $container;
	}

	//更新数据库首页
	public function index() {

		$dataService = $this->container->getInstance( 'DataService' );
		// die();
		$this->detectionDatabaseConnect( $dataService );
		// echo 123;
		die();

		// $databaselist = $this->dataService->updateDataProcess();
		// dump( $databaselist );
		// $this->assign( 'databaselist', $databaselist );
		// $this->display( 'UpdateData/index' );

	}

	//接收数据库类型参数并检测对应数据库连接
	public function detectionDatabaseConnect() {
		$databaseType = I( 'database' );
		$data = array( 'sqlserver', 'mysql' );
		$aaa = $this->container->run( 'DataService', 'test', $data );
		// $dataService->connectDatabase( 'DataTypeUtility', $data );
		// $this->dataService->connectDatabases( $data );
		dump( $aaa );
		// 
	}

	//检测数据库库名是否存在
	public function detectionDatabaseName() {

	}



}