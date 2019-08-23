<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Utility;

use ReflectionClass;
use BadMethodCallException;
use Home\Common\Service\CommonService;

class Container
{

	/**
     * binds instances.
     *
     * @var array
     */
	protected $binds = array();
    protected $services = array();


    public function __construct() {
        $service = new CommonService();
        $this->services = $service->LoadService();
    }

	/**
     * set a singleton instance.
     *
     * @param  object $abstract
     * @param  string $concrete 
     * @return void
     */
	public function bind( $abstract, $concrete = null ) {
		$this->binds[$abstract] = $concrete == null ? $this->getInstance( $abstract ) : new $abstract( $this->binds[$concrete] );
	}

	/**
     * get a make instance.
     *
     * @param  string $className
     * @return mixed object or NULL
     */
	public function make( $className ) {
		return $this->binds[$className];
	}

	/**
     * get Instance from reflection info.
     *
     * @param  string  $className
     * @param  array  $params 
     * @return object
     */
	public function getInstance( $className, $params = array() ) {
        
        if ( $this->services[$className] )
            $className = $this->services[$className];
        if ( false == class_exists( $className )) die( 'class not found' );
		$reflector = new ReflectionClass( $className );
        if ( $reflector->isInterface() ) return array_merge( $className, $params );
		$constructor = $reflector->getConstructor();
		$subclassParams = $constructor ? $this->getDiParams( $constructor->getParameters() ) : array();
        array_push( $subclassParams, $params );
		return $reflector->newInstanceArgs( $subclassParams );
		
	}

	/**
     * run class method.
     *
     * @param  string $className
     * @param  string $method
     * @param  array  $params
     * @param  array  $construct_params
     * @return mixed
     * @throws \BadMethodCallException
     */
	public function run( $className, $method, $params = array(), $construct_params = array() ) {

        if ( $this->services[$className] )
            $className = $this->services[$className];
        if ( false == class_exists( $className )) die( 'class not found' );
		$instance = $this->getInstance( $className, $construct_params );
	    $reflector = new ReflectionClass( $className );
	    $reflectorMethod = $reflector->getMethod( $method );
	    $subclassParams = $reflectorMethod ? $this->getDiParams( $reflectorMethod->getParameters()) : array(); 
        array_push( $subclassParams, $params );
        return call_user_func_array( array( $instance, $method ), $subclassParams );
        
	}

	/**
     * create Dependency injection params.
     *
     * @param  array $params
     * @return array
     */
    public function getDiParams( array $params )
    {
        $subclassParams = array();
        foreach ( $params as $param ) {
            $class = $param->getClass();
            if ( false == empty( $class ))
                $subclassParams[] = $this->getInstance( $class->name );
        }
        return $subclassParams;
    }

    /**
     * get bind class or method
     *
     * @return array()
     */
	public function getBind() {
		return $this->binds;
	}

    public function getServices() {
        return $this->services;
    }

	/**
     * print the result set
     *
     * @param  array $params
     * @return The output to the browser
     */
	public function dump( $pParam ) {
		if ( empty( $pParam )) {
			print_r( 'NULL' ).'<br>';
		} else {
			// print_r( $pParam );echo '<br>';
			var_dump( $pParam );echo '<br>';
		}
	}


}