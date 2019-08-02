<?php
/**
 * 全部日志信息
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Update;

use Home\Supply\Log\Logs;

class RestoreLogService extends Logs
{

	public $errorInfo = array(
			1 => 'restore Crate add log ',
			2 => 'restore Open dir resources ',
			3 => 'restore Zip file ',
			4 => 'restore Is dir ', 
			5 => 'restore Copy file update ',
			6 => 'restore Delete tmp dir ',
			7 => 'restore Create dir update ',
			8 => 'restore Copy file backup ',
			9 => 'restore Search a update file ',
			10 => 'restore Search backup log ',
			11 => 'restore Backup log ',
			12 => 'restore Version update',
			15 => 'restore Create log',
			16 => 'restore Create del file ',
			16 => 'restore Delete file ',
			17 => 'restore Del project file'

	);

	public $successInfo = array(
			1 => 'restore Create zip complete! ',
			2 => 'restore Unzip complete! ',
			3 => 'restore Delete tmp dir complete! ',
			4 => 'restore Create add file log complete! ',
			5 => 'restore Copy update file complete! ',
			6 => 'restore Copy backup file complete! ',
			7 => 'restore Search a update file ',
			8 => 'restore Search backup log complete! ',
			9 => 'restore Create a backup file path ',
			10 => 'restore Copy a backup file ',
			11 => 'restore Create a update file path ',
			12 => 'restore Copy a update file ',
			15 => 'restore Create Backup file log complete! ',
			16 => 'restore Version update complete! ',
			17 => 'restore Create log complete! ',
			18 => 'restore Create del file log complete! ',
			19 => 'restore Delete a file ',
			19 => 'restore Del a project file '

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

	//记录本次操作信息到日志 - 自定义日志
	public function customLogFile( $pLogPath ) {
		$this->writeLog( $this->getUpdateInfo(), $pLogPath );
	}

	//每更新一次,记录一次相关信息,如时间,地点,操作者,所属组等 - 目前只有时间
	public function getUpdateInfo() {
		return '['.date( 'Y-m-d h:i:s').'] '.' username: Yang'.' <|> '.'group: 1';
	}

	
	
}