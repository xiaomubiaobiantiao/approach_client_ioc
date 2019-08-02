<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Update;

use Home\Model\PackModel;
use Home\Service\Update\UpdateParentService as Process;
use Home\Service\Update\UpdateFileService as GetPath;
use Home\Common\Utility\PclZipController as PclZip;
class UpdateService extends Process
{

	public function __construct() {
		parent::__construct();
		//生成数据库操作类
		$this->PackModel = new PackModel();
	}

	/* --------------------------------------------------------------------------- */
	/* ----- 本文数据操作 -------------------------------------------------------- */
	/* --------------------------------------------------------------------------- */
	
	//获取默认分类和相关数据 - 只取压缩包存在的数据
	public function getDefaultType() {
		$typeInfo = $this->getSystemTypeList();
		foreach ( $typeInfo as $key=>$value ) {
			$result = $this->getTypeDataList( $value['type'] );
			if ( false == empty( $result )) {
				$datalist[] = $typeInfo;
				$datalist[] = $result;
				$datalist[] = $value['type'];
				return $datalist;
			}
		}
	}

	//获取分类列表
	public function getSystemTypeList() {
		return $this->PackModel->systemTypeList();
	}

	//获取全部已下载的压缩包信息
	private function getLocalData() {
		return $this->PackModel->getTrueData();
	}

	//获取单个分类的相关数据
	private function getTypeDataList( $pTypeId ) {
		$typeDataList = $this->getLocalData();
		return $typeDataList[$pTypeId];
	}

	//返回系统分类列表和当前分类相关数据的和集
	public function dataCollection( $pTypeId ) {
		//下面赋值依次为分类列表,当前类别相关数据
		$dataList[] = $this->getSystemTypeList();
		$dataList[] = $this->getTypeDataList( $pTypeId );
		$dataList[] = $pTypeId;
		return $dataList;
	}

	/* --------------------------------------------------------------------------- */

	//更新压缩包的流程
	public function updatePackProcess( $pId ) {
		
		//初始化程序所需目录结构
		$this->initializeDir( 
			array( 
				BACKUP_PATH, BACKUP_TMP_PATH, UNPACK_TMP_PATH, 
				dirname( LOCAL_LOG ), 
				dirname( LOCAL_UPDATE_ERROR ), 
				dirname( LOCAL_RESTORE_ERROR )
			)
		);

		//初始化日志文件
		$this->initializeLog(
			array( LOCAL_LOG, LOCAL_UPDATE_ERROR, LOCAL_UPDATE_RECORD, LOCAL_RESTORE_ERROR, LOCAL_RESTORE_RECORD )
		);

		//打开数据库 取出更新包相应 ID
		$packInfo = $this->packInfo( $pId );

		//判断本地是否存在更新包文件 不存在则下载更新包 - 暂时未用
		//false == is_file( $packInfo['relative_path'] )
		//	? $unpackPath = $this->downFile( $packInfo['download'], UPLOAD_PATH )
		//	: $unpackPath = $packInfo['relative_path'];

		//根据ID解压文件到默认文件夹,自带创建目录的功能
		$this->unZip( UPLOAD_PATH.$packInfo['pack_name'], UNPACK_TMP_PATH );

		//检测压缩包文件 和 项目的文件
		$PathObj = new GetPath( array( UNPACK_TMP_PATH, UPDATE_PATH ));

		  // dump( $PathObj->fileOperation );
		//对比文件后得出需要替换的文件列表和需要追加的文件列表
		  // dump($PathObj->lastResult);
		  // die();
		//将需要替换的文件备份 - 添加全部日志 -添加备份日志
		
		//有需要备份的文件就执行以下操作
		if ( false == empty( $PathObj->lastResult['backUpFileList'] )) {

			//拷贝文件到备份临时目录
			$this->copyBackUpFile( 
				$PathObj->lastResult['backUpFilePathList'],
				$PathObj->lastResult['backUpFileList'],
				UPDATE_PATH,
				BACKUP_TMP_PATH
			);

			//创建备份文件日志 将需要备份的文件路径列表写入备份日志
			$backUpLogFilePath = $this->createBackUpFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['backUpFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-back.log'
			);

			//将备份日志文件路径存储到 $PathObj 类 的 backUpLogFilePath
			$PathObj->setBackUpLogPath( $backUpLogFilePath );

			//将替换日志路径去掉临时路径信息
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->backUpLogFilePath );

			//将替换日志路径写入到备份文件列表
			$PathObj->pushBackUpList( $tFilePath );

		}

		//有需要追加的文件的文件就就执行以下操作
		if ( false == empty( $PathObj->lastResult['addFileList'] )) {

			//创建追加文件日志 将需要追加的文件路径列表写入追加日志
			$addLogFilePath = $this->createAddFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['addFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-add.log'
			);

			//将日志文件路径存储到 $PathObj 类 的 addLogFilePath
			$PathObj->setAddLogPath( $addLogFilePath );

			//将临时目录的日志路径去掉临时路径信息
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->addLogFilePath );
			//将临时目录的日志路径写入到备份文件列表
			$PathObj->pushBackUpList( $tFilePath );
			
			//为写入文件争取停顿时间1秒
			$this->sleepOperation( 1 );

		}

		//有需要删除的文件就执行以下操作
		if ( false == empty( $PathObj->lastResult['deleteFileList'] )) {
			
			//删除项目文件流程
			$this->deleteProjectFile(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['deleteFileList'] )
			);

			//创建删除文件日志 将需要删除的文件路径列表写入删除日志
			$DelLogFilePath = $this->createDelFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['deleteFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-del.log'
			);

			//设置记录删除文件日志的路径 - 将删除日志文件路径存储到 $PathObj 类 的 delLogFilePath
			$PathObj->setDelLogPath( $DelLogFilePath );
			//将记录删除文件列表的 日志的路径 去掉临时路径信息 *-del.log
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->delLogFilePath );
			//将临时目录的删除日志路径写入到备份文件列表
			$PathObj->pushBackUpList( $tFilePath );

		}

		//将备份文件打包 并命名 备份文件包括( 替换的文件,替换文件的日志,追加文件的日志, 删除文件的日志 )
		if ( false == empty( $PathObj->lastResult['backUpFileList'] )) {
			$zipPath = $this->addZip( 
				BACKUP_PATH.date('Y_m_d').'-'.time().'_b.zip',
				$this->matchZipFileRootPath( BACKUP_TMP_PATH, $PathObj->lastResult['backUpFileList'] )
			);

			//将备份文件路径存储到 $PathObj 类 的 backUpPackFilePath
			$PathObj->setBackUpZipPath( $zipPath );
		}

		//将备份文件添加至文件 - 添加全部日志 - 添加备份日志

		
		// dump($PathObj->fileOperation);
		// dump($PathObj->lastResult);
		// die();
		
		//开始更新文件 - 添加全部日志 - 添加更新日志
		$this->copyUpdateFile(
			$PathObj->lastResult['updateFilePathList'],
			$PathObj->lastResult['updateAllFileList'],
			UPDATE_PATH,
			UNPACK_TMP_PATH
		);

		//更新或创建版本信息 - 版本信息如果没有 - 需先创建一个对方的起始版本信息留到备份处
		$this->updateVersion( VERSION_PATH, OLD_VERSION_PATH );
		
		/*-------------------------------------------------------------------------------------*/
		/*----- 检测系统 - 检测所有操作是否成功 -----------------------------------------------*/
		/*-------------------------------------------------------------------------------------*/

		//备份文件列表存在 则检测需要备份的文件压缩包是否创建成功
		if ( isset( $backUpLogFilePath ))
			$this->scanBackUpLog( $PathObj->backUpLogFilePath );

		//追加文件列表存在 则检测追加日志是否创建成功 - 如果追加列表为空则不检测
		if (  isset( $addLogFilePath ))
			$this->scanAddFileLog( $PathObj->addLogFilePath );

		//备份文件列表存在 则检测需要备份的文件压缩包是否创建成功
		if ( isset( $zipPath ))
			$this->scanBackUpZip( $PathObj->backUpPackFilePath );

		//删除文件列表存在 则检测需要删除的文件日志是否创建成功 并查看文件是否删除成功
		if ( isset( $DelLogFilePath )) {
			$this->scanDelFileLog( $PathObj->delLogFilePath );
			//检测需要删除的文件是否存在
			$tDelFileList = $this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['deleteFileList'] );
			//检测被删除的的文件是否存在
			$this->scanDelFile( $tAllFileList );
		}

		//将全部更新文件加上绝对路径信息
		$tAllFileList = $this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['updateAllFileList'] );
		//检测更新后的文件是否存在
		$this->scanUpdateFile( $tAllFileList );

		//查看日志是否更新成功
		$this->scanLog( LOCAL_LOG );
		
		//删除临时目录和备份目录里的所有文件
		$this->deleteTmpFile( array( BACKUP_TMP_PATH, UNPACK_TMP_PATH ));

		//搜索垃圾回收是否清理完成
		$this->scanRecycle( array( BACKUP_TMP_PATH, UNPACK_TMP_PATH ));

		//查看版本信息是否创建或更新完成
		$this->scanVersion( OLD_VERSION_PATH );
		
		/*-------------------------------------------------------------------------------------*/

		//添加一条操作信息到记录日志
		$this->recordInfo( LOCAL_UPDATE_RECORD );

	}

	//扫描旧的版本文件
	// public function searchVersion() {
	// 	$versionInfo = $this->readFile( VERSION_PATH );
		
	// 	if ( empty( $versionInfo ))
	// 		return VERSION_DEFAULT_INFO;
	// 	return $versionInfo;
	
	// }

	//获取旧的版本信息
	public function getVersion() {
		if( false == $this->checkFile( OLD_VERSION_PATH ))
			return VERSION_DEFAULT_INFO;
		
		$versionInfo = $this->readFile( OLD_VERSION_PATH );
		if ( empty( $versionInfo ))
	 		return VERSION_DEFAULT_INFO;

	 	return $versionInfo;
	}

	//将路径拼接到数组中的全部路径的前面
	private function matchZipFileRootPath( $pPath, $pArr ) {
		$data = array();
		foreach ( $pArr as $value )
			$data[] = $pPath.$value;
		return $data;
	}

	//睡眠 - 暂未用
	private function sleepOperation( $pLong = 1 ) {
		sleep( $pLong );
	}

	//返回一条压缩包相关信息
	private function packInfo( $pId ) {
		return $this->PackModel->getOnePackInfo( $pId );
	}

	//斜杠 '/' 修正 防止路径拼接错误 - 暂时未用 以后会移到类外部的
	private function addSlash() {

		$define = array(
			'UPDATE_PATH' => UPDATE_PATH,
			'UPLOAD_PATH' => UPLOAD_PATH,
			'BACKUP_PACK' => BACKUP_PACK,
			'BACKUP_TMP_PACK' => BACKUP_TMP_PACK,
			'UNPACK_TMP_PATH' => UNPACK_TMP_PATH
		);

		foreach ( $define as $key=>$value )
			$define[$key] = rtrim( $value, '/' ).'/';
		return $define;

	}


}