<?php
/**
 * ���ݿ�������
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Data;
use Home\Interfaces\Database;

class SqlServerData implements Database
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
	public function __construct( array $pParams ) {
		$this->setParam( $pParams );
		$this->connection();
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
		$this->odbcConnect = odbc_connect( $this->connect, $this->user, $this->pass );
	}

	//ִ��Sql���
	public function exec( $pSql ) {
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
