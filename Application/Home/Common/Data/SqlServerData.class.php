<?php
/**
 * 数据库连接类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Data;
use Home\Interfaces\Database;

class SqlServerData implements Database
{

	//初始化数据库参数
	public $server = '';
	public $user = '';
	public $pass = '';
	public $database = '';
	public $connect = '';

	//数据库连接
	public $odbcConnect = '';

	//初始化 - 备用
	public function __construct( $pDataType, $pParamArr ) {
		$this->setParam( $pParamArr );
		$this->connection();
	}

	//设置数据库参数
	public function setParam( $pParamArr ) {
		$this->server = $pParamArr['server'];
		$this->user = $pParamArr['user'];
		$this->pass = $pParamArr['pass'];
		$this->database = $pParamArr['database'];
		$this->connect = $pParamArr['connect'];
	}

	//连接数据库
	public function connection() {
		$this->odbcConnect = odbc_connect( $this->connect, $this->user, $this->pass );
	}

	//执行Sql语句
	public function odbcExec( $pSql ) {
		return odbc_exec( $this->odbcConnect, $pSql );
	}
	
	//循环遍历内容
	public function fetchConnect( $pArr ) {
		while( $row = odbc_fetch_array( $pArr ))
			dump( $row );
	}

	//查看总行数
	public function numRows() {
		return odbc_num_rows( $result );
	}

	




}
