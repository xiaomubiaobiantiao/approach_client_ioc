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
	 * 错误提示
	 * [inforReceive description]
	 * @param  [string] 			[functionName]
	 * @param  [int] $param         [0,1,2...]
	 * @return [string]             [error: info]
	 */
	public function inforReceive( $pFunctionName = '', $pParam = '' ){
		return false == empty( $pParam )
			? '['.date( 'Y-m-d h:i:s').'] Error : '.$pFunctionName.' '.$this->errorInfo[$pParam]//. "\r\n"
			:'参数错误';
	}

	/**
	 * 成功提示
	 * [successReceive description]
	 * @param  [string] 			[functionName]
	 * @param  [int] $param         [0,1,2...]
	 * @return [string]             [success: info]
	 */
	public function successReceive( $pParam = '', $pStr = '' ) {
		return false == empty( $pParam )
			? '['.date( 'Y-m-d h:i:s').'] Success : '.$this->successInfo[$pParam].' '.$pStr//."\r\n"
			: '参数错误';
	}

	/**
	 * 写入日志文件
	 * [writeLog description]
	 * @param  [string] $pContent [description]
	 * @param  [type] $pLogFile [description]
	 * @return [type]           [description]
	 */
	public function writeLog( $pContent, $pLogFile ) {
		if ( false == ( $handle = fopen( $pLogFile, "a+" )))
			return false;
		fwrite( $handle, $pContent."\r\n" );
		fclose( $handle );
		return true;
	}

}