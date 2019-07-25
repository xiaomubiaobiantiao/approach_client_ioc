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

class UpdateDetectionLogService extends Detection
{

	protected $errorInfo = array(

			1 => 'Search update file ',
			2 => 'Search additional log files',
			3 => 'Search backup zip ',
			4 => 'Search version ',
			5 => 'Search download file ',
			6 => 'Search delete file ',
			7 => 'Search backup log files ',
			8 => 'Search remove ',
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
			8 => 'Search remove complete! ',
			9 => 'Search version update complete! ',
			10 => 'Search log update complete! '
	);

	public function inforReceive ( $pFunctionName = '', $pParam = '' ) {
		$message = parent::inforReceive( $pFunctionName, $pParam );
		$this->writeLog( $message, LOCAL_LOG );
		$this->writeLog( $message, LOCAL_UPDATE_ERROR );
	}

	public function successReceive( $pParam = '', $pStr = '' ) {
		$message = parent::successReceive( $pParam, $pStr );
		$this->writeLog( $message, LOCAL_LOG );
	}

	//获取文件修改时间
	public function scanFileInfo( $pFile ) {
		if ( false == $this->scanFile( $pFile ))
			return false;
		$handle = fopen( $pFile, "r" );
		$fileStat = fstat( $handle );
		return $fileStat["mtime"];
	}



}