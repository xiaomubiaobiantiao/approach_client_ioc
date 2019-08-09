<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Restore;

use Home\Service\Restore\RestoreParentService as Process;
use Home\Service\Restore\RestoreFileService as GetPath;
use Home\Common\Utility\PclZipController as PclZip;
//use Home\Common\Utility\FileBaseUtility as FileBase;

class RestoreService extends Process
{

	public function __construct() {
		parent::__construct();
	}

	/* --------------------------------------------------------------------------- */
	/* ----- �������ݲ��� -------------------------------------------------------- */
	/* --------------------------------------------------------------------------- */

	//��ȡ�����ļ��б�
	public function getBackUpZipList() {
		if ( is_dir( BACKUP_PATH )) {
			//return FileBase::checkAllFile( BACKUP_PATH );
			$backUpList = $this->checkDirFile( BACKUP_PATH );
			foreach ( $backUpList as $key=>$value ) {
				$str = explode( '-', basename( $value ));
				$str = explode( '_', $str[1] );
				$mTime[] = $str[0];
			}
			$fileMtime = $this->orderByData( $mTime );
			foreach ( $backUpList as $key=>$value ) {
				if ( strstr( $value, $fileMtime[0]))
					return $value;
			}
		}
			
	}

	/* --------------------------------------------------------------------------- */

	//����ѹ����������
	public function restoreBackUpProcess( $pBackUpFile ) {
		
		//��ʼ����������Ŀ¼�ṹ����־�ļ�
		$this->initializeFile();

		//����ID��ѹ�ļ���Ĭ���ļ���,�Դ�����Ŀ¼�Ĺ���
		$this->unZip( $pBackUpFile, UNPACK_TMP_PATH );

		//���ѹ�����ļ� �� ��Ŀ���ļ�
		$PathObj = new GetPath( array( UNPACK_TMP_PATH, UPDATE_PATH ));
		// dump($PathObj->fileOperation);
		// dump($PathObj->lastResult);
		// die( 'aaa');
		//����Ҫ���ݵ��ļ���ִ�����²���
		if ( false == empty( $PathObj->lastResult['mustBackUpFileList'] )) {

			//�����ļ���������ʱĿ¼
			$tData = $this->copyBackUpFile( 
				$PathObj->lastResult['mustBackUpFilePathList'],
				$PathObj->lastResult['mustBackUpFileList'],
				UPDATE_PATH,
				BACKUP_TMP_PATH
			);

			//�����Ҫ���ݵ��ļ��в����ڵ�,�ͽ�������Ҫѹ���ı����б�����ȥ��
			if ( false == empty( $tData ))
				$PathObj->lastResult['mustBackUpFileList']=array_diff( $PathObj->lastResult['mustBackUpFileList'], $tData);

			//���������ļ���־ ����Ҫ���ݵ��ļ�·���б�д�뱸����־
			$backUpLogFilePath = $this->createBackUpFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['mustBackUpFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-back.log'
			);
			// dump( $backUpLogFilePath );
			//��������־�ļ�·���洢�� $PathObj �� �� backUpLogFilePath
			$PathObj->setBackUpLogPath( $backUpLogFilePath );
			//����¼�����ļ��б�� ��־��·�� ȥ����ʱ·����Ϣ back.log
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->backUpLogFilePath );
			//���滻��־·��д�뵽�����ļ��б�
			$PathObj->pushBackUpList( $tFilePath );

		}
		
		//����Ҫ׷�ӵ��ļ��;�ִ�����²���
		if ( false == empty( $PathObj->lastResult['addFileList'] )) {

			//����׷���ļ���־ ����Ҫ׷�ӵ��ļ�·���б�д��׷����־
			$addLogFilePath = $this->createAddFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['addFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-add.log'
			);

			//��׷����־�ļ�·���洢�� $PathObj �� �� addLogFilePath
			$PathObj->setAddLogPath( $addLogFilePath );
			//����¼׷���ļ��б�� ��־��·�� ȥ����ʱ·����Ϣ add.log
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->addLogFilePath );
			//����ʱĿ¼����־·��д�뵽�����ļ��б�
			$PathObj->pushBackUpList( $tFilePath );
			
			//Ϊд���ļ���ȡͣ��ʱ��1��
			$this->sleepOperation( 1 );

		}

		//����Ҫɾ�����ļ���ִ�����²���
		if ( false == empty( $PathObj->lastResult['deleteFileList'] )) {
			
			//ɾ����Ŀ�ļ�����
			$tData = $this->deleteProjectFile( UPDATE_PATH, $PathObj->lastResult['deleteFileList'] );

			//����ֵ��Ϊ��ʱ - ȥ��ɾ���ļ��б������뷵��ֵ��ͬ���ļ�
			if ( false == empty( $tData ))
				$PathObj->lastResult['deleteFileList']=array_diff( $PathObj->lastResult['deleteFileList'], $tData);

			//����ɾ���ļ���־ ����Ҫ׷�ӵ��ļ�·���б�д��ɾ����־
			$tDelLogFilePath = $this->createDelFileLog(
				$this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['deleteFileList'] ),
				BACKUP_TMP_PATH . date('Y_m_d').'-'.time().'-del.log'
			);

			//��ɾ����־�ļ�·���洢�� $PathObj �� �� delLogFilePath
			$PathObj->setDelLogPath( $tDelLogFilePath );
			//����¼ɾ���ļ��б�� ��־��·�� ȥ����ʱ·����Ϣ *-del.log
			$tFilePath = str_replace( BACKUP_TMP_PATH, '', $PathObj->delLogFilePath );
			//����ʱĿ¼����־·��д�뵽�����ļ��б�
			$PathObj->pushBackUpList( $tFilePath );

		}

		//�������ļ���� ������ �����ļ�����( �滻���ļ�,�滻�ļ�����־,׷���ļ�����־, ɾ���ļ�����־ )
		if ( false == empty( $PathObj->lastResult['mustBackUpFileList'] )) {
			
			$zipPath = $this->addZip( 
				RESTORE_BACKUP_PATH.date('Y_m_d').'-'.time().'_r.zip',
				$this->matchZipFileRootPath( BACKUP_TMP_PATH, $PathObj->lastResult['mustBackUpFileList'] )
			);

			//�������ļ�·���洢�� $PathObj �� �� backUpPackFilePath
			$PathObj->setBackUpZipPath( $zipPath );
		}
		
		//��ʼ��ԭ�ļ� - ���ȫ����־ - ��ӻ�ԭ��־
		$this->copyUpdateFile(
			$PathObj->lastResult['backUpFilePathList'],
			$PathObj->lastResult['backUpFileList'],
			UPDATE_PATH,
			UNPACK_TMP_PATH
		);

		//���»򴴽��汾��Ϣ
		$this->updateVersion( VERSION_PATH, OLD_VERSION_PATH );
		
		/*-------------------------------------------------------------------------------------*/
		/*----- ���ϵͳ - ������в����Ƿ�ɹ� -----------------------------------------------*/
		/*-------------------------------------------------------------------------------------*/

		//�����ļ��б���� ���ⱸ����־�Ƿ񴴽��ɹ�
		if ( isset( $backUpLogFilePath ))
			$this->scanBackUpLog( $PathObj->backUpLogFilePath );

		//׷���ļ��б���� ����׷����־�Ƿ񴴽��ɹ� - ���׷���б�Ϊ���򲻼��
		if (  isset( $addLogFilePath ))
			$this->scanAddFileLog( $PathObj->addLogFilePath );

		//�����ļ��б���� ������Ҫ���ݵ��ļ�ѹ�����Ƿ񴴽��ɹ�
		if ( isset( $zipPath ))
			$this->scanBackUpZip( $PathObj->backUpPackFilePath );

		//ɾ���ļ��б���� ������Ҫɾ�����ļ���־�Ƿ񴴽��ɹ� ���鿴�ļ��Ƿ�ɾ���ɹ�
		if ( isset( $tDelLogFilePath )) {
			$this->scanDelFileLog( $PathObj->delLogFilePath );
			//�����Ҫɾ�����ļ��Ƿ����
			$tDelFileList = $this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['deleteFileList'] );
			//��ⱻɾ���ĵ��ļ��Ƿ����
			$this->scanDelFile( $tAllFileList );
		}

		//��ȫ�������ļ����Ͼ���·����Ϣ
		$tAllFileList = $this->matchZipFileRootPath( UPDATE_PATH, $PathObj->lastResult['backUpFileList'] );
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
		$this->recordInfo( LOCAL_RESTORE_RECORD );

	}

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
		foreach ( $pArr as $value )
			$data[] = $pPath.$value;
		return $data;
	}

	//˯�� - ��δ��
	private function sleepOperation( $pLong = 1 ) {
		sleep( $pLong );
	}

	//��ʼ����������Ŀ¼�ṹ����־�ļ�
	private function initializeFile() {
		//��ʼ����������Ŀ¼�ṹ
		$this->initializeDir(
			array( 
				BACKUP_PATH, BACKUP_TMP_PATH, UNPACK_TMP_PATH, RESTORE_BACKUP_PATH,
				dirname( LOCAL_LOG ), 
				dirname( LOCAL_UPDATE_ERROR ), 
				dirname( LOCAL_RESTORE_ERROR )
			)
		);

		//��ʼ����־�ļ�
		$this->initializeLog(
			array( LOCAL_LOG, LOCAL_UPDATE_ERROR, LOCAL_UPDATE_RECORD, LOCAL_RESTORE_ERROR, LOCAL_RESTORE_RECORD )
		);
	}

	//��ʱ���������� - Ĭ�ϴӴ�С
	private function orderByData( $pDataArr, $pStr = '>'  ) {
		$data = $pDataArr;
		$count = count( $data );
		for ( $i=0; $i<$count; $i++ ) {
			for ( $j=0; $j<$i; $j++ ) {
				if ( $pStr == '>' ) {
					if ( $data[$i] > $data[$j] ) {
						$tmp = $data[$i];
						$data[$i] = $data[$j];
						$data[$j] = $tmp;
					}
				} else {
					if ( $data[$i] < $data[$j] ) {
						$tmp = $data[$i];
						$data[$i] = $data[$j];
						$data[$j] = $tmp;
					}
				}
			}
		}
		return $data;
	}

}