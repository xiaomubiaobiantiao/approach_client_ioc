<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Utility;

class Container
{

	/**
     * binds instances.
     *
     * @var array
     */
	protected $binds = array();

	/**
     * set a singleton instance.
     *
     * @param  object $abstract
     * @param  string $concrete 
     * @return void
     */
	public function bind( $abstract, $concrete = NULL ) {
		$this->binds[$abstract] = $concrete == NULL ? $this->getInstance( $abstract ) : new $abstract( $this->binds[$concrete] );
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
	public function getInstance( $className, $params=array()) {
		
		$reflector = new ReflectionClass( $className );
		$constructor = $reflector->getConstructor();
		$subclassParams = $constructor ? $this->getDiParams( $constructor->getParameters() ) : array();
		return $reflector->newInstanceArgs( array_merge( $subclassParams, $params ) );
		
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

        if ( false == class_exists( $className ))
            throw new BadMethodCallException( "Class $class_name is not found!" );

        if ( false == method_exists( $className, $method ))
            throw new BadMethodCallException( "undefined method $method in $class_name !" );

		$instance = $this->getInstance( $className, $construct_params );
	    $reflector = new ReflectionClass( $className );
	    $reflectorMethod = $reflector->getMethod( $method );
	    $subclassParams = $reflectorMethod ? $this->getDiParams( $reflectorMethod->getParameters()) : array();
	    return call_user_func_array( array( $instance, $method ), array_merge( $subclassParams, $params ));

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