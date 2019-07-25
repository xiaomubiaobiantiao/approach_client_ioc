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
			12 => 'Version update'

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
			16 => 'Version update complete! '

	);

	public function inforReceive ( $functionName = '', $param = '' ) {
		echo 1111;
		dump( $functionName );
		dump( $param );
		parent::inforReceive( $functionName = '', $param = '' );

	}

	public function successReceive( $param = '', $pStr = '' ) {
		echo 2222;
		dump( $param );
		dump( $pStr );
		parent::successReceive(  $param = '', $pStr = '' );
	}
	
}