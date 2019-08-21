<?php
/**
 * 更新/恢复/操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Data\DataService;

class UpdateDataController extends Controller
{


	public $data = '';

	public function __construct() {
		parent::__construct();
		$this->data = new DataService();
	}

	//更新数据库首页
	public function index() {
		$this->display( 'UpdateData/index' );
		die();
		$this->detectionDatabaseConnect();
		$databaselist = $this->data->updateDataProcess();
		// dump( $databaselist );
		$this->assign( 'databaselist', $databaselist );
		$this->display( 'UpdateData/index' );
	}

	//检测数据库类型连接
	public function detectionDatabaseConnect() {
		$databaseType = I( 'database' );
		$data = array( 'sqlserver', 'mysql' );
		$this->data->connectDatabases( $data );
		dump( $data );
	}

	//检测数据库库名是否存在
	public function detectionDatabaseName() {

	}



}