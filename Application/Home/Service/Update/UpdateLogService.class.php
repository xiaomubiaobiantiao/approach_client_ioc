<?php
/**
 * 全部日志信息
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Update;

use Home\Supply\Log\Logs;

class UpdateLogService extends Logs
{

	public $errorInfo = array(
			1 => 'Add log ',
			2 => 'Open dir resources ',
			3 => 'Zip file ',
			4 => 'Is dir ', 
			5 => 'Copy file update ',
			6 => 'Delete tmp dir ',
			7 => 'Create dir update ',
			8 => 'Copy file backup ',
			9 => 'Search a update file ',
			10 => 'Search backup log ',
			11 => 'Backup log ',
			12 => 'Version update ',
			15 => 'Create log ',
			16 => 'Create del log file ',
			17 => 'Del project del file' ,
			18 => 'Create version info '


	);

	public $successInfo = array(
			1 => 'Create zip complete! ',
			2 => 'Unzip complete! ',
			3 => 'Delete tmp dir complete! ',
			4 => 'Create add file log complete! ',
			5 => 'Copy update file complete! ',
			6 => 'Copy backup file complete! ',
			7 => 'Search a update file ',
			8 => 'Search backup log complete! ',
			9 => 'Create a backup file path ',
			10 => 'Copy a backup file ',
			11 => 'Create a update file path ',
			12 => 'Copy a update file ',
			15 => 'Create Backup file log complete! ',
			16 => 'Version update complete! ',
			17 => 'Create log complete! ',
			18 => 'Create del file log complete! ',
			19 => 'Del a project file ',
			20 => 'Dont find Del a del-log project file ',
			21 => 'Create version info complete! '

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

	//记录本次操作信息到日志 - 自定义日志
	public function customLogFile( $pLogPath ) {
		$this->writeLog( $this->getUpdateInfo(), $pLogPath );
	}

	//每更新一次,记录一次相关信息,如时间,地点,操作者,所属组等 - 目前只有时间
	public function getUpdateInfo() {
		return '['.date( 'Y-m-d h:i:s').'] '.' username: Yang'.' <|> '.'group: 1';
	}

	
	
}