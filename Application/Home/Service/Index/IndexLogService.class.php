<?php
/**
 * 全部日志信息
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Index;

use Home\Supply\Log\Logs;

class IndexLogService extends Logs
{

	public $errorInfo = array(
			1 => 'BackUp log',
			2 => 'Open dir resources',
			3 => 'Zip file',
			4 => 'Is dir',
			5 => 'Copy file update',
			6 => 'Delete tmp dir',
			7 => 'Create dir update',
			8 => 'Copy file backup',
			9 => 'Search update file',
			10 => 'Search backup log'
	);

	public $successInfo = array(
			1 => 'Create zip complete!',
			2 => 'Unzip complete!',
			3 => 'Delete tmp dir complete!',
			4 => 'BackUp log complete!',
			5 => 'Copy update file complete!',
			6 => 'Copy backup file complete!',
			7 => 'Search update file complete!',
			8 => 'Search backup log complete!',
			9 => 'Create a backup file path ',
			10 => 'Copy a backup file',
			11 => 'Create a update file path',
			12 => 'Copy a update file'
	);

	
}