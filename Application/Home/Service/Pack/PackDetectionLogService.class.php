<?php
/**
 * 继承文件检测类 - 文件检测类继承 log 日志类
 * 只服务于 PackService
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Pack;

use Home\Supply\Detection\Detection;

class PackDetectionLogService extends Detection
{

	//失败结果集
	public $errorInfo = array(
			1 => 'Download file ',				//下载文件失败
			2 => 'Delete file ',				//删除文件失败
			3 => 'File does not exist ',		//文件不存在
			4 => 'Download status update ',		//下载状态更新失入
			5 => 'Set status '
	);

	//成功结果集
	public $successInfo = array(
			1 => 'Download file complete! ',			//下载文件成功
			2 => 'Delete file complete! ',				//删除文件成功
			3 => 'Download status update complete! ',	//删除文件成功
			4 => 'Set status complete! '
	);

	//查看 bool值 结果
	public function checkBoolValue( $pBoolValue ) {
		$pBoolValue == 1 ? $value = true : $value = false;
		return $value;
	}


}