<?php
/**
 * 数据库操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Data;

use Home\Common\Utility\DataBaseUtility as DataBase;
use Home\Common\Utility\FileBaseUtility as FileBase;

class DataService
{

	//初始化数据库名称
	public $data = '';

	//初始化sql文件数组 - 包含文件名与SQL语句
	public $sqlFiles = array();

	public function __construct( $pFileArr ) {
		$this->typeDistinguish( $pFileArr );
	}

	/**
	 * [updateDataProcess 更新文件流程]
	 * @param  [string] $pDataType     [database type]
	 * @param  [array] $pDataFilePath [database file path]
	 * @return [type]                [null]
	 */
	public function updateDataProcess( $pDataType, $pDataFilePathArr ) {
		$this->connectData( $pDataType );
		$this->loadDataFile( $pDataFilePathArr );
		$result = $this->execStatements( $this->sqlFiles['5.sql'] );
		$this->fetchTest( $result );
		// dump( $this->sqlFiles );
		dump( $this->data );
		dump( $result );
	}

	/**
	 * [connectData 连接数据库]
	 * @param  [string] $pDataType [database type]
	 * @return [type]            [null]
	 */
	public function connectData( $pDataType ) {
		$this->data = new DataBase( $pDataType, $this->loadDataParam());
	}

	//加载数据库文件
	public function loadDataFile( $pDataFilePathArr ) {
		foreach ( $pDataFilePathArr as $value ) {
			$connect = FileBase::readFileAll( $value );
			$this->sqlFiles[basename($value)] = $connect;
		}
	}

	//分类数据库类型和文件
	public function typeDistinguish( $pFileArr ) {
		$keys = array_keys( $pFileArr );
		foreach ( $keys as $value ) {
			if ( false == empty( $pFileArr[$value] ))
				$this->updateDataProcess( $value, $pFileArr[$value] );
		}
	}
	
	//执行 SQL 语句
	public function execStatements( $pSql ) {
		//执行Sql语句
		return $this->data->odbcExec( $pSql );
	}

	//检测 SQL 是否更新成功
	public function checkSqlStatus() {

	}

	//加载数据库配置参数 - 临时用
	public function loadDataParam() {

		$conf['server'] 	= '.';
		$conf['user'] 		= 'sa';
		$conf['pass'] 		= '123123';
		$conf['database'] 	= 'hicisdata_new_test';
		$conf['connect'] 	= 'DRIVER={SQL Server};SERVER='.$conf['server'].';DATABASE='.$conf['database'];

		return $conf;

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