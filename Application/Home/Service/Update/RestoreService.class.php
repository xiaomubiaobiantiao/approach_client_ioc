<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Update;

use Home\Service\Update\UpdateParentService as Process;
use Home\Service\Update\RestoreFileService as GetPath;
use Home\Common\Utility\PclZipController as PclZip;
use Home\Common\Utility\FileBaseUtility as FileBase;

class RestoreService extends Process
{

	public function __construct() {
		parent::__construct();
	}

	/* --------------------------------------------------------------------------- */
	/* ----- �������ݲ��� -------------------------------------------------------- */
	/* --------------------------------------------------------------------------- */
	
	//��ȡĬ�Ϸ����������� - ֻȡѹ�������ڵ�����
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

	//��ȡ�����ļ��б�
	public function getBackUpZipList() {
		//return $this->PackModel->systemTypeList();
		if ( is_dir( BACKUP_PATH ))
			return FileBase::checkAllFile( BACKUP_PATH );
	}

	//��ȡȫ�������ص�ѹ������Ϣ
	private function getLocalData() {
		return $this->PackModel->getTrueData();
	}

	//��ȡ����������������
	private function getTypeDataList( $pTypeId ) {
		$typeDataList = $this->getLocalData();
		return $typeDataList[$pTypeId];
	}

	//����ϵͳ�����б�͵�ǰ����������ݵĺͼ�
	public function dataCollection( $pTypeId ) {
		//���渳ֵ����Ϊ�����б�,��ǰ����������
		$dataList[] = $this->getSystemTypeList();
		$dataList[] = $this->getTypeDataList( $pTypeId );
		$dataList[] = $pTypeId;
		return $dataList;
	}

	/* --------------------------------------------------------------------------- */

	//����ѹ����������
	public function restoreBackUpProcess( $pBackUpFile ) {

		//��ʼ����������Ŀ¼�ṹ
		$this->initializeDir(
			array( 
				BACKUP_PATH, BACKUP_TMP_PATH, UNPACK_TMP_PATH, 
				dirname( LOCAL_LOG ), 
				dirname( LOCAL_UPDATE_ERROR ), 
				dirname( LOCAL_RESTORE_ERROR )
			)
		);

		//��ʼ����־�ļ�
		$this->initializeLog(
			array( LOCAL_LOG,LOCAL_UPDATE_ERROR, LOCAL_UPDATE_RECORD, LOCAL_RESTORE_ERROR, LOCAL_RESTORE_RECORD )
		);

		//����ID��ѹ�ļ���Ĭ���ļ���,�Դ�����Ŀ¼�Ĺ���
		//$this->unZip( $pBackUpFile, UNPACK_TMP_PATH );

		//���ѹ�����ļ� �� ��Ŀ���ļ�
		$PathObj = new GetPath( array( UNPACK_TMP_PATH, UPDATE_PATH ));
		// dump( $PathObj->fileOperation );
		// dump( $PathObj->lastResult );
		//dump( $PathObj->fileOperation);
		die();

		//����Ҫ���ݵ��ļ���ִ�����²���
		if ( false == empty( $PathObj->lastResult['backUpFileList'] )) {

			//�����ļ���������ʱĿ¼
			$this->copyBackUpFile( 
				$PathObj->lastResult['backUpFilePathList'],
				$PathObj->lastResult['backUpFileList'],
				UPDATE_PATH,
				BACKUP_TMP_PATH
			);

			//���������ļ���־ ����Ҫ���ݵ��ļ�·���б�д�뱸����־
			$backUpLogFilePath = $this->createBackUpFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['backUpFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-back.log'
			);

			//��������־�ļ�·���洢�� $PathObj �� �� backUpLogFilePath
			$PathObj->setBackUpLogPath( $backUpLogFilePath );

			//���滻��־·��ȥ����ʱ·����Ϣ
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->backUpLogFilePath );

			//���滻��־·��д�뵽�����ļ��б�
			$PathObj->pushBackUpList( $tFilePath );

		}

		//����Ҫ׷�ӵ��ļ����ļ��;�ִ�����²���
		if ( false == empty( $PathObj->lastResult['addFileList'] )) {

			//����׷���ļ���־ ����Ҫ׷�ӵ��ļ�·���б�д��׷����־
			$addLogFilePath = $this->createAddFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['addFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-add.log'
			);

			//����־�ļ�·���洢�� $PathObj �� �� addLogFilePath
			$PathObj->setAddLogPath( $addLogFilePath );

			//����ʱĿ¼����־·��ȥ����ʱ·����Ϣ
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->addLogFilePath );
			//����ʱĿ¼����־·��д�뵽�����ļ��б�
			$PathObj->pushBackUpList( $tFilePath );
			
			//Ϊд���ļ���ȡͣ��ʱ��1��
			$this->sleepOperation( 1 );

		}

		//�������ļ���� ������ �����ļ�����( �滻���ļ�,�滻�ļ�����־,׷���ļ�����־ )
		if ( false == empty( $PathObj->lastResult['backUpFileList'] )) {
			$zipPath = $this->addZip( 
				BACKUP_PATH.date('Y_m_d').'-'.time().'_b.zip',
				$this->matchZipFileRootPath( BACKUP_TMP_PATH, $PathObj->lastResult['backUpFileList'] )
			);

			//�������ļ�·���洢�� $PathObj �� �� backUpPackFilePath
			$PathObj->setBackUpZipPath( $zipPath );
		}

		//�������ļ�������ļ� - ���ȫ����־ - ��ӱ�����־

		
		// dump($PathObj->fileOperation);
		// dump($PathObj->lastResult);
		// die();
		
		//��ʼ�����ļ� - ���ȫ����־ - ��Ӹ�����־
		$this->copyUpdateFile(
			$PathObj->lastResult['updateFilePathList'],
			$PathObj->lastResult['updateAllFileList'],
			UPDATE_PATH,
			UNPACK_TMP_PATH
		);

		//���»򴴽��汾��Ϣ
		$this->updateVersion( VERSION_PATH, OLD_VERSION_PATH );
		
		/*-------------------------------------------------------------------------------------*/
		/*----- ���ϵͳ - ������в����Ƿ�ɹ� -----------------------------------------------*/
		/*-------------------------------------------------------------------------------------*/

		//�����ļ��б�Ϊ�� ������Ҫ���ݵ��ļ�ѹ�����Ƿ����
		if ( isset( $backUpLogFilePath ))
			$this->scanBackUpLog( $PathObj->backUpLogFilePath );

		//׷���ļ��б�Ϊ�� ����׷����־�Ƿ���� - ���׷���б�Ϊ���򲻼��
		if (  isset( $addLogFilePath ))
			$this->scanAddFileLog( $PathObj->addLogFilePath );

		//�����ļ��б�Ϊ�� ������Ҫ���ݵ��ļ�ѹ�����Ƿ����
		if ( isset( $zipPath ))
			$this->scanBackUpZip( $PathObj->backUpPackFilePath );

		//��ȫ�������ļ����Ͼ���·����Ϣ
		$tAllFileList = $this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['updateAllFileList'] );
		//�����º���ļ��Ƿ����
		$this->scanUpdateFile( $tAllFileList );

		//�鿴��־�Ƿ���³ɹ�
		$this->scanLog( LOCAL_LOG );
		
		//ɾ����ʱĿ¼�ͱ���Ŀ¼��������ļ�
		$this->deleteTmpFile( array( BACKUP_TMP_PATH, UNPACK_TMP_PATH ));

		//�������������Ƿ��������
		$this->scanRecycle( array( BACKUP_TMP_PATH, UNPACK_TMP_PATH ));

		//�鿴�汾��Ϣ�Ƿ񴴽���������
		$this->scanVersion( OLD_VERSION_PATH );
		
		/*-------------------------------------------------------------------------------------*/

		//���һ��������Ϣ����¼��־
		$this->recordInfo( LOCAL_UPDATE_RECORD );

	}

	//ɨ��ɵİ汾�ļ�
	// public function searchVersion() {
	// 	$versionInfo = $this->readFile( VERSION_PATH );
		
	// 	if ( empty( $versionInfo ))
	// 		return VERSION_DEFAULT_INFO;
	// 	return $versionInfo;
	
	// }

	//��ȡ�ɵİ汾��Ϣ
	public function getVersion() {
		if( false == $this->checkFile( OLD_VERSION_PATH ))
			return VERSION_DEFAULT_INFO;
		
		$versionInfo = $this->readFile( OLD_VERSION_PATH );
		if ( empty( $versionInfo ))
	 		return VERSION_DEFAULT_INFO;

	 	return $versionInfo;
	}

	//��·��ƴ�ӵ������е�ȫ��·����ǰ��
	private function matchZipFileRootPath( $pPath, $pArr ) {
		$data = array();
		foreach ( $pArr as $value )
			$data[] = $pPath.$value;
		return $data;
	}

	//˯�� - ��δ��
	private function sleepOperation( $pLong = 1 ) {
		sleep( $pLong );
	}

	//����һ��ѹ���������Ϣ
	private function packInfo( $pId ) {
		return $this->PackModel->getOnePackInfo( $pId );
	}

	//б�� '/' ���� ��ֹ·��ƴ�Ӵ��� - ��ʱδ�� �Ժ���ܻ��Ƶ����ⲿ��
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