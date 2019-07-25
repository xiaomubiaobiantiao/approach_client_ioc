<?php
/**
 * 实现日志
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Supply\Log;

use Think\Controller;

class Logs extends Controller implements Log
{

	protected $errorInfo = array();

	protected $successInfo = array();

	/**
	 * 错误提示并写入错误日志
	 * [inforReceive description]
	 * @param  string $functionName [functionName]
	 * @param  [int] $param         [0,1,2...]
	 * @return [string]             [error: infor]
	 */
	public function inforReceive( $functionName = '', $param = '' ){
		if ( false == empty( $param )) {
			echo '[' . date( 'Y-m-d h:i:s') . '] Error : '.$functionName.' '.$this->errorInfo[$param]. "\r\n".'<br>';
			//errorLog();写入到全部日志 - 写入到错误日志
			//die();
		} 
	}

	/**
	 * 操作成功写入日志
	 * [successReceive description]
	 * @param  string $functionName [functionName]
	 * @param  [int] $param         [0,1,2...]
	 * @return [string]             [success: infor]
	 */
	public function successReceive( $param = '', $pStr = '' ) {
		echo 666666;
		dump( $param );
		dump( $pStr );
		if ( false == empty( $param )) {
			echo '[' . date( 'Y-m-d h:i:s') . '] Success : '.$this->successInfo[$param].' '.$pStr."\r\n".'<br>';
			//errorlog();写入到全部日志 - 写入到成功日志
		} 
	}



}