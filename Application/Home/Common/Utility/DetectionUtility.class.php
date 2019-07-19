<?php
/**
 * 文件检测类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Utility;

use Home\Common\Utility\FileBaseUtility as FileBase;
use Home\Supply\Log\Logs;

class DetectionUtility extends Logs
{

	public $errorInfo = array(

			1 => 'Search update file',
			2 => 'Search additional log files',
			3 => 'Search backup zip',
			4 => 'Search version',
			5 => 'Search download file',
			6 => 'Search delete file'
	);

	public $successInfo = array(

			1 => 'Search update file complete!',
			2 => 'Search additional log files complete!',
			3 => 'Search backup zip complete!',
			4 => 'Search version complete!',
			5 => 'Search download file complete!',
			6 => 'Search delete file complete!'
	);

	//检测文件
	public function scanFile( $pFilePath ) {
		return FileBase::detectionFile( $pFilePath );
	}
	
	//检测目录
	public function scanDir( $pFilePath ) {
		return FileBase::detectionDir( $pFilePath );
	}




}