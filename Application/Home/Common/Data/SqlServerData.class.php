<?php
/**
 * ���ݿ�������
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Data;

class SqlServerData
{

	//��ʼ�����ݿ����
	public $server = '';
	public $user = '';
	public $pass = '';
	public $database = '';
	public $connect = '';

	//���ݿ�����
	public $odbcConnect = '';

	//��ʼ�� - ����
	public function __construct( $pDataType, $pParamArr ) {
		$this->setParam( $pParamArr );
		$this->linkDataBase();
	}

	//�������ݿ����
	public function setParam( $pParamArr ) {
		$this->server = $pParamArr['server'];
		$this->user = $pParamArr['user'];
		$this->pass = $pParamArr['pass'];
		$this->database = $pParamArr['database'];
		$this->connect = $pParamArr['connect'];
	}

	//�������ݿ�
	public function linkDataBase() {
		$this->odbcConnect = odbc_connect( $this->connect, $this->user, $this->pass );
	}

	//ִ��Sql���
	public function odbcExec( $pSql ) {
		return odbc_exec( $this->odbcConnect, $pSql );
	}
	
	//ѭ����������
	public function fetchConnect( $pArr ) {
		while( $row = odbc_fetch_array( $pArr ))
			dump( $row );
	}

	//�鿴������
	public function numRows() {
		return odbc_num_rows( $result );
	}

	




}
