<?php
/**
 * 数据库连接类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Utility;

class DataBaseUtility
{

	//初始化数据库参数
	public $server = '';
	public $user = '';
	public $pass = '';
	public $database = '';
	public $connect = '';

	public $odbcConnect = '';

	//初始化 - 备用
	public function __construct( $pDataType, $pParamArr ) {
		$this->setParam( $pParamArr );
		$this->linkDataBase();
	}

	//设置数据库参数
	public function setParam( $pParam ) {
		$this->server = $pParam['server'];
		$this->user = $pParam['user'];
		$this->pass = $pParam['pass'];
		$this->database = $pParam['database'];
		$this->connect = $pParam['connect'];
	}

	//连接数据库
	public function linkDataBase() {
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