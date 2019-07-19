<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Index;

use Home\Service\Index\IndexParentService as Process;
use Home\Service\Index\IndexFileService as GetPath;

class IndexService extends Process
{

	public function __construct() {
		parent::__construct();
		$this->PackModel = D( 'Pack' );
		//查看当前版本
	}

	//返回所有压缩包信息
	public function getUpdatePack() {
		//return $this->PackModel->getPageDataType( '', array('type'=>1), 0, 10, 'update_time' );
	}

	//更新压缩包的流程
	public function updatePackProcess( $pId ) {
		// $conn = oci_connect( 'wjz', 'wjz', "192.168.1.107/orcl" );
		// echo $conn;
		// phpinfo();
		// die();
		//扫描当前版本
		$this->searchVersion( VERSION_PATH );

		//将数据库数据转换成文本 - 临时测试用 - 不包含在本方法流程中

		$files = 'id, pack_name, type, type_name, download';
		$data = $this->PackModel->getPageDataType( $files, array('type'=>1), 0, 10, 'update_time' );
		//dump( $data );
		$this->arrConversionStr( $data );
		die();
		$this->updatePackText( $data, 'Public/pack_path.txt' );


		die();
		//打开数据库 取出更新包相应 ID
		$packInfo = $this->packInfo( $pId );

		//创建工作目录

		//判断本地是否存在更新包文件 不存在则下载更新包 - 暂时无效
		//false == is_file( $packInfo['relative_path'] )
		//	? $unpackPath = $this->downFile( $packInfo['download'], UPLOAD_PATH )
		//	: $unpackPath = $packInfo['relative_path'];

		//对比更新包信息

		

		//根据ID解压文件到默认文件夹,自带创建目录的功能
		$this->unZip( $packInfo['relative_path'], UNPACK_TMP_PATH );

		//检测压缩包文件 和 项目的文件
		$PathObj = new GetPath( array( UNPACK_TMP_PATH, UPDATE_PATH ));
		//dump( $FileObj->fileOperation );
		//对比文件后得出需要替换的文件列表和需要追加的文件列表
		//dump($FileObj->lastResult);
		//将需要替换的文件备份 - 添加全部日志 -添加备份日志
		$this->copyBackUpFile( 
			$PathObj->lastResult['backUpFilePathList'], 
			$PathObj->lastResult['backUpFileList'], 
			UPDATE_PATH,
			BACKUP_TMP_PACK 
		);
		//dump($FileObj->lastResult);
		//将需要追加的文件写入到一个追加文件日志中  - 添加全部日志 - 添加备份日志
		
		$addLogFilePath = $this->addFileLogBackUp(
			$this->matchZipFileRootPath( UPDATE_PATH, $FileObj->lastResult['addFileList'] ),
			BACKUP_TMP_PACK . date('Y_m_d').'-'.time().'-add.log'
		);

		//将日志文件路径存储到 $PathObj 类 的 addLogFilePath
		$PathObj->setLogFilePath( $addLogFilePath );

		//将日志路径写入到备份文件列表
		$PathObj->lastResult['backUpFileList'][] = str_replace( BACKUP_TMP_PACK, '', $PathObj->addLogFilePath);

		//为写入文件争取停顿时间1秒
		$this->sleepOperation( 1 );

		//将备份文件打包,并命名 - 添加全部日志 - 添加备份日志
		$zipPath = $this->addZip( 
			BACKUP_PACK . date('Y_m_d').'-'.time().'b.zip',
			$this->matchZipFileRootPath( BACKUP_TMP_PACK, $PathObj->lastResult['backUpFileList'] )
		);

		//将备份文件添加至文件 - 添加全部日志 - 添加备份日志
		
		//将备份文件路径存储到 $PathObj 类 的 backUpPackFilePath
		$PathObj->setBackUpPath( $zipPath );

		

		//开始更新文件 - 添加全部日志 - 添加更新日志
		$this->copyUpdateFile( 
			$PathObj->lastResult['updateFilePathList'], 
			$PathObj->lastResult['updateAllFileList'], 
			UPDATE_PATH, 
			UNPACK_TMP_PATH
		);

		//创建版本信息


		//检测所有操作是否成功

		//检测备份日志是否存在
		$this->scanAddFileLog( $PathObj->addLogFilePath );

		//检测需要备份的文件压缩包是否存在
		$this->scanBackUpPath( $PathObj->backUpPackFilePath );

		//检测更新后的文件是否存在
		$this->scanUpdateFile( $this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['updateAllFileList'] ));

		//查看日志是否更新成功
		
		//删除临时目录和备份目录里的所有文件
		$this->deleteTmpFile( array( BACKUP_TMP_PACK, UNPACK_TMP_PATH ));
		//查看垃圾回收机制是否清理完成

		//查看版本信息是否创建或更新完成
		
		
	}



	//将路径拼接到数组中的全部路径的前面
	private function matchZipFileRootPath( $pPath, $pArr ) {
		$data = array();
		foreach ( $pArr as $value )
			$data[] = $pPath.$value;
		return $data;
	}

	//睡眠
	private function sleepOperation( $pLong=1 ) {
		sleep( $pLong );
	}

	//返回压缩包相关信息
	private function packInfo( $pId ) {
		return $this->PackModel->getDataOne( array( 'id'=>$pId ));
	}

	//解压缩
	private function plcZip( $pPath ) {
		
	}


}