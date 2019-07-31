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

			1 => 'restore Search update file ',
			2 => 'restore Search additional log files',
			3 => 'restore Search backup zip ',
			4 => 'restore Search version ',
			5 => 'restore Search download file ',
			6 => 'restore Search delete tmp file ',
			7 => 'restore Search backup log files ',
			8 => 'restore Search remove temp file ',
			9 => 'restore Search version update',
			10 => 'restore Search log update',
			11 => 'restore Search del log update'
	);

	protected $successInfo = array(

			1 => 'restore Search update file complete! ',
			2 => 'restore Search additional log files complete! ',
			3 => 'restore Search backup zip complete! ',
			4 => 'restore Search version complete! ',
			5 => 'restore Search download file complete! ',
			6 => 'restore Search delete tmp file complete! ',
			7 => 'restore Search backup log files complete! ',
			8 => 'restore Search remove temp file complete! ',
			9 => 'restore Search version update complete! ',
			10 => 'restore Search log update complete! ',
			11 => 'restore Search del log complete! '
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
		$this->writeLog( $message, LOCAL_RESTORE_ERROR );
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