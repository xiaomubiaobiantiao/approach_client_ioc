<?php
/**
 * 继承文件检测类 - 文件检测类继承 log 日志类
 * 只服务于 UpdateService
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Update;

use Home\Supply\Detection\Detection;

class RestoreDetectionLogService extends Detection
{

	protected $errorInfo = array(

			1 => 'Search update file ',
			2 => 'Search additional log files',
			3 => 'Search backup zip ',
			4 => 'Search version ',
			5 => 'Search download file ',
			6 => 'Search delete file ',
			7 => 'Search backup log files ',
			8 => 'Search remove temp file ',
			9 => 'Search version update',
			10 => 'Search log update'
	);

	protected $successInfo = array(

			1 => 'Search update file complete! ',
			2 => 'Search additional log files complete! ',
			3 => 'Search backup zip complete! ',
			4 => 'Search version complete! ',
			5 => 'Search download file complete! ',
			6 => 'Search delete file complete! ',
			7 => 'Search backup log files complete! ',
			8 => 'Search remove temp file complete! ',
			9 => 'Search version update complete! ',
			10 => 'Search log update complete! '
	);

	 /**
     * 重写错误信息 - 并将错误信息写入错误日志 同时写入两个日志( LOCAL_LOG, LOCAL_UPDATE_ERROR )
     * [inforReceive description]
     * @param  string $pFunctionName [class and functionName]
     * @param  int $pParam           [0,1,2...]
     * @return [string]              [error: info]
     */
	public function inforReceive ( $pFunctionName = '', $pParam = '' ) {
		$message = parent::inforReceive( $pFunctionName, $pParam );
		$this->writeLog( $message, LOCAL_LOG );
		$this->writeLog( $message, LOCAL_UPDATE_ERROR );
	}

	/**
     * 重写正确信息 - 并将正确信息写入总日志 LOCAL_LOG
     * [successReceive description]
     * @param  string $pParam [class and functionName]
     * @param  string $pStr   [0,1,2...]
     * @return [string]       [success: info]
     */
	public function successReceive( $pParam = '', $pStr = '' ) {
		$message = parent::successReceive( $pParam, $pStr );
		$this->writeLog( $message, LOCAL_LOG );
	}

	

	

	

}