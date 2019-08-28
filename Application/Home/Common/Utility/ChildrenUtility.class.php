<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Common\Utility;

use Home\Utility\Container;

class ChildrenUtility extends Container
{

	public function __construct() {
		$this->bindAbstrcact();
	}

	public function bind( $abstract = null, $concrete = null ) {
		return $this->_bind( $abstract, $concrete );
	}

	public function make( $concrete = null, $associated = null, $params = null, $bool = false ) {
		return $this->_make( $concrete, $associated, $params, $bool );
	}

	public function makeWith( $classInstance = null, $method = null, $methodAssociated = null, $methodParams = null, $bool = false ) {
		// dump( $classInstance );
		// dump( $method );
		// dump( $methodAssociated );
		// dump( $methodParams );
		// dump( $bool );
		return $this->_makeWith( $classInstance, $method, $methodAssociated, $methodParams, $bool );
	}

	public function bindAlias() {
        return array(
            'SqlServerData' => 'Home\Common\Data\SqlServerData',
            'MysqlData' => 'Home\Common\Data\MysqlData',
            'OracleData' => 'Home\Common\Data\OracleData',

            'DataType' => 'Home\Common\Utility\DataTypeUtility',
            'DataService' => 'Home\Service\Data\DataService'
        );
    }

    protected function bindAbstrcact() {
    	$this->bind( 'Home\Interfaces\Database', 'Home\Common\Data\SqlServerData' );
    	$this->bind( 'Home\Interfaces\Database', 'Home\Common\Data\MysqlData' );
    	$this->bind( 'Home\Interfaces\Database', 'Home\Common\Data\OracleData' );
    }


}