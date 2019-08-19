<?php
/**
 * 数据库操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Data;

use Home\Common\Utility\DataTypeUtility as DataType;
use Home\Common\Utility\FileBaseUtility as FileBase;

class DataService
{

	//初始化数据库名称
	public $data = '';

	//初始化sql文件数组 - 包含文件名与SQL语句
	public $sqlFiles = array();

	//数据库文件原始目录结构
	public $dataDir = '';

	//数据库文件需要更新的目录结构
	public $dataStructure = '';

	public function __construct() {
		$this->updateDataProcess();
	}

	//读取数据库文件目录
	private function readDataDir() {
		return FileBase::checkDirFiles( DATABASE_UPDATE );
	}

	/**
	 * [updateDataProcess 更新文件流程]
	 * @param  [string] $pDataType     [database type]
	 * @param  [array] $pDataFilePath [database file path]
	 * @return [type]                [null]
	 */
	public function updateDataProcess() {
		$this->dataDir = $this->readDataDir();
		$this->dataStructure = $this->loadDataFile( $this->dataDir );
		$this->typeDistinguish( $this->dataStructure );



		// $this->connectData( $pDataType );
		// dump( $pDataType );
		// $this->loadDataFile( $pDataFilePathArr );
		// $result = $this->execStatements( $this->sqlFiles['5.sql'] );
		// $this->fetchTest( $result );
		// dump( $this->sqlFiles );
		// dump( $this->data );
		// dump( $result );
		
	}

	/**
	 * [connectData 连接数据库]
	 * @param  [string] $pDataType [database type]
	 * @return [type]            [null]
	 */
	public function connectData( $pDataType ) {
		$this->data = new DataType( $pDataType, $this->loadDataParam());
	}

	private function loadDataFile( $pDataDir ) {
		return array_filter( $pDataDir );
		dump( $database );
		$keys = array_keys( $database );
		dump( $keys );
	}

	//加载数据库文件
	// public function loadDataFile( $pDataFilePathArr ) {
	// 	foreach ( $pDataFilePathArr as $value ) {
	// 		$connect = FileBase::readFileAll( $value );
	// 		$this->sqlFiles[basename($value)] = $connect;
	// 	}
	// }

	//分类数据库类型和文件
	public function typeDistinguish( $pFileArr ) {
		$keys = array_keys( $pFileArr );
		foreach ( $keys as $value ) {
			if ( false == empty( $pFileArr[$value] ))
				// $this->updateDataProcess( $value, $pFileArr[$value] );
				dump( $pFileArr[$value] );
		}
	}
	
	//执行 SQL 语句
	public function execStatements( $pSql ) {
		//执行Sql语句
		dump( $this->data );
		//return $this->data->odbcExec( $pSql );
	}

	//检测 SQL 是否更新成功
	public function checkSqlStatus() {

	}

	//加载数据库配置参数 - 临时用
	public function loadDataParam() {

		$dbconf['server'] 	= '.';
		$dbconf['user'] 		= 'sa';
		$dbconf['pass'] 		= '123123';
		$dbconf['database'] 	= 'hicisdata_new_test';
		$dbconf['connect'] 	= 'DRIVER={SQL Server};SERVER='.$dbconf['server'].';DATABASE='.$dbconf['database'];

		return $dbconf;

	}

	//字符串拼接 - 暂时未用
	public function connectStr( $pTableName, $pField, $pType ) {
		// $str = "select * from syscolumns where id=object_id('qgsh_report') and name='shsjwpmca'";
		$str = 'select * from syscolumns where id=object_id(' . $tableName . ') and name=' . $field;
		// $sql = 'alter table qgsh_report add shsjwpmca varchar(50)';
		$sql = 'alter table '.$tableName.' add '.$field.' '.$type;
	}

	//循环遍历内容 - 临时用
	public function fetchTest( $pArr ) {
		$this->data->fetchConnect( $pArr );
	}



}