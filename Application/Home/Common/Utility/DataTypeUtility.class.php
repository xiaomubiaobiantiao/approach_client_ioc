<?php
/**
 * 数据库连接类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Utility;

use Home\Common\Data\SqlServerData;
use Home\Interfaces\Database;

class DataTypeUtility implements Database
{

	//数据库对象
	public $database = '';
	//数据库类型
	public $dataType = '';
	//连接数据库参数
	public $databaseParams = '';

	// public function __construct( $pDataType='', $pDatabaseParams='' ) {
	// 	$this->setDataType( $pDataType );
	// 	$this->sqlserverParam( $pDatabaseParams );
	// }

	// public function __construct( Database $pDatabase = null, $pDatabaseParams = null ) {
	// 	if ( false == empty( $pDatabase )) {
	// 		$this->database = $pDatabase;
	// 		$this->dataType = $pDatabase;
	// 	}
	// }

	public function __construct() {

	}

	/* ------------------------------------------------------------------------------------*/
	/* ------------------------------------ 数据库类型 ------------------------------------*/
	/* ------------------------------------------------------------------------------------*/

	public function test() {
		echo  123;
	}

	//设置数据库类型
	private function setDataType( $pDataType ) {
		$this->dataType = $pDataType;
	}

	//连接数据库
	public function connection( Database $pDatabase = null, $params = null ) {
		dump( $Database );
		$this->database = $pDatabase;
		$this->setDataType( $pDatabase );
		dump( $this->database );
		die();
		return $this->database->connection( $this->databaseParams );
	}

	//新建数据库
	public function newDatabase() {
		return $this->database = new $this->dataType;
	}

	//oracle 参数
	public function oracleParam( $pDatabaseParams ) {
		
	}

	//mysql 参数
	public function mysqlParam() {

	}

	//sqlserver 参数
	public function sqlserverParam() {
		$this->param = $pDatabaseParams;
	}

	/* ------------------------------------------------------------------------------------*/

	/**
	 * db_con  - 暂时未用
	 *
	 * 创建SqlServer连接。
	 * 使用ODBC连接方式，需要到微软官网下载sqlserver for php相关驱动并重启。
	 * 注意驱动版本和x86,64位类型，在php.ini 开启 odbc 扩展。
	 * sqlserver与php在同一台机器同一个系统下容易连接成功。Linux没作测试。
	 *
	 * 执行此函数可以检测驱动是否安装成功。
	 * 使用时，相关参数需要更改为你实际使用的数据库对应的参数。
	 */
	public function db_con()
	{
	    // $server = '.';
	    // $username = 'sa'; //数据库用户名
	    // $password = '123123';   //数据库密码
	    // $database = 'contract';     //数据库
	    // $con_url = "Driver={SQL Server};Server=$server;Database=$database";
	    //define ...
	    $con = odbc_connect($con_url, $username, $password, SQL_CUR_USE_ODBC);
	    if ($con)
	        return $con;
	    return null;
	}

	/**
	 * db_query - 暂时未用
	 * 执行select语句，返回二维数组(不含字段)，参考test.php。
	 */
	public function db_query( $sql, $fieldcount)
	{
	    $con = $this->db_con();
	    if (is_null($con))
	        return null;
	 
	    $rs = odbc_exec($con, $sql);
	 
	    if( $rs === false) {
	        //echo 'sql error : ' . $sql;
	        //exit;
	    }
	 
	    $table = array();
	 
	    if( $rs === false || odbc_num_rows($rs) == 0 ) {
	        return $table;
	    }
	 
	    while (odbc_fetch_row($rs)) {
	        $row = array();
	        $n = 0;
	        while( $n < $fieldcount ) {
	            $row[] = odbc_result($rs, ++$n);
	        }
	        $table[] = $row;
	    }
	 
	    if( count($table) > 0  ) {
	        odbc_free_result($rs);
	    }
	 
	    odbc_close($con);
	 
	    return $table;
	}


	/**
	 * odbc_exec - 暂时未用
	 * 执行insert，update或delete语句。
	 * 如果执行不成功，调整一下数据库参数和odbc_connect参数。
	 */
	public function db_exec( $sql )
	{
	    $con = db_con();
	    if (is_null($con))
	        return null;
	    $dat = odbc_exec($con, $sql);
	    odbc_close($con);
	    return $dat;
	}


}