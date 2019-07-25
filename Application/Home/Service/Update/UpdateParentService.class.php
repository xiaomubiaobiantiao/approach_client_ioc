<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Update;

//use Home\Common\Service\CommonService;
use Home\Common\Utility\PclZipController as Zip;
use Home\Common\Utility\DownloadUtility as Download;
use Home\Common\Utility\FileBaseUtility as FileBase;
use Home\Service\Update\UpdateDetectionLogService as Detection;
use Home\Service\Update\UpdateLogService as ProcessLog;

class UpdateParentService //extends CommonService
{

	public function __construct() {
		$this->Proc = new ProcessLog();
		$this->Detection = new Detection();
		$this->Download = new Download();
	}

	protected function checkFile( $pVersionPath ) {
		return FileBase::checkFile( $pVersionPath );
	}

	//下载文件
	protected function downFile() {
		$this->Download->down();
	}

	//读取文件
	protected function readFile( $pFile ) {
		return FileBase::readFile( $pFile );
	}

	//替换版本文件
	protected function updateVersion( $pFilePath, $pNewPath ) {
		FileBase::copyFile( $pFilePath, $pNewPath )
			? $this->Proc->successReceive( 16, $pFilePath.'|'.$pNewPath )
			: $this->Proc->inforReceive(  __METHOD__.' '.__LINE__.' '.$pFilePath.'|'.$pNewPath, 12 );
	}

	//创建压缩文件
	public function addZip( $pZipPath, $pFilePathList ) {
		Zip::createZip( $pZipPath, $pFilePathList )
			? $this->Proc->successReceive( 1, $pZipPath.'|'.$pFilePathList )
			: $this->Proc->inforReceive(  __METHOD__.' '.__LINE__.' '.$pZipPath.'|'.$pFilePathList, 3 );
		return $pZipPath;
	}

	//释放压缩文件
	public function unZip( $pZipPath, $pToPath ) {
		Zip::unpackZip( $pZipPath, $pToPath )
			? $this->Proc->successReceive( 2, $pZipPath.'|'.$pToPath )
			: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pZipPath.'|'.$pToPath, 3 );
	}

	//初始化程序运行需要的目录
	public function initializeDir( $pDirArr ) {
		foreach ( $pDirArr as $value ) {
			if ( false == is_dir( $value ))
				FileBase::createDir( $value );
		}
	}

	//删除目录下的所有文件-
	public function deleteTmpFile( $pPathArr ) {
		foreach ( $pPathArr as $value ) {
		FileBase::deleteDir( $value )
			? $this->Proc->successReceive( 3, $value )
			: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$value, 6 );
		}
	}

	//copy备份文件操作流程 先循环创建目录,再循环创建文件
	public function copyBackUpFile( $pFilePathArr, $pFileArr, $pUpdatePath, $pBackUpPath ) {
		foreach ( $pFilePathArr as $value ) {
			FileBase::createDir( $pBackUpPath.$value );
			is_dir( $pBackUpPath.$value )
				? $this->Proc->successReceive( 9, $pBackUpPath.$value )
				: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pBackUpPath.$value, 7 );
		}
		foreach ( $pFileArr as $value ) {
			FileBase::copyFile( $pUpdatePath.$value, $pBackUpPath.$value )
				? $this->Proc->successReceive( 10, $pBackUpPath.$value )
				: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pUpdatePath.$value.' '.$pBackUpPath.$value.' ', 8 );
		}
		$this->Proc->successReceive( 6 );
	}

	//copy更新文件操作流程 先循环创建目录,再循环创建文件
	public function copyUpdateFile( $pFilePathArr, $pFileArr, $pUpdatePath, $pBackUpPath ) {
		foreach ( $pFilePathArr as $value ) {
			FileBase::createDir( $pUpdatePath.$value );
			is_dir( $pUpdatePath.$value )
				? $this->Proc->successReceive( 11, $pBackUpPath.$value )
				: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pUpdatePath.$value, 7 );
		}
		foreach ( $pFileArr as $value ) {
			FileBase::copyFile( $pBackUpPath.$value, $pUpdatePath.$value )
				? $this->Proc->successReceive( 12, $pUpdatePath.$value )
				: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pUpdatePath.$value.' '.$pUpdatePath.$value, 5 );	
		}
		$this->Proc->successReceive( 5 );
	}

	//--------------------------------------------------------------------------------------
	//将需要追加的文件列表写入到追加文件日志中
	public function createAddFileLog( $pContent, $pAddLogFilePath ) {
		FileBase::writeFile( $pContent, $pAddLogFilePath )
			? $this->Proc->successReceive( 4 )
			: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pAddLogFilePath, 1 );
		//$this->backUpPackFilePath = $pFilePath;
		return $pAddLogFilePath;
	}

	//将需要替换的文件列表写入到备份文件日志中
	public function createBackUpFileLog( $pContent, $pBackUpLogFilePath ) {
		FileBase::writeFile( $pContent, $pBackUpLogFilePath )
			? $this->Proc->successReceive( 15 )
			: $this->Proc->inforReceive( __METHOD__.' '.__LINE__.' '.$pBackUpLogFilePath, 11 );
		//$this->backUpPackFilePath = $pFilePath;
		return $pBackUpLogFilePath;
	}

	//检测更新后的文件是否存在
	public function scanUpdateFile( $pFilePathArr ) {
		foreach ( $pFilePathArr as $value ) {
			$this->Detection->scanFile( $value )
				? $this->Detection->successReceive( 1, $value )
				: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$value, 1 );
		}
	}

	//检测追加文件日志是否存在
	public function scanAddFileLog( $pAddLogPath ) {
		$this->Detection->scanFile( $pAddLogPath )
			? $this->Detection->successReceive( 2, $pAddLogPath )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$pAddLogPath, 2 );
	}

	//检测替换文件日志是否存在
	public function scanBackUpLog( $pBackUpLogPath ) {
		$this->Detection->scanFile( $pBackUpLogPath )
			? $this->Detection->successReceive( 7, $pBackUpLogPath )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$pBackUpLogPath, 7 );
	}

	//检测备份 zip 压缩包是否存在
	public function scanBackUpZip( $pBackUpZipPath ) {
		$this->Detection->scanFile( $pBackUpZipPath )
			? $this->Detection->successReceive( 3, $pBackUpPath )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$pBackUpZipPath, 3 );
	}

	//检测垃圾是否清理完成 - 不需要的临时文件
	public function scanRecycle( $pPathArr ) {
		foreach ( $pPathArr as $value ) {
			false == $this->Detection->scanDir( $value )
				? $this->Detection->successReceive( 8, $value )
				: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.$value, 8 );
		}
	}

	//检测版本信息是否更新完成
	public function scanVersion( $pVersionPath ) {
		$result = $this->Detection->scanFileInfo( $pVersionPath );
		( time()-$result < 60*2 )
			? $this->Detection->successReceive( 9, date("Y-m-d H:i:s",$result).'|'.date("Y-m-d H:i:s") )
			: $this->Detection->inforReceive( __METHOD__.' '.__LINE__.' '.date("Y-m-d H:i:s",$result).'|'.date("Y-m-d H:i:s"), 9 );
	}

	//--------------------------------------------------------------------------------------

}