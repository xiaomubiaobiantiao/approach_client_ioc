<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Pack;

//use Home\Common\Service\CommonService;
use Home\Service\Pack\PackLogService as PackLogs;
use Home\Model\PackModel;
use Home\Common\Utility\DetectionUtility as Detection;
use Home\Common\Utility\UploadUtility as Upload;
use Home\Common\Utility\DownloadUtility as Download;

class PackService extends PackLogs
{

	//初始化文本数据
	public function __construct() {
		parent::__construct();
		$this->PackModel = new PackModel();
	}

	//获取分类列表
	public function getSystemTypeList() {
		return $this->PackModel->systemTypeList();
	}

	//获取全部数据列表
	public function getDataList() {
		return $this->PackModel->data;
	}

	//获取单个分类的相关数据
	public function getTypeDataList( $pTypeId ) {
		if ( empty( $pTypeId ))
			return $this->getDataList();
		
		$typeDataList = $this->PackModel->typeDataList();
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

	//删除本地更新包过程
	public function deletePackProcess( $pId ) {
		$packFilePath = $this->PackModel->getPackPath( $pId );

		if ( is_file( $packFilePath )) {
			$this->PackModel->deletePack( $packFilePath );
			if ( is_file( $packFilePath ))
				return false;
		}

		false == PackLogs::scanFile( $filePath )
			? PackLogs::successReceive( 2, $filePath )
			: PackLogs::inforReceive( __METHOD__.' '.__LINE__.' '.$filePath, 2 );


		$this->PackModel->deletePack();
	}

	//下载更新包
	public function download( $pId ) {
		//获取更新包下载地址
		$packFilePath = $this->PackModel->getPackPath( $pId );
		//下载文件
		Download::down( $packFilePath, UPLOAD_PATH )
			? Download::successReceive( 1, UPLOAD_PATH )
			: Download::inforReceive( __METHOD__.' '.__LINE__.' '.$pId.$packFilePath.' '.UPLOAD_PATH, 1 );

		//组合下载后更新包的路径
		$filePath = rtrim( UPLOAD_PATH, '/' ).'/'.basename( $packFilePath );
		//检测文件是否存在
		PackLogs::scanFile( $filePath )
			? PackLogs::successReceive( 1, $filePath )
			: PackLogs::inforReceive( __METHOD__.' '.__LINE__.' '.$filePath, 1 );
		//设置更新包的状态信息为 1 已下载
		$this->PackModel->setStatusValue_1( $pId );
		//检测是否更新成功
		
		return true;
	}

	//文件上传配置
	public function fileUpload (){
		//检查上传路径,不存在则创建
		if ( FALSE == is_dir( UPLOAD_PATH )) mkdir( UPLOAD_PATH, 0777 );
		//检查文件是否存在重名
		if ( is_file( $_SERVER['DOCUMENT_ROOT'].'/'.ltrim( UPLOAD_PATH, '.' ).$_FILES['photo']['name'] )) {
			$this->error( '文件重名,请更改' );
			return FALSE;
		}
		//配置上传文件信息
		$config = array(
		    'maxSize'    =>    0,
		    'rootPath'   =>    UPLOAD_PATH,
		    'savePath'   =>    '',
		    'saveName'   =>    '',
		    'saveRule'	 =>	   '',
		    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg', 'rar', 'html', 'zip', 'txt'),
		    'autoSub'    =>    false,
		    'subName'    =>    array('date','Ymd'),
		);

		$Upload = new Upload();

		return $Upload->upload( $config );

	}

	//数据库添加信息
	public function addData() {
		//上传文件
		$resultName = $this->fileUpload();
		if ( false == $resultName ) $this->error( '上传失败！' );
		//拼接上传文件全路径
		$uploadPath =  $_SERVER['DOCUMENT_ROOT'].'/'.ltrim( UPLOAD_PATH, '.' ).$resultName;
		//整理需要添加的数据信息
		$data = array(
			'pack_name' => $resultName,
			'path' 	=> $uploadPath,
			'relative_path' => ltrim( UPLOAD_PATH, '.' ).$resultName,
			'download' => '',
			'user' => '目前为空',
			'type' => 1,
			'add_time' => time(),
			'update_time' => time()
		);
		//添加一条更新包记录
		$resultId = $this->PackModel->insertData( $data );
		//判断上传文件与数据库信息是否同步添加成功,如果非同步,则全部删除(删除数据库本次记录和本地上传的本次文件)
		if ( FALSE === $resultName || FALSE === $resultId || FALSE == is_file( $uploadPath )) {
			$this->deleteData( $pId );
			//$this->deleteData( $resultId );
			return false;
		}
		
		return true;

	}
	
	//查看数据
	public function checkData() {
		return $this->PackModel->getDataList();
	}

	//删除数据 - 待完善
	// public function deleteData( $pId ) {
	// 	die( 'aaab' );
	// 	$data = $this->PackModel->getDataOne( $pId );
	// 	if ( is_file( $data['path'] ))
	// 			unlink(  $data['path'] );

	// 	$this->PackModel->deleteAction( array( 'id'=>$pId ));

	// 	return true;

	// }



}