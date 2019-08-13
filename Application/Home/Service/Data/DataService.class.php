<?php
/**
 * 数据库操作类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Data;

use Home\Common\Utility\DataBaseUtility as DataBase;

class DataService
{

	//初始化数据库字段
	public $data = '';

	public function __construct() {
		//连接数据库
		$this->data = new DataBase( $this->connectParam());
	}

	//加载数据库参数
	public function loadDataParam() {

		$conf['server'] 	= '.';
		$conf['user'] 		= 'sa';
		$conf['pass'] 		= '123123';
		$conf['database'] 	= 'contract';
		$conf['connect'] 	= 'DRIVER={SQL Server};SERVER='.$conf['server'].';DATABASE='.$conf['database'];

		return $conf;

	}

	//加载数据库文件
	public function loadDataFile() {

	}

	//查看数据库类型
	public function checkDataType() {

	}

	//执行 SQL 语句
	public function execSql() {
		//执行Sql语句
		$result = $data->odbcExec( $sql );
	}

	//检测 SQL 是否更新成功
	public function checkSqlStatus() {

	}

	//初始化数据库需要的相关目录或文件
	public function initializeData() {
		DATABASE_UPDATE
		DATABASE_LOG
	}

	//字符串拼接 - 暂时未用
	public function connectStr( $pTableName, $pField, $pType ) {
		// $str = "select * from syscolumns where id=object_id('qgsh_report') and name='shsjwpmca'";
		$str = 'select * from syscolumns where id=object_id(' . $tableName . ') and name=' . $field;
		// $sql = 'alter table qgsh_report add shsjwpmca varchar(50)';
		$sql = 'alter table '.$tableName.' add '.$field.' '.$type;
	}


}