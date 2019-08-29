<?php
/**
 * ���ݿ�������
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Data;
use Home\Interfaces\Database;

class OracleData implements Database
{

	//��ʼ�����ݿ����
	public $server = '';
	public $user = '';
	public $pass = '';
	public $database = '';
	public $connect = '';

	//���ݿ�����
	public $dataConnect = '';

	//��ʼ�� - ����
	public function __construct( array $pParams ) {
		$this->setParam( $pParams );
	}

	//�������ݿ����
	public function setParam( array $pParams ) {
		$this->server = $pParams['server'];
		$this->user = $pParams['user'];
		$this->pass = $pParams['pass'];
		$this->database = $pParams['database'];
		$this->connect = $pParams['connect'];
	}

	//�������ݿ�
	public function connection() {
		echo __CLASS__;
		$this->dataConnect = odbc_connect( $this->connect, $this->user, $this->pass );
		return $this->dataConnect;
	}

	//ִ��Sql���
	public function exec( $pSql ) {
		return odbc_exec( $this->dataConnect, $pSql );
	}
	
	//ѭ����������
	public function fetchConnect( $pResources ) {
		while( $row = odbc_fetch_array( $pResources ))
			$result[] = $row;
		return $result;
	}

	//�鿴������
	public function numRows( $pResources ) {
		return odbc_num_rows( $pResources );
	}

	




}
